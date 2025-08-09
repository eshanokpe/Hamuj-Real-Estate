<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGrcAntiFinCrimReportersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('grc_anti_fin_crim_reporters', function (Blueprint $table) {
            $table->id();
            $table->integer('award_id')->nullable();
            $table->integer('nominee_id')->nullable();
            $table->integer('sector_id')->nullable();
            $table->string('number_of_votes')->nullable();
            $table->string('percentage_votes')->nullable();
            $table->text('profile_of_the_reporter')->nullable();
            $table->text('areas_anti_fincrime_the_reporter_covers')->nullable();
            $table->text('evidence_of_reporter_work')->nullable();
            $table->text('achievements')->nullable();
            $table->text('adverse_media')->nullable();
            $table->string('judges_votes')->nullable(); 
            $table->text('total_of_judges_score_converted_to_percentage')->nullable(); 
            $table->string('eighty_percent_of_judges_score')->nullable();
            $table->string('twenty_percent_votes')->nullable();
            $table->string('overall_score')->nullable();
            $table->string('status')->nullable();
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
        Schema::dropIfExists('grc_anti_fin_crim_reporters');
    }
}
