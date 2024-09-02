<?php

use App\Enums\EvaluationEnum;
use App\Enums\QuestionTypeEnum;
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
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('test_id');
            $table->longText('text');
            $table->string('media_link')->nullable();
            $table->enum('evaluation_type', EvaluationEnum::values());
            $table->enum('type', QuestionTypeEnum::values());
            $table->unsignedInteger('order');
            $table->string('duration');
            $table->boolean('require_manual_evaluation');
            $table->timestamps();

            $table->unique(['test_id', 'order']);

            $table->foreign('test_id')
                ->references('id')
                ->on('tests')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('questions');
    }
};
