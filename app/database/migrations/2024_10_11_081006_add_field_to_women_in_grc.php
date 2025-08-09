<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldToWomenInGrc extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('women_in_grcs', function (Blueprint $table) {
            //
            $table->integer('nominee_id')->nullable()->after('award_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('women_in_grc', function (Blueprint $table) {
            //
        });
    }
}
