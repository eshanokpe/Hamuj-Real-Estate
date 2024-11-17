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
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->text('name')->nullable();
            $table->text('slug')->nullable();
            $table->text('description')->nullable();
            $table->text('location')->nullable();
            $table->text('price')->nullable();
            $table->text('size')->nullable();
            $table->text('property_images')->nullable();
            $table->text('payment_plan')->nullable();
            $table->text('brochure')->nullable();
            $table->text('land_survey')->nullable();
            $table->text('video_link')->nullable();
            $table->text('status')->nullable();
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
        Schema::dropIfExists('properties');
    }
};
