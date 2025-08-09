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
        Schema::create('beneficiaries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('account_name');
            $table->string('account_number', 20);
            $table->string('bank_code', 20);
            $table->string('bank_name');
            $table->string('recipient_code')->nullable(); // For Paystack integration
            $table->timestamps();

            // Composite unique constraint to prevent duplicates
            $table->unique(['user_id', 'account_number', 'bank_code']);
            
            // Index for faster queries
            $table->index(['user_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('beneficiaries');
    }
};
