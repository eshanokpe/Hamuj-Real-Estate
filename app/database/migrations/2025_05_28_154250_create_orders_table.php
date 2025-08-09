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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('description');
            $table->string('revolut_order_id')->unique(); 
            $table->string('revolut_public_id')->unique(); // Public ID used for client-side
            $table->integer('amount'); // Amount in smallest currency unit (e.g., cents)
            $table->string('currency', 3); // 3-letter currency code
            $table->string('state'); // Order state from Revolut
            $table->timestamps();
            
            // Optional indexes for better query performance
            $table->index('revolut_order_id');
            $table->index('revolut_public_id');
            $table->index('state');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
};
