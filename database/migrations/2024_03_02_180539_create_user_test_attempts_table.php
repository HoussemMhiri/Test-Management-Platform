<?php

use Illuminate\Support\Facades\Schema;
use App\Enums\UserTestAttemptResultEnum;
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
        Schema::create('user_test_attempts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('test_session_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('current_question_id')->nullable();
            $table->dateTime('start_at');
            $table->dateTime('end_at')->nullable();
            $table->enum('result', UserTestAttemptResultEnum::values());
            $table->string('recorded_camera_video_path')->nullable();
            $table->string('recorded_audio_path')->nullable();
            $table->timestamps();

            $table->foreign('test_session_id')
                ->references('id')
                ->on('test_session')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->foreign('current_question_id')
                ->references('id')
                ->on('questions')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->foreign('user_id')
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
        Schema::dropIfExists('user_test_attempts');
    }
};
