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
        Schema::create('conversations', function (Blueprint $table) {
            $table->id();
            $table->string('subject');
            $table->string('user_id'); // Can be either user ID or guest session ID
            $table->string('user_type'); // 'registered' or 'guest'
            $table->unsignedBigInteger('admin_id')->nullable();
            $table->boolean('is_open')->default(true);
            $table->timestamps();

            // Indexes
            $table->index(['user_id', 'user_type']);
            $table->index('is_open');

            // Foreign key for admin (if using)
            $table->foreign('admin_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('conversations');
    }
};
