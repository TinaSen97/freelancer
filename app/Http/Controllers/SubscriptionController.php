<?php

namespace Fickrr\Http\Controllers;

use Illuminate\Http\Request;
use Fickrr\Models\Freelancer;
use Fickrr\Models\Subscription;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Carbon\Carbon;

class SubscriptionController extends Controller
{
    public function create()
    {
        $plan = Subscription::where('subscr_price', 10)->firstOrFail();
        return view('subscription.create', compact('plan'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'payment_method_id' => 'required|string',
            'card_holder_name' => 'required|string|max:255',
            'plan_id' => 'required|exists:subscriptions,id',
        ]);

        $freelancer = Auth::guard('freelancer')->user();
        $plan = Subscription::findOrFail($data['plan_id']);

        // Simulate Stripe intent creation (replace this with real Stripe logic)
        $fakeClientSecret = 'pi_' . uniqid() . '_secret_' . uniqid();

        // Save subscription info to DB
        $freelancer->update([
            'subscription_id' => 'sub_' . uniqid(),
            'plan_id' => $plan->id,
            'card_holder_name' => $data['card_holder_name'],
            'subscribed_at' => Carbon::now(),
            'expires_at' => Carbon::now()->addMonth()
        ]);

        return response()->json([
            'client_secret' => $fakeClientSecret
        ]);
    }

    public function show(Subscription $subscription)
    {
        return view('subscription.show', compact('subscription'));
    }
}
