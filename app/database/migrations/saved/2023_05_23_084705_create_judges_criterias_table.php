<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJudgesCriteriasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::create('judges_criterias', function (Blueprint $table) {
        //     $table->id();
        //     $table->integer('award_id')->nullable();
        //     $table->unsignedBigInteger('sector_id');
        //     $table->foreign('sector_id')->references('id')->on('sectors')->onDelete('cascade');
        //     $table->string('criteria')->nullable();
        //     $table->text('details')->nullable();
        //     $table->integer('award_program_id')->nullable();
        //     $table->timestamps();
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('judges_criterias');
    }
}
