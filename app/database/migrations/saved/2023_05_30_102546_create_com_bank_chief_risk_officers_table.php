<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComBankChiefRiskOfficersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('com_bank_chief_risk_officers', function (Blueprint $table) {
            $table->id();
            $table->integer('award_id')->nullable();
            $table->integer('nominee_id')->nullable();
            $table->integer('sector_id')->nullable();
            $table->string('number_of_votes')->nullable();
            $table->string('percentage_votes')->nullable();
            $table->string('names')->nullable();
            $table->string('title')->nullable();
            $table->text('profile_on_linkedIn')->nullable();
            $table->text('recognised_professional_association_membership')->nullable();
            $table->text('number_of_independent_non_executive_directors')->nullable();
            $table->text('board_committee_in_place_covering_risk_management')->nullable();
            $table->text('evidence_of_policy_on_fin_crime_prevention')->nullable();
            $table->text('aml_policy')->nullable(); 
            $table->text('documentation')->nullable(); 
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
        Schema::dropIfExists('com_bank_chief_risk_officers');
    }
}
