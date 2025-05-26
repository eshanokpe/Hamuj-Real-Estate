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
        Schema::create('property_valuation_summaries', function (Blueprint $table) {
            $table->id(); 
            $table->unsignedBigInteger('property_id');
            $table->unsignedBigInteger('property_valuation_id');
            $table->decimal('initial_value_sum', 15, 2)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('property_valuation_summaries');
    }
};
