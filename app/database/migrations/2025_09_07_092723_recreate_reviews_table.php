<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class RecreateReviewsTable extends Migration
{
    public function up()
    {
        // Create a temporary table without the unique constraint
        Schema::create('reviews_new', function (Blueprint $table) {
            $table->id();
            $table->foreignId('property_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->decimal('rating', 2, 1);
            $table->text('comment');
            $table->timestamps();
            
            // Regular index instead of unique constraint
            $table->index(['property_id', 'user_id']);
        });

        // Copy data from old table to new table
        DB::statement('INSERT INTO reviews_new (id, property_id, user_id, rating, comment, created_at, updated_at) 
                      SELECT id, property_id, user_id, rating, comment, created_at, updated_at FROM reviews');

        // Drop the old table
        Schema::drop('reviews');

        // Rename the new table
        Schema::rename('reviews_new', 'reviews');
    }

    public function down()
    {
        // Create a temporary table with the unique constraint
        Schema::create('reviews_old', function (Blueprint $table) {
            $table->id();
            $table->foreignId('property_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->decimal('rating', 2, 1);
            $table->text('comment');
            $table->timestamps();
            
            // Add back the unique constraint
            $table->unique(['property_id', 'user_id']);
        });

        // Copy data back
        DB::statement('INSERT INTO reviews_old (id, property_id, user_id, rating, comment, created_at, updated_at) 
                      SELECT id, property_id, user_id, rating, comment, created_at, updated_at FROM reviews');

        // Drop the current table
        Schema::drop('reviews');

        // Rename back
        Schema::rename('reviews_old', 'reviews');
    }
}