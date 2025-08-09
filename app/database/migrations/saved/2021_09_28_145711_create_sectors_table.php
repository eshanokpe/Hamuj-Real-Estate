<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateSectorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sectors', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('category_id');
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            $table->unsignedBigInteger('award_program_id');
            $table->foreign('award_program_id')->references('id')->on('award_programs')->onDelete('cascade');
            $table->string('name');
            $table->timestamps();
        });


        $sectors = [
            ['name'=> 'Commercial Banks','category_id'=> 1,'award_program_id' => 1,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Commercial Banks','category_id'=> 2,'award_program_id' => 1,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Commercial Banks','category_id'=> 3,'award_program_id' => 1,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Insurance', 'category_id'=> 3,'award_program_id' => 1,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Insurance', 'category_id'=> 1,'award_program_id' => 1,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Fintech','category_id'=> 3,'award_program_id' => 1,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Microfinance Banks', 'category_id'=> 3,'award_program_id' => 1,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Asset Management', 'category_id'=> 3,'award_program_id' => 1,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Pension Fund Operators','category_id'=> 3,'award_program_id' => 1,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Media', 'category_id'=> 4,'award_program_id' => 1,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Providers', 'category_id'=> 5,'award_program_id' => 1,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Governors','category_id'=> 6,'award_program_id' => 1,'created_at' => now(),'updated_at' => now()],

            ['name'=> 'Commercial Banks','category_id'=> 7,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Commercial Banks','category_id'=> 8,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Commercial Banks','category_id'=> 9,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Insurance', 'category_id'=> 7,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Insurance', 'category_id'=> 9,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Fintech','category_id'=> 9,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Microfinance Banks', 'category_id'=> 9,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Asset Management', 'category_id'=> 9,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Pension Fund Operators','category_id'=> 9,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Women in GRC', 'category_id'=>10, 'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Media', 'category_id'=> 11,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Providers', 'category_id'=> 12,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Governors','category_id'=> 13,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
        ];

        foreach($sectors as $sector){
            DB::table('sectors')->insert($sector);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sectors');
    }
}
