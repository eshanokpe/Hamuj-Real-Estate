<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBestEsgInitiativesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('best_esg_initiatives', function (Blueprint $table) {
            $table->id();
            $table->integer('award_id')->nullable();
            $table->integer('nominee_id')->nullable();
            $table->integer('sector_id')->nullable();
            $table->string('number_of_votes')->nullable();
            $table->string('percentage_votes')->nullable();
            $table->text('fraud_awareness')->nullable();
            $table->text('fraud_prevention_policies_whistle_blowing')->nullable();
            $table->text('additional_information')->nullable();
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
        Schema::dropIfExists('best_esg_initiatives');
    }
}
