<?php

namespace App\Http\Controllers;
use App\Http\Requests\StoreReservationRequest;
use App\Models\Logement;
use App\Models\Reservation;
use Illuminate\Support\Facades\Auth;

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
  Reservation::create([
        'user_id' => Auth::id(),
        'logement_id' => $logement->id,
        'total_price' => $totalPrice,
        'deposit_amount' => $depositAmount,
        'status' => 'pending',
        'start_date' => now(),
    ]);
      return back()->with('success', 'Réservation créée');
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

}
