<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNonfiVotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nonfi_votes', function (Blueprint $table) {
            $table->id();
            $table->integer('award_id')->nullable();
            $table->string('nominee_name')->nullable();
            $table->integer('sector_id')->nullable();
            $table->string('number_of_votes')->nullable();
            $table->string('percentage_votes')->nullable();
            $table->string('No_of_employees_who_rated')->nullable();
            $table->string('worklife_balance')->nullable();
            $table->text('pay_and_benefits')->nullable();
            $table->text('job_security_and_advancement')->nullable();
            $table->text('management')->nullable();
            $table->text('culture')->nullable(); 
            $table->string('average_rating')->nullable(); 
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
        Schema::dropIfExists('nonfi_votes');
    }
}
