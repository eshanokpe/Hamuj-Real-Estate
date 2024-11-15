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
        Schema::create('contact_detials', function (Blueprint $table) {
            $table->id(); 
            $table->string('company_name')->nullable();
            $table->string('first_phone')->nullable();
            $table->string('second_phone')->nullable();
            $table->string('first_email')->nullable();
            $table->string('second_email')->nullable();
            $table->text('first_address')->nullable();
            $table->text('second_address')->nullable();
            $table->string('site_logo')->nullable();
            $table->string('favicon')->nullable();
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
        Schema::dropIfExists('contact_detials');
    }
};
