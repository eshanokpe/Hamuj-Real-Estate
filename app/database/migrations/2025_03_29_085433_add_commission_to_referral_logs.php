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
            
            // Add commission columns if they don't exist
            if (!Schema::hasColumn('referral_logs', 'commission_amount')) {
                $table->decimal('commission_amount', 10, 2)->default(0)->after('referred_at');
            }
            
            if (!Schema::hasColumn('referral_logs', 'commission_paid')) {
                $table->boolean('commission_paid')->default(false)->after('commission_amount');
            }
            
            if (!Schema::hasColumn('referral_logs', 'commission_paid_at')) {
                $table->timestamp('commission_paid_at')->nullable()->after('commission_paid');
            }
            
            if (!Schema::hasColumn('referral_logs', 'property_id')) {
                $table->unsignedBigInteger('property_id')->nullable()->after('commission_paid_at');
                $table->foreign('property_id')->references('id')->on('properties')->onDelete('set null');
            }
            
            if (!Schema::hasColumn('referral_logs', 'transaction_id')) {
                $table->string('transaction_id')->nullable()->after('property_id');
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
                'commission_amount',
                'commission_paid',
                'commission_paid_at',
                'property_id',
                'transaction_id' 
            ]);
        });
    }
};
