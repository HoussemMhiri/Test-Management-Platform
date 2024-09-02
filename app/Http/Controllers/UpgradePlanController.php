<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\SubscriptionPlan;
use Illuminate\Http\Request;

class UpgradePlanController extends Controller
{
    public function index()
    {
        return view('upgrade_plans.index');
    }

    public function fetch()
    {

        $user = auth()->user();

        $userPlanId = $user->subscription_plan_id;

        $allPlans = SubscriptionPlan::all();

        foreach ($allPlans as $plan) {
            $plan->is_user_plan = $plan->id == $userPlanId;
        }

        return response()->json([
            'data' => $allPlans
        ]);
    }
}
