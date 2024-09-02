<?php

use App\Enums\TestVisibilityEnum;
use App\Enums\QuestionSelectionEnum;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tests', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('description')->nullable();
            $table->longText('thumbnail')->nullable();
            $table->longText('report_background_image')->nullable();
            $table->text('fixed_value')->nullable();
            $table->string('duration');
            $table->string('report_margin_top')->nullable();
            $table->string('report_margin_buttom')->nullable();
            $table->string('report_margin_right')->nullable();
            $table->string('report_margin_left')->nullable();
            $table->unsignedInteger('passing_score');
            $table->enum('question_selection', QuestionSelectionEnum::values());
            $table->unsignedInteger('allowed_attempts_number');
            $table->unsignedInteger('window_allowed_crossing_duration');
            $table->unsignedInteger('window_crossing_penalties_number');
            $table->enum('visibility', TestVisibilityEnum::values());
            $table->boolean('is_camera_required');
            $table->boolean('is_audio_required');
            $table->unsignedBigInteger('created_by_user_id');

            $table->timestamps();

            $table->foreign('created_by_user_id')
                ->references('id')
                ->on('users')
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
        Schema::dropIfExists('tests');
    }
};
