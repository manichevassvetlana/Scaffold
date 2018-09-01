<?php

namespace App\Http\Controllers;

use App\LookupValue;
use App\Plan;
use App\Subscription;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Stripe\Charge;
use Stripe\Customer;
use Stripe\Error\Card;
use Stripe\Stripe;

class PlanController extends Controller
{
    protected $organizationId;
    /*
    * Make a Stripe payment
    */
    public function postPayWithStripe(Request $request, Plan $plan)
    {
        $this->organizationId = fire_auth()->user()->organizationUser()
            ->where('type', getLookupValue('ORG_USER_TYPE', 'Owner')->id)
            ->where('status', getLookupValue('ORG_USER_STATUS', 'Active')->id)
            ->first();
        if($this->organizationId){
            $this->organizationId = $this->organizationId->id;
            if($plan->amount > 0) return $this->chargeCustomer($plan->id, $plan->amount * 100, $plan->name, $request->input('stripeToken'));
            else return $this->addSubscription($this->organizationId, $plan->id);
        }
    }

    /*
    * Charge a Stripe customer.
    */
    public function chargeCustomer($planId, $planPrice, $planName, $token)
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));

        if (!$this->isStripeCustomer()) {
            $customer = $this->createStripeCustomer($token);
        } else {
            $customer = Customer::retrieve(Auth::user()->stripe_id);
        }

        Auth::user()->updateCard($token);

        //$card = Card::create($customer->id, $request->tokenId);

        return $this->createStripeCharge($planId, $planPrice, $planName, $customer);
    }

    /*
    * Create a Stripe charge.
    */
    public function createStripeCharge($planId, $planPrice, $planName, $customer)
    {
        try {

            $charge = Charge::create(array(
                'amount' => $planPrice,
                'currency' => 'usd',
                'customer' => $customer->id,
                'description' => $planName
            ));

            return $this->addSubscription($this->organizationId, $planId, Auth::user()->stripe_id);

        } catch (Card $e) {
            return back()
                ->with('error', 'Your credit card was been declined. Please try again or contact us.');
        }
    }

    /*
     * Create a new Stripe customer for a given user.
     */
    public function createStripeCustomer($token)
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));

        $customer = Customer::create(array(
            'description' => Auth::user()->email,
            'source' => $token
        ));

        Auth::user()->stripe_id = $customer->id;
        Auth::user()->save();

        return $customer;
    }

    /**
     * Check if the Stripe customer exists.
     *
     * @return boolean
     */
    public function isStripeCustomer()
    {
        return !is_null(Auth::user()->stripe_id);
    }

    /*
     * Add plan type to organization.
     */
    public function addSubscription($organizationId, $planId, $stripeId = null)
    {
        Subscription::create([
            'organization_id' => $organizationId,
            'plan_id' => $planId,
            'start_date' => Carbon::now(),
            'status' => getLookupValue('SUBSCRIPTION_STATUS', 'Active')->id,
            'stripe_id' => $stripeId
        ]);
        return back()->with(['msg' => 'Success']);
    }
}
