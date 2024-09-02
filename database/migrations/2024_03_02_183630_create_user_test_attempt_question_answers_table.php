<?php

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
        Schema::create('user_test_attempt_question_answers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_test_attempt_question_id');
            $table->unsignedBigInteger('answer_id');
            $table->string('value')->nullable();
            $table->unsignedInteger('points_earned')->nullable();
            $table->dateTime('answered_at')->nullable();
            $table->timestamps();

            $table->unique(['user_test_attempt_question_id', 'answer_id'], 'user_test_attempt_question_id_answer_id_unique');

            $table->foreign('user_test_attempt_question_id', 'user_test_attempt_question_id_FK')
                ->references('id')
                ->on('user_test_attempt_questions')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->foreign('answer_id')
                ->references('id')
                ->on('answers')
                ->cascadeOnUpdate()
                ->restrictOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_test_attempt_question_answers');
    }
};
