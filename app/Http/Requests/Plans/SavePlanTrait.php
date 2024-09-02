<?php

namespace App\Http\Requests\Plans;

use App\Enums\PlanLimitationTypeEnum;
use App\Models\SubscriptionPlan;
use App\Models\User;
use Illuminate\Validation\Rule;

trait SavePlanTrait
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => ['required'],
            'description' => ['required'],
            'features' => ['required'],
            'monthly_price' => ['required', 'numeric', 'min:0'],
            'annual_price' => ['required', 'numeric', 'min:0'],
            'individual_template_price' => ['required', 'numeric', 'min:0'],
            'plan_limitation_type' => ['required', Rule::in(PlanLimitationTypeEnum::values())],
            'max_templates_number' => ['nullable', 'integer', 'min:0'],
            'is_default_plan' => ['nullable', 'boolean'],
        ];
    }


    public function savePlan(SubscriptionPlan $subscriptionPlan)
    {
        $adminUser = User::where('is_admin', true)->first();
        $data = $this->only([
            "name",
            "description",
            'features',
            "monthly_price",
            "annual_price",
            "individual_template_price",
            "plan_limitation_type",
            "max_templates_number",
            "is_default_plan",
        ]) + ["user_id" => $adminUser];

        $subscriptionPlan->fill($data)->save();

        return $subscriptionPlan;
    }
}
