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
        Schema::table('transfers', function (Blueprint $table) {
            $table->unsignedBigInteger('buy_id')->nullable()->after('property_id');
            $table->dateTime('purchase_date')->nullable()->after('total_price');
            $table->decimal('roi_percentage', 5, 2)->nullable()->after('purchase_date');
            $table->decimal('total_roi', 15, 2)->nullable()->after('roi_percentage');
            $table->decimal('monthly_roi', 15, 2)->nullable()->after('total_roi');
            $table->dateTime('roi_due_date')->nullable()->after('monthly_roi');
            $table->boolean('is_matured')->default(false)->after('roi_due_date');
            $table->unsignedTinyInteger('months_elapsed')->nullable()->after('is_matured');
            $table->unsignedTinyInteger('days_into_month')->nullable()->after('months_elapsed');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('transfers', function (Blueprint $table) {
            $table->dropColumn([
                'buy_id',
                'purchase_date',
                'roi_percentage',
                'total_roi',
                'monthly_roi',
                'roi_due_date',
                'is_matured',
                'months_elapsed',
                'days_into_month'
            ]);
        });
    }
};
