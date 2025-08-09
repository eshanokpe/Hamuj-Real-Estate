<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJudgesVotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('judges_votes', function (Blueprint $table) {
            $table->id();
            $table->integer('judge_id')->nullable();
            $table->integer('award_id')->nullable();
            $table->integer('nominee_id')->nullable();
            $table->string('votes')->nullable();
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
        Schema::dropIfExists('judges_votes');
    }
}
