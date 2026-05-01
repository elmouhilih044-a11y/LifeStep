<?php

namespace App\Services;

use App\Models\Reservation;
use App\Models\Logement;
use App\Models\MonthlyPayment;
use Illuminate\Support\Facades\Auth;
use Stripe\Stripe;
use Stripe\Checkout\Session;

class ReservationService
{
    public function create($request, Logement $logement)
    {
        $logementReserved = Reservation::where('logement_id', $logement->id)
            ->whereIn('status', ['pending', 'confirmed'])
            ->exists();

        if ($logementReserved) {
            return [
                'error' => true,
                'message' => 'Ce logement est déjà réservé.'
            ];
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
            'start_date' => $request->start_date,
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

        return [
            'error' => false,
            'url' => $session->url
        ];
    }

    public function cancel(Reservation $reservation)
    {
        $now = now();
        $startDate = $reservation->start_date;

        if ($startDate->isPast()) {
            return [
                'error' => true,
                'message' => 'Impossible d’annuler une réservation déjà commencée.'
            ];
        }

        $hours = $startDate->diffInRealHours($now);

        foreach ($reservation->monthlyPayments as $payment) {
            if ($payment->status === 'pending') {
                $payment->update(['status' => 'cancelled']);
            }
        }

        $reservation->update([
            'status' => 'cancelled',
            'cancelled_at' => $now,
        ]);

        Logement::where('id', $reservation->logement_id)
            ->update(['status' => 'available']);

        return [
            'error' => false,
            'refund' => $hours < 24
        ];
    }

    public function confirmPayment(Reservation $reservation)
    {
        if ($reservation->status !== 'pending') {
            return [
                'error' => true,
                'message' => 'Impossible de confirmer ce paiement.'
            ];
        }

        $reservation->update([
            'payment_status' => 'paid',
            'status' => 'confirmed',
        ]);

        Logement::where('id', $reservation->logement_id)
            ->update(['status' => 'reserved']);

        return ['error' => false];
    }

    public function success(Reservation $reservation)
    {
        if ($reservation->payment_status !== 'paid') {
            $reservation->update([
                'payment_status' => 'paid',
                'status' => 'confirmed',
            ]);

            Logement::where('id', $reservation->logement_id)
                ->update(['status' => 'reserved']);
        }

        if ($reservation->monthlyPayments()->count() === 0) {
            MonthlyPayment::create([
                'reservation_id' => $reservation->id,
                'amount' => $reservation->total_price - $reservation->deposit_amount,
                'due_date' => now()->addMonth()->toDateString(),
                'status' => 'pending',
            ]);
        }

        return $reservation;
    }
}