<?php

namespace App\Http\Controllers;

use App\Models\MonthlyPayment;
use Illuminate\Support\Facades\Auth;
use Stripe\Stripe;
use Stripe\Checkout\Session;

class MonthlyPaymentController extends Controller
{
    public function checkout(MonthlyPayment $monthlyPayment)
    {
        if ($monthlyPayment->reservation->user_id !== Auth::id()) {
            abort(403);
        }

        if ($monthlyPayment->status === 'paid') {
            return back()->with('error', 'Cette mensualité est déjà payée.');
        }

        Stripe::setApiKey(config('services.stripe.secret'));

        $session = Session::create([
            'mode' => 'payment',
            'success_url' => route('monthly-payments.success', $monthlyPayment),
            'cancel_url' => route('monthly-payments.cancel', $monthlyPayment),
            'line_items' => [[
                'quantity' => 1,
                'price_data' => [
                    'currency' => 'usd',
                    'unit_amount' => (int) ($monthlyPayment->amount * 100),
                    'product_data' => [
                        'name' => 'Paiement mensuel logement',
                    ],
                ],
            ]],
        ]);

        return redirect($session->url);
    }

    public function success(MonthlyPayment $monthlyPayment)
    {
        if ($monthlyPayment->reservation->user_id !== Auth::id()) {
            abort(403);
        }

        $monthlyPayment->update([
            'status' => 'paid',
        ]);

        return redirect()
            ->route('logements.show', $monthlyPayment->reservation->logement_id)
            ->with('success', 'Paiement mensuel effectué avec succès.');
    }

    public function cancel(MonthlyPayment $monthlyPayment)
    {
        if ($monthlyPayment->reservation->user_id !== Auth::id()) {
            abort(403);
        }

        return redirect()
            ->route('logements.show', $monthlyPayment->reservation->logement_id)
            ->with('error', 'Paiement mensuel annulé.');
    }
}