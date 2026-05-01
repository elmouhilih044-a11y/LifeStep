<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreReservationRequest;
use App\Models\Logement;
use App\Models\Reservation;
use App\Services\ReservationService;

class ReservationController extends Controller
{
    protected $reservationService;

    public function __construct(ReservationService $reservationService)
    {
        $this->reservationService = $reservationService;
    }

    public function store(StoreReservationRequest $request, Logement $logement)
    {
        $result = $this->reservationService->create($request, $logement);

        if ($result['error']) {
            return back()->with('error', $result['message']);
        }

        return redirect($result['url']);
    }

    public function cancel(Reservation $reservation)
    {
        $this->authorize('cancel', $reservation);

        $result = $this->reservationService->cancel($reservation);

        if ($result['error']) {
            return back()->with('error', $result['message']);
        }

        if ($result['refund']) {
            return back()->with('success', 'Remboursement effectué.');
        }

        return back()->with('error', 'Annulation effectuée. Pas de remboursement.');
    }

    public function confirmPayment(Reservation $reservation)
    {
        $this->authorize('confirmPayment', $reservation);

        $result = $this->reservationService->confirmPayment($reservation);

        if ($result['error']) {
            return back()->with('error', $result['message']);
        }

        return back()->with('success', 'Paiement confirmé.');
    }

    public function success(Reservation $reservation)
    {
        $this->authorize('cancel', $reservation);

        $reservation = $this->reservationService->success($reservation);

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