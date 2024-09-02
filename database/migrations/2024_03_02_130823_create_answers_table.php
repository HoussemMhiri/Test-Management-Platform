<?php

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
        Schema::create('answers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('question_id');
            $table->longText('text');
            $table->string('correct_value')->nullable();
            $table->unsignedInteger('points');
            $table->unsignedInteger('first_place_bonus')->default(0);
            $table->unsignedInteger('second_place_bonus')->default(0);
            $table->unsignedInteger('third_place_bonus')->default(0);
            $table->unsignedInteger('order');
            $table->text('answer_file')->nullable();
            $table->timestamps();

            $table->unique(['order', 'question_id']);

            $table->foreign('question_id')
                ->references('id')
                ->on('questions')
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
        Schema::dropIfExists('answers');
    }
};
