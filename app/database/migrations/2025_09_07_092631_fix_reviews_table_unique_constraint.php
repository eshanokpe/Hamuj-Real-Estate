<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class FixReviewsTableUniqueConstraint extends Migration
{
    public function up()
    {
        // First, drop the foreign key constraints
        Schema::table('reviews', function (Blueprint $table) {
            // Drop foreign keys - you need to know the exact constraint names
            // Common constraint names are: reviews_property_id_foreign, reviews_user_id_foreign
            $table->dropForeign(['property_id']);
            $table->dropForeign(['user_id']);
        });

        // Now drop the unique index
        Schema::table('reviews', function (Blueprint $table) {
            $table->dropUnique('reviews_property_id_user_id_unique');
        });

        // Re-add the foreign key constraints
        Schema::table('reviews', function (Blueprint $table) {
            $table->foreign('property_id')->references('id')->on('properties')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

        // Add a regular index for better query performance
        Schema::table('reviews', function (Blueprint $table) {
            $table->index(['property_id', 'user_id']);
        });
    }

    public function down()
    {
        // Drop foreign keys first
        Schema::table('reviews', function (Blueprint $table) {
            $table->dropForeign(['property_id']);
            $table->dropForeign(['user_id']);
        });

        // Drop the regular index
        Schema::table('reviews', function (Blueprint $table) {
            $table->dropIndex(['property_id', 'user_id']);
        });

        // Add back the unique constraint
        Schema::table('reviews', function (Blueprint $table) {
            $table->unique(['property_id', 'user_id']);
        });

        // Re-add foreign keys
        Schema::table('reviews', function (Blueprint $table) {
            $table->foreign('property_id')->references('id')->on('properties')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }
}