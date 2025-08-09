<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJudgingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('judgings', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->unsignedBigInteger('award_program_id');
            $table->foreign('award_program_id')->references('id')->on('award_programs')->onDelete('cascade');
            $table->string('award_id')->references('id')->on('awards')->onDelete('cascade')->nullable();
            $table->string('criteria_id')->nullable();
            $table->string('votes')->nullable();
            $table->string('judges_id')->references('id')->on('judges')->onDelete('cascade')->nullable();
            $table->string('votes_id')->references('id')->on('votes')->onDelete('cascade')->nullable();
            $table->string('nominee_id')->references('id')->on('nominees')->onDelete('cascade')->nullable();
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
        Schema::dropIfExists('judgings');
    }
}
