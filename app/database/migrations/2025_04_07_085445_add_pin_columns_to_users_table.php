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
        Schema::table('users', function (Blueprint $table) {
            $table->integer('failed_pin_attempts')->default(0)->after('transaction_pin');
            $table->timestamp('last_failed_pin_attempt')->nullable();
            $table->timestamp('pin_locked_until')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('failed_pin_attempts');
            $table->dropColumn('last_failed_pin_attempt');
            $table->dropColumn('pin_locked_until');
        });
    }
};
