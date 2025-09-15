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
            $table->boolean('is_favorite')->default(false)->after('mime_type');
            $table->integer('favorite_count')->default(0)->after('is_favorite');
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
            $table->dropColumn(['is_favorite', 'favorite_count']);
        });
    }
};
