<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Plans\StorePlanRequest;
use App\Http\Requests\Plans\UpdatePlanRequest;
use App\Models\SubscriptionPlan;
use Illuminate\Http\Request;

class SubscriptionPlanController extends Controller
{
    public function index()
    {
        return view('subscription_plans.index');
    }
    public function fetch()
    {
        $subscriptionPlans = SubscriptionPlan::all();
        return response()->json([
            'data' => $subscriptionPlans,
        ], 200);
    }
    public function store(StorePlanRequest $request)
    {
        return response()->json($request->savePlan(new SubscriptionPlan()), 201);
    }

    public function Update(UpdatePlanRequest $request,  SubscriptionPlan $subscriptionPlan)
    {
        return response()->json($request->savePlan($subscriptionPlan), 201);
    }

    public function show(SubscriptionPlan $subscriptionPlan)
    {
        return response()->json([
            'data' => $subscriptionPlan,
        ], 200);
    }

    public function destroy(SubscriptionPlan $subscriptionPlan)
    {
        $subscriptionPlan->delete();

        return response()->json([
            'msg' => 'Plan deleted successfully'
        ]);
    }
}
