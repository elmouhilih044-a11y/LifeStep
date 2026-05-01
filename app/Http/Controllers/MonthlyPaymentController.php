<?php

namespace App\Http\Controllers;

use App\Models\MonthlyPayment;
use App\Services\MonthlyPaymentService;

class MonthlyPaymentController extends Controller
{
    protected $monthlyPaymentService;

    public function __construct(MonthlyPaymentService $monthlyPaymentService)
    {
        $this->monthlyPaymentService = $monthlyPaymentService;
    }

    public function checkout(MonthlyPayment $monthlyPayment)
    {
        $result = $this->monthlyPaymentService->checkout($monthlyPayment);

        if ($result['error']) {
            return back()->with('error', $result['message']);
        }

        return redirect($result['url']);
    }

    public function success(MonthlyPayment $monthlyPayment)
    {
        $monthlyPayment = $this->monthlyPaymentService->success($monthlyPayment);

        return redirect()
            ->route('logements.show', $monthlyPayment->reservation->logement_id)
            ->with('success', 'Paiement mensuel effectué avec succès.');
    }

    public function cancel(MonthlyPayment $monthlyPayment)
    {
        $monthlyPayment = $this->monthlyPaymentService->cancel($monthlyPayment);

        return redirect()
            ->route('logements.show', $monthlyPayment->reservation->logement_id)
            ->with('error', 'Paiement mensuel annulé.');
    }
}