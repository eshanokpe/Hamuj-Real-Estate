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
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('conversation_id');
            $table->string('user_id'); // Can be either user ID or guest session ID
            $table->string('user_type'); // 'registered' or 'guest'
            $table->text('content');
            $table->boolean('read')->default(false);
            $table->timestamps();

            // Indexes
            $table->index(['user_id', 'user_type']);
            $table->index('read');

            // Foreign key
            $table->foreign('conversation_id')
                  ->references('id')
                  ->on('conversations')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('messages');
    }
};
