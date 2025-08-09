<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;


class CreateAwardProgramsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('award_programs', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->year('year');
            $table->string('location');
            $table->unsignedBigInteger('admin_id');
            $table->foreign('admin_id')->references('id')->on('admins')->onDelete('cascade');
            $table->boolean('status');
            $table->timestamps();
        });

        $ap = [
            ['name'=> 'GRCFinCrimeAwards2021','year' => '2021','location' => 'Nigeria','admin_id' => 1,'status' => false,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'GRCFinCrimeAwards2022','year' => '2022','location' => 'Nigeria','admin_id' => 1,'status' => true,'created_at' => now(),'updated_at' => now()],
        ];

        foreach ($ap as $awardyear)
            DB::table('award_programs')->insert($awardyear);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('award_programs');
    }
}
