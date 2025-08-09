<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('award_program_id');
            $table->foreign('award_program_id')->references('id')->on('award_programs')->onDelete('cascade');
            $table->string('name');
            $table->text('description');
            $table->timestamps();
        });


        $categories = [
            ['name'=> 'GRC & Financial Crime Prevention Excellence Awards','description'=> 'These awards recognise organisations that are well into their integrated GRC & Financial Crime Prevention Journey, with a clear integrated GRC & Financial Crime Prevention vision, systems with multiple lines of defense and a high focus on innovation.','award_program_id' => 1,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'GRC & Financial Crime Prevention Journey Awards','description'=> 'These awards recognise organisations that have made exceptional progress along their GRC Journey. The recipients have achieved an integrated, high value, and sustainable GRC program.','award_program_id' => 1,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'GRC & Financial Crime Prevention Achievement Awards','description'=> 'These awards recognise organisations and individuals that make great strides in embedding governance, risk management, and compliance (GRC) to attain principled performance. The award is given to the organisation that shows the real maturity in transiting to the integration between and across the risk management and compliance areas, making risk-aware decisions, and supporting the overall business performance.','award_program_id' => 1,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'GRC & Financial Crime Prevention Promoter Awards','description'=> 'These awards are to recognise the media for helping to promote GRC & Financial Crime Prevention.','award_program_id' => 1,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'GRC & Financial Crime Prevention Partner Awards','description'=>'These awards recognise GRC & Financial Crime Prevention Expert Associates who have a track record of being successful in demonstrating transformation in internal processes, deployment of technology, reporting, training, among others, to increase compliance and develop a best-practice model for promoting GRC & Financial Crime prevention.','award_program_id' => 1,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Special Recognition Awards','description'=>'Leadership Awards for supporting and promoting these initiatives by demonstration of exemplary leadership, implementing effective Governance, Anti-Financial Crime / AML and complying with statutory laws, regulations and standards in their various states (Public sector) in the Country.','award_program_id' => 1,'created_at' => now(),'updated_at' => now()],
            
            ['name'=> 'GRC & Financial Crime Prevention Excellence Awards','description'=> 'These awards recognise organisations that are well into their integrated GRC & Financial Crime Prevention Journey, with a clear integrated GRC & Financial Crime Prevention vision, systems with multiple lines of defense and a high focus on innovation.','award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'GRC & Financial Crime Prevention Journey Awards','description'=> 'These awards recognise organisations that have made exceptional progress along their GRC Journey. The recipients have achieved an integrated, high value, and sustainable GRC program.','award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'GRC & Financial Crime Prevention Achievement Awards','description'=> 'These awards recognise organisations and individuals that make great strides in embedding governance, risk management, and compliance (GRC) to attain principled performance. The award is given to the organisation that shows the real maturity in transiting to the integration between and across the risk management and compliance areas, making risk-aware decisions, and supporting the overall business performance.','award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Women in Governance, Risk and Compliance Awards','description'=> 'The Women in Governance, Risk and Compliance Awards honour female leaders demonstrating excellence across GRC. These Awards showcase the role models, advocates and mentors, as well as the inspirational women building and leading in the world of GRC. Please nominate a female leader in any of the Financial Sectors in Nigeria that meets this criteria.','award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'GRC & Financial Crime Prevention Promoter Awards','description'=> 'These awards are to recognise the media for helping to promote GRC & Financial Crime Prevention.','award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'GRC & Financial Crime Prevention Partner Awards','description'=>'These awards recognise GRC & Financial Crime Prevention Expert Associates who have a track record of being successful in demonstrating transformation in internal processes, deployment of technology, reporting, training, among others, to increase compliance and develop a best-practice model for promoting GRC & Financial Crime prevention.','award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Special Recognition Awards','description'=>'Leadership Awards for supporting and promoting these initiatives by demonstration of exemplary leadership, implementing effective Governance, Anti-Financial Crime / AML and complying with statutory laws, regulations and standards in their various states (Public sector) in the Country.','award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
        ];

        foreach($categories as $category){
            DB::table('categories')->insert($category);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('categories');
    }
}
