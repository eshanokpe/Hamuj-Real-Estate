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
        Schema::table('add_properties', function (Blueprint $table) {
            $table->foreignId('property_type_id')
                  ->nullable()
                  ->constrained('property_types')
                  ->onDelete('set null');
            $table->string('property_subtitle')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('add_properties', function (Blueprint $table) {
            $table->dropForeign(['property_type_id']);
            $table->dropColumn(['property_type_id', 'property_subtitle']);
        });
    }
};
