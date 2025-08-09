<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVoteCountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vote_counts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('nominee_id')->nullable();
            $table->integer('award_id')->nullable();
            $table->integer('award_program_id')->nullable();
            $table->integer('voteCount')->nullable();
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
        Schema::dropIfExists('vote_counts');
    }
}
