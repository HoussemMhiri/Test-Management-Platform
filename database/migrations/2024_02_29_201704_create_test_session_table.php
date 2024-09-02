<?php

use App\Enums\PassingModeEnum;
use App\Enums\TestSessionEnum;
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
        Schema::create('test_session', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('test_id');
            $table->enum('status', TestSessionEnum::values());
            $table->dateTime('start_at');
            $table->dateTime('end_at');
            $table->enum('passing_mode', PassingModeEnum::values())->nullable();

            $table->timestamps();

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
        Schema::dropIfExists('test_session');
    }
};
