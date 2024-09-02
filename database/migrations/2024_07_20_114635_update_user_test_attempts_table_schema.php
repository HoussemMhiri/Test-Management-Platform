<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateUserTestAttemptsTableSchema extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_test_attempts', function (Blueprint $table) {
            // Drop the existing foreign key constraint
            $table->dropForeign(['test_session_id']);

            // Add the new foreign key constraint with cascadeOnDelete
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
        Schema::table('user_test_attempts', function (Blueprint $table) {
            // Drop the new foreign key constraint
            $table->dropForeign(['test_session_id']);

            // Re-add the old foreign key constraint with restrictOnDelete
            $table->foreign('test_session_id')
                ->references('id')
                ->on('test_session')
                ->cascadeOnUpdate()
                ->restrictOnDelete();
        });
    }
}
