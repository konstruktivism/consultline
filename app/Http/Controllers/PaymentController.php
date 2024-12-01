<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mollie\Laravel\Facades\Mollie;
use App\Models\Payment;
use App\Models\User;

class PaymentController extends Controller
{
    public function createPayment(Request $request)
    {
        // Store payment information in the database
        $paymentRecord = Payment::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'amount' => $request->input('amount'),
            'currency' => 'EUR',
            'description' => 'Consultline.nl Credits #12345',
        ]);

        // Create payment with Mollie
        $payment = Mollie::api()->payments->create([
            'amount' => [
                'currency' => 'EUR',
                'value' => number_format($request->input('amount'), 2, '.', ''), // Amount in EUR
            ],
            'description' => 'Consultline.nl Order #12345',
            'redirectUrl' => route('payment.success', ['id' => $paymentRecord->id, 'amount' => $request->input('amount')]), // Redirect URL
            //'webhookUrl' => route('webhooks.mollie'), // Webhook URL
        ]);

        // Update the payment record with Mollie payment ID
        $paymentRecord->update(['mollie_payment_id' => $payment->id]);

        return redirect($payment->getCheckoutUrl());
    }

    public function handleWebhook(Request $request)
    {
        $paymentId = $request->id;
        $payment = Mollie::api()->payments->get($paymentId);

        if ($payment->isPaid()) {
            Payment::where('mollie_payment_id', $paymentId)->update(['status' => 'paid']);
        }

        return response()->json(['status' => 'success']);
    }

    public function paymentSuccess(Request $request)
    {
        // Add credits to user account


        $payment = Payment::where('id', $request->id)->first();

        if (!$payment) {
            return redirect('/')->withErrors(['payment' => 'Payment not found.']);
        }

        // Update user credits
        $user = User::where('email', $payment->email)->first();

        // multiply credits by 60 to convert to seconds
        $user->credits += $request->input('amount') * 60;
        $user->save();

        return view('welcome');
    }
}
