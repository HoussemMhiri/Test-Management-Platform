<?php

namespace App\Models;

use App\Enums\PlanLimitationTypeEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubscriptionPlan extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'features', 'monthly_price', 'annual_price', 'individual_template_price', 'plan_limitation_type', 'max_templates_number', 'is_default_plan'];

    protected $casts = [
        'features' => "array",
        'plan_limitation_type' => PlanLimitationTypeEnum::class,
        'is_default_plan' => 'boolean',
    ];
}
