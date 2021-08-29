<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\StripeService;
use Illuminate\Http\Request;
use Stripe\Charge;
use Stripe\Event;
use Stripe\PaymentIntent;
use Stripe\Stripe;

class StripeController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function stripeEvent(Request $request)
    {
        $input = $request->all();

        try {
            $event = Event::constructFrom($input);
        } catch (\UnexpectedValueException $e) {
            // Invalid payload
            \Log::critical('Stripe Webhook Failure: ' . $e->getMessage() . ' | ' . $input);
            return response('Error constructing Stripe Event', 400);
        }

        //  derive the method name from the Stripe event id
        $methodName = str_replace(' ', '', lcfirst(ucwords(implode(' ', preg_split('/[_\.]+/', $event->type)))));
        \Log::info('methodName: '.$methodName);

        try {
            StripeService::{$methodName}($event);
        } catch (\Exception $exception) {
            \Log::critical('Stripe Webhook Error: ' . $exception->getMessage());
            \Log::critical('input');
            \Log::critical($input);
            return response('Error unexpected Stripe Event', 400);
        }

        return response('Success', 200);
    }

    /**
     * @return \Illuminate\Config\Repository|\Illuminate\Contracts\Foundation\Application|mixed
     */
    public function getPublishable()
    {
        return config('services.stripe.publishable', '');
    }

    public function stripePurchase(Request $request)
    {
        $user = $request->user();

        $input = $request->all();

//        \Log::info('input');
//        \Log::info($input);

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

            //  add transaction
            $user->transactions()->create([
                'reference' => $paymentIntent->charges->data[0]->id,
                'amount' => $input['metadata']['price'],
                'tokens' => $input['metadata']['quantity'],
                'remaining' => $input['metadata']['quantity']
            ]);

        } catch (\Exception $e) {
            \Log::info('payment error: '.$e->getMessage());
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }

        //  TODO: save JSON to Spaces

        return response()->json([
            'quantity' => $input['metadata']['quantity'],
            'price' => $input['metadata']['price'],
        ], 200);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
//    public function createPaymentIntent (Request $request)
//    {
////        $quantity = $request->get('quantity');
////        $prices = collect(config('common.prices'));
//        $quantity = 5;
//        $amount = 1;
//
//        Stripe::setApiKey(config('services.stripe.secret'));
//
//        try {
//            $paymentIntent = PaymentIntent::create([
////                'amount' => $prices->first(function($price, $key) use($quantity) {
////                    return $price['quantity'] == $quantity;
////                })['amount'] * 100,
//                'amount' => $amount * 100,
//                'currency' => 'gbp'
//            ]);
//        } catch (\Exception $e) {
//            return response()->json([
//                'error' => $e->getMessage(),
//                'quantity' => $quantity,
//                'amount' => $amount * 100,
//            ], 503);
//        }
//
//        $output = [
//            'publishableKey' => config('services.stripe.publishable'),
//            'clientSecret' => $paymentIntent->client_secret,
//        ];
//
//        return response()->json($output, 200);
//    }

    /**
     * handling payment with POST
     */
//    public function handlePost(Request $request, $quantity)
//    {
//        Stripe::setApiKey(config('services.stripe.secret'));
//        Charge::create ([
//            "amount" => 100 * $this->prices[$quantity],
//            "currency" => "gbp",
//            "source" => $request->stripeToken,
//            "description" => "Fig Used Price Tokens."
//        ]);
//
//        Session::flash('success', 'Payment has been successfully processed.');
//
//        return back();
//    }
}
