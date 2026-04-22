<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreReservationRequest;
use App\Models\Logement;
use App\Models\Reservation;
use Illuminate\Support\Facades\Auth;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use App\Models\MonthlyPayment;

class ReservationController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreReservationRequest $request, Logement $logement)
    {
        $logementReserved = Reservation::where('logement_id', $logement->id)
            ->whereIn('status', ['pending', 'paid'])
            ->exists();

        if ($logementReserved) {
            return back()->with('error', 'Ce logement est déjà réservé.');
        }

        $totalPrice = $logement->price;
        $depositAmount = $totalPrice * 0.10;

        $reservation = Reservation::create([
            'user_id' => Auth::id(),
            'logement_id' => $logement->id,
            'total_price' => $totalPrice,
            'deposit_amount' => $depositAmount,
            'payment_method' => 'stripe',
            'payment_status' => 'pending',
            'status' => 'pending',
            'start_date' => now(),
        ]);

        Stripe::setApiKey(config('services.stripe.secret'));

        $session = Session::create([
            'mode' => 'payment',
           'success_url' => route('reservations.success', $reservation),
            'cancel_url' => route('reservations.cancelCheckout', $reservation),
            'line_items' => [[
                'quantity' => 1,
                'price_data' => [
                    'currency' => 'usd',
                    'unit_amount' => (int) ($depositAmount * 100),
                    'product_data' => [
                        'name' => 'Acompte réservation',
                    ],
                ],
            ]],
        ]);

        return redirect($session->url);
    }

    public function cancel(Reservation $reservation)
    {
        $this->authorize('cancel', $reservation);

        $hours = now()->diffInHours($reservation->start_date);

        if ($hours >= 24) {
            $reservation->update([
                'status' => 'cancelled',
                'cancelled_at' => now(),
            ]);

            return back()->with('success', 'Remboursement effectué.');
        } else {
            $reservation->update([
                'status' => 'cancelled',
                'cancelled_at' => now(),
            ]);

            return back()->with('error', 'Annulation tardive. Pas de remboursement.');
        }
    }

    public function confirmPayment(Reservation $reservation)
    {
        $this->authorize('confirmPayment', $reservation);

        if ($reservation->status !== 'pending') {
            return back()->with('error', 'Impossible de confirmer ce paiement.');
        }

        $reservation->update([
            'payment_status' => 'verified',
            'status' => 'paid',
        ]);

        return back()->with('success', 'Paiement confirmé.');
    }

public function success(Reservation $reservation)
{
    $this->authorize('cancel', $reservation);

    if ($reservation->payment_status !== 'paid') {
        $reservation->update([
            'payment_status' => 'paid',
            'status' => 'paid',
        ]);
    }

    if ($reservation->monthlyPayments()->count() === 0) {
        MonthlyPayment::create([
            'reservation_id' => $reservation->id,
            'amount' => $reservation->total_price,
            'due_date' => now()->addMonth()->toDateString(),
            'status' => 'pending',
        ]);
    }

    return redirect()
        ->route('logements.show', $reservation->logement_id)
        ->with('success', 'Paiement effectué avec succès.');
}

    public function cancelCheckout(Reservation $reservation)
    {
        $this->authorize('cancel', $reservation);

        return redirect()
            ->route('logements.show', $reservation->logement_id)
            ->with('error', 'Paiement annulé.');
    }
}
