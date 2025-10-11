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
        Schema::create('post_property_media', function (Blueprint $table) {
            $table->id();
            $table->foreignId('property_id')->constrained('add_properties')->onDelete('cascade');
            $table->string('media_path');
            $table->enum('media_type', ['image', 'video']);
            $table->string('mime_type');
            $table->timestamps();
            
            // Optional: Add index for better performance
            $table->index('property_id');
            $table->index('media_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('post_property_media');
    }
};
