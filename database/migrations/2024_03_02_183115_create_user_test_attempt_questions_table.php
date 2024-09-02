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
        Schema::create('user_test_attempt_questions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_test_attempt_id');
            $table->unsignedBigInteger('question_id');
            $table->timestamps();

            $table->unique(['user_test_attempt_id', 'question_id'], 'user_test_attempt_id_question_id_unique');

            $table->foreign('question_id')
                ->references('id')
                ->on('questions')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->foreign('user_test_attempt_id')
                ->references('id')
                ->on('user_test_attempts')
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
        Schema::dropIfExists('user_test_attempt_questions');
    }
};
