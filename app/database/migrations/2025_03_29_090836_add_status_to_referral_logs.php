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
        Schema::table('referral_logs', function (Blueprint $table) {
            if (!Schema::hasColumn('referral_logs', 'status')) {
                $table->string('status')->default('registered')
                    ->after('referred_at')
                    ->comment('registered, purchased, commission_pending, paid, cancelled');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('referral_logs', function (Blueprint $table) {
            $table->dropColumn([
                'status',
            ]);
        });
    }
};
