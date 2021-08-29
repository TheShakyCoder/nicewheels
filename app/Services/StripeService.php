<?php

namespace App\Services;

use App\Models\User;
use Stripe\Charge;
use Stripe\Event;

class StripeService
{
    /**
     * @param Event $stripeEvent
     * @return false
     */
    public static function chargeSucceeded(Event $stripeEvent)
    {
        \Log::info('chargeSucceeded');
        \Log::info($stripeEvent);

        /** @var Charge $stripeCharge */
        $stripeCharge = $stripeEvent->data->object;

        /** @var string $stripeChargeId */
        $stripeChargeId = $stripeCharge->id;

        /** @var string $stripeCustomerId */
        $stripeCustomerId = $stripeCharge->customer;

        /** @var string $stripeCustomerEmail */
        $stripeCustomerEmail = $stripeCharge->billing_details->email;

        /** @var User $user */
        $user = User::query()->where('email', $stripeCustomerEmail)->first();

        // enter payment
        try {
            $user->transactions()->create([
                'reference' => $stripeChargeId,
                'tokens' => $stripeCharge->metadata->quantity,
                'remaining' => $stripeCharge->metadata->quantity,
                'amount' => $stripeCharge->metadata->price
            ]);
        } catch(Exception $exception) {
            \Log::channel('stripe')->info($exception->getMessage());
            return false;
        }
    }

    /**
     * @param Event $stripeEvent
     */
    public static function invoiceCreated(Event $stripeEvent)
    {
        \Log::info('invoiceCreated');
        \Log::info($stripeEvent);
    }

    /**
     * @param Event $stripeEvent
     *
     * This is either a trial subscription or a paid subscription,
     * depending on what plan the customer chose
     */
//    public static function customerSubscriptionCreated(Event $stripeEvent)
//    {
//        \Log::info($stripeEvent);
//
//        /** @var \Stripe\Subscription $stripeSubscription */
//        $stripeSubscription = $stripeEvent->data->object;
//
//        /** @var string $stripeSubscriptionId */
//        $stripeSubscriptionId = $stripeSubscription->id;
//
//        /** @var Customer $customer */
//        $customer = Customer::where('stripe_id', $stripeSubscription->customer)->first();
//
//        /** @var string $stripePlan */
//        $stripePlan = $stripeSubscription->items->data[0]->plan;
//
//        /** @var Plan $plan */
//        $plan = Plan::where('stripe_id', $stripePlan->id)->orWhere('test_stripe_id', $stripePlan->id)->first();
//
//        /** @var int $isTrial */
//        $isTrial = $stripeSubscription->trial_end !== null;
//
//        /** @var integer $end */
//        $paidExpiresAt = $isTrial ? $stripeSubscription->trial_end : $stripeSubscription->current_period_end;
//
//        /** @var integer $endPrepare */
//        $expiresAt = $paidExpiresAt;
//
//        //  deactivate the expired subscription
//        Subscription::where('stripe_id', $stripeSubscription->id)->update([
//            'active' => 0
//        ]);
//
//        //  create a new subscription
//        Subscription::create([
//            'customer_id' => $customer->id,
//            'uid' => CodeService::FastRandom(30),
//            'stripe_id' => $stripeSubscription->id,
//            'plan_id' => $plan->id,
//            'has_trial' => $stripeSubscription->trial_end !== null,
//            'expires_at' => date('Y-m-d H:i:s', $expiresAt),
//            'paid_expires_at' => date('Y-m-d H:i:s', $paidExpiresAt),
//            'active' => 1
//        ]);
//    }
//
//    /**
//     * @param Event $stripeEvent
//     */
//    public static function invoiceUpcoming(Event $stripeEvent)
//    {
//        \Log::info($stripeEvent);
//
//        /** @var Invoice $stripeInvoice */
//        $stripeInvoice = $stripeEvent->data->object;
//
//        /** @var string $stripeCustomerId */
//        $stripeCustomerId = $stripeInvoice->customer;
//
//        /** @var Customer $customer */
//        $customer = Customer::where('stripe_id', $stripeCustomerId)->first();
//
//        /** @var integer $paidExpiresAt */
//        $paidExpiresAt = $stripeInvoice->lines->data[0]->period->end;
//
//        /** @var integer $expiresAt */
//        $expiresAt = Carbon::createFromTimestamp($stripeInvoice->lines->data[0]->period->start)->addMinutes(60)->timestamp;
//
//        try {
//            /** @var Subscription $currentSubscription */
//            $currentSubscription = Subscription::where('customer_id', $customer->id)->orderBy('expires_at', 'DESC')->firstOrFail();
//        } catch (\Exception $exception) {
//            \Log::warning('Tried to renew a subscription for customer #'.$customer->id.', (Stripe ID: '.$stripeCustomerId.') and failed.');
//            return;
//        }
//
//        //  TODO: remove hard-coded ID's
//        $currentPlanId = $currentSubscription->plan_id == 6 ? 5 : $currentSubscription->plan_id;
//
//        //  create a new subscription
//        Subscription::create([
//            'customer_id' => $customer->id,
//            'uid' => CodeService::FastRandom(30),
//            'stripe_id' => $currentSubscription->stripe_id,
//            'plan_id' => $currentPlanId,
//            'has_trial' => 0,
//            'expires_at' => date('Y-m-d H:i:s', $expiresAt),
//            'paid_expires_at' => date('Y-m-d H:i:s', $paidExpiresAt),
//            'active' => 1
//        ]);
//
//        //  kill the current subscription
//        $currentSubscription->active = 0;
//        $currentSubscription->save();
//    }
}
