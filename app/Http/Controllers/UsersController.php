<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function stripePurchase(Request $request)
    {
        $user = $request->user();

        $input = $request->all();

        \Log::info('input');
        \Log::info($input);

        //  TODO: check quantity vs price

        try {
            $paymentIntent = $user->charge(
                $input['metadata']['price'] * 100,
                $input['id'],
                [
                    'metadata[price]' => $input['metadata']['price'],
                    'metadata[quantity]' => $input['metadata']['quantity'],
                ]
            );
            $paymentIntent = $paymentIntent->asStripePaymentIntent();
        } catch (\Exception $e) {
            \Log::info('payment error: '.$e->getMessage());
            return redirect()->back();
        }

        \Log::info('paymentIntent');
        \Log::info($paymentIntent);

        //  TODO: save JSON to Spaces

        return redirect()->route('dashboard');
    }
}
