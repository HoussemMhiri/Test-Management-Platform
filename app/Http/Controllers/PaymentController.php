<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\SubscriptionPlan;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index()
    {
        return view('payment.index');
    }

    public function success()
    {
        return view('payment.success');
    }

    public function update(SubscriptionPlan $subscriptionPlan)
    {
        $user = auth()->user();


        $user->subscription_plan_id = $subscriptionPlan->id;


        $user->save();


        return response()->json(['subscriptionPlanId' => $subscriptionPlan->id]);
    }
}
