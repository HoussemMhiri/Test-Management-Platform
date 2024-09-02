<?php

use Illuminate\Support\Facades\Schema;
use App\Enums\TestInvitationStatusEnum;
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
        Schema::create('test_invitations', function (Blueprint $table) {
            $table->id();
            $table->longText('email');
            $table->boolean('is_code_used')->default(false);
            $table->enum('status', TestInvitationStatusEnum::values());
            $table->string('access_code');
            $table->timestamp('treated_at')->nullable();
            $table->unsignedBigInteger('test_session_id');
            $table->timestamps();

            $table->unique(['email', 'test_session_id']);

            $table->foreign('test_session_id')
                ->references('id')
                ->on('test_session')
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
        Schema::dropIfExists('test_invitations');
    }
};
