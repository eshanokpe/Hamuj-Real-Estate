<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMediaVotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('media_votes', function (Blueprint $table) {
            $table->id();
            $table->integer('award_id')->nullable();
            $table->string('nominee_name')->nullable();
            $table->integer('sector_id')->nullable();
            $table->string('number_of_votes')->nullable();
            $table->string('percentage_votes')->nullable();
            $table->string('profile_of_the_reporter')->nullable();
            $table->string('areas_of_GRC_and_anti_FinCrime_the_Reporter_Covers')->nullable();
            $table->string('Evidence_of_Reporter_Work')->nullable();
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
        Schema::dropIfExists('media_votes');
    }
}
