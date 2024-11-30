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
        Schema::create('property_price_updates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('property_id')->constrained('properties')->onDelete('cascade');
            $table->decimal('previous_price', 15, 2);
            $table->decimal('updated_price', 15, 2);
            $table->decimal('percentage_increase', 5, 2);
            $table->decimal('previous_percentage_increase', 5, 2);
            $table->decimal('previous_year');
            $table->year('updated_year');
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
        Schema::dropIfExists('property_price_updates');
    }
};
