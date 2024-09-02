<?php

use App\Enums\PlanLimitationTypeEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subscription_plans', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description');
            $table->text('features');
            $table->decimal('monthly_price', 10, 2)->unsigned();
            $table->decimal('annual_price', 10, 2)->unsigned();
            $table->decimal('individual_template_price', 10, 2)->unsigned();
            $table->enum('plan_limitation_type', PlanLimitationTypeEnum::values());
            $table->unsignedInteger('max_templates_number')->nullable();
            $table->boolean('is_default_plan')->nullable()->default(false);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('subscription_plans');
    }
};
