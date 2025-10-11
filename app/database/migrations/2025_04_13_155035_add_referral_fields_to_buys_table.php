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
        Schema::table('buys', function (Blueprint $table) {
            $table->boolean('use_referral')->nullable()->default(false)->after('status');
            $table->decimal('referral_amount', 10, 2)->nullable()->default(0)->after('use_referral');
            $table->decimal('final_amount', 10, 2)->nullable()->after('referral_amount');
        });
    } 

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('buys', function (Blueprint $table) {
            $table->dropColumn(['use_referral', 'referral_amount', 'final_amount']);
        });
    }
};
