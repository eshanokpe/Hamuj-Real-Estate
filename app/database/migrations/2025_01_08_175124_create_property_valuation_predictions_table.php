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
        Schema::create('property_valuation_predictions', function (Blueprint $table) {
            $table->id(); 
            $table->foreignId('property_id')->constrained()->onDelete('cascade');
            $table->string('valuation_type');
            $table->decimal('current_price', 15, 2);
            $table->decimal('market_value', 15, 2);
            $table->decimal('percentage_increase', 5, 2)->default(0);
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
        Schema::dropIfExists('property_valuation_predictions');
    }
};
