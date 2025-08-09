<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;


class CreateNomineesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nominees', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('sector_id')->nullable;
            $table->string('award_ids')->nullable();
            $table->unsignedBigInteger('award_program_id');
            $table->foreign('award_program_id')->references('id')->on('award_programs')->onDelete('cascade');
            $table->timestamps();
        });

        $award1 = [1,2,3,4,5,6,7,8,9,10,11,12,13];
        $w1 = json_encode($award1);
        
        $award2 = [14,15,16];
        $w2 = json_encode($award2);
        
        $award3 = [17,18,19,20];
        $w3 = json_encode($award3);
        
        $award4 = [21,22,23,24];
        $w4 = json_encode($award4);

        $award5 = [25,26,27,28];
        $w5 = json_encode($award5);

        $award6 = [29,30,31,32];
        $w6 = json_encode($award6);

        $award7= [37];
        $w7 = json_encode($award7);
        $award8=[38];
        $w8 = json_encode($award8);
        $award9=[35];
        $w9 = json_encode($award9);
        $award10=[36];
        $w10 = json_encode($award10);
        $award11=[39];
        $w11 = json_encode($award11);


        $award12 = [40,41,42,43,44,45,46,47,48,49,50,51];
        $w12 = json_encode($award12);
        
        $award13 = [52,53,54];
        $w13 = json_encode($award13);
        
        $award14 = [55,56,57,58];
        $w14 = json_encode($award14);
        
        $award15 = [59,60,61,62];
        $w15 = json_encode($award15);

        $award16 = [63,64,65,66];
        $w16 = json_encode($award16);

        $award17 = [67,68,69,70];
        $w17 = json_encode($award17);

        $award18= [77];
        $w18 = json_encode($award18);

        $award19=[78];
        $w19 = json_encode($award19);

        $award20=[75];
        $w20 = json_encode($award20);

        $award21=[76];
        $w21 = json_encode($award21);

        $award22 = [79];
        $w22 = json_encode($award22);

        $award23 = [80];
        $w23 = json_encode($award23);

        $award24=[81];
        $w24 = json_encode($award24);

        
        $nominees = [
            ['name'=> 'Access Bank Plc','sector_id' => 1, 'award_ids'=> $w1, 'award_program_id' => 1,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Citibank Nigeria Limited','sector_id' => 1,'award_ids'=> $w1,'award_program_id' => 1,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Ecobank Nigeria Plc','sector_id' => 1,'award_ids'=> $w1,'award_program_id' => 1,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Fidelity Bank Plc','sector_id' => 1,'award_ids'=> $w1,'award_program_id' => 1,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'First City Monument Bank Plc','sector_id' => 1,'award_ids'=> $w1,'award_program_id' => 1,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Guaranty Trust Bank Plc','sector_id' => 1,'award_ids'=> $w1,'award_program_id' => 1,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'KeyStone Bank','sector_id' => 1,'award_ids'=> $w1,'award_program_id' => 1,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Polaris Bank','sector_id' => 1,'award_ids'=> $w1,'award_program_id' => 1,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Stanbic IBTC Bank Ltd.','sector_id' => 1,'award_ids'=> $w1,'award_program_id' => 1,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Standard Chartered Bank Nigeria Ltd.','sector_id' => 1,'award_ids'=> $w1,'award_program_id' => 1,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Sterling Bank Plc','sector_id' => 1,'award_ids'=> $w1,'award_program_id' => 1,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'SunTrust Bank Nigeria Limited','sector_id' => 1,'award_ids'=> $w1,'award_program_id' => 1,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Union Bank of Nigeria Plc','sector_id' => 1,'award_ids'=> $w1,'award_program_id' => 1,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'United Bank For Africa Plc','sector_id' => 1,'award_ids'=> $w1,'award_program_id' => 1,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Unity  Bank Plc','sector_id' => 1,'award_ids'=> $w1,'award_program_id' => 1,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Wema Bank Plc','sector_id' => 1,'award_ids'=> $w1,'award_program_id' => 1,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Zenith Bank Plc','sector_id' => 1,'award_ids'=> $w1,'award_program_id' => 1,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Heritage Banking Company Ltd.','sector_id' => 1,'award_ids'=> $w1,'award_program_id' => 1,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'First Bank Nigeria Limited','sector_id' => 1,'award_ids'=> $w1,'award_program_id' => 1,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Providus Bank','sector_id' => 1,'award_ids'=> $w1,'award_program_id' => 1,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Titan Trust Bank Ltd','sector_id' => 1,'award_ids'=> $w1,'award_program_id' => 1,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Globus Bank Limited','sector_id' => 1,'award_ids'=> $w1,'award_program_id' => 1,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Access Bank Plc','sector_id' => 2, 'award_ids'=> $w1,'award_program_id' => 1,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Citibank Nigeria Limited','sector_id' => 2,'award_ids'=> $w1,'award_program_id' => 1,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Ecobank Nigeria Plc','sector_id' => 2,'award_ids'=> $w1,'award_program_id' => 1,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Fidelity Bank Plc','sector_id' => 2,'award_ids'=> $w1,'award_program_id' => 1,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'First City Monument Bank Plc','sector_id' => 2,'award_ids'=> $w1,'award_program_id' => 1,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Guaranty Trust Bank Plc','sector_id' => 2,'award_ids'=> $w1,'award_program_id' => 1,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'KeyStone Bank','sector_id' => 2,'award_ids'=> $w1,'award_program_id' => 1,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Polaris Bank','sector_id' => 2,'award_ids'=> $w1,'award_program_id' => 1,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Stanbic IBTC Bank Ltd.','sector_id' => 2,'award_ids'=> $w1,'award_program_id' => 1,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Standard Chartered Bank Nigeria Ltd.','sector_id' => 2,'award_ids'=> $w1,'award_program_id' => 1,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Sterling Bank Plc','sector_id' => 2,'award_ids'=> $w1,'award_program_id' => 1,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'SunTrust Bank Nigeria Limited','sector_id' => 2,'award_ids'=> $w1,'award_program_id' => 1,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Union Bank of Nigeria Plc','sector_id' => 2,'award_ids'=> $w1,'award_program_id' => 1,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'United Bank For Africa Plc','sector_id' => 2,'award_ids'=> $w1,'award_program_id' => 1,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Unity  Bank Plc','sector_id' => 2,'award_ids'=> $w1,'award_program_id' => 1,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Wema Bank Plc','sector_id' => 2,'award_ids'=> $w1,'award_program_id' => 1,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Zenith Bank Plc','sector_id' => 2,'award_ids'=> $w1,'award_program_id' => 1,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Heritage Banking Company Ltd.','sector_id' => 2,'award_ids'=> $w1,'award_program_id' => 1,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'First Bank Nigeria Limited','sector_id' => 2,'award_ids'=> $w1,'award_program_id' => 1,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Providus Bank','sector_id' => 2,'award_ids'=> $w1,'award_program_id' => 1,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Titan Trust Bank Ltd','sector_id' => 2,'award_ids'=> $w1,'award_program_id' => 1,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Globus Bank Limited','sector_id' => 2,'award_ids'=> $w1,'award_program_id' => 1,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Access Bank Plc','sector_id' => 3,'award_ids'=> $w1, 'award_program_id' => 1,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Citibank Nigeria Limited','sector_id' => 3,'award_ids'=> $w1,'award_program_id' => 1,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Ecobank Nigeria Plc','sector_id' => 3,'award_ids'=> $w1,'award_program_id' => 1,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Fidelity Bank Plc','sector_id' => 3,'award_ids'=> $w1,'award_program_id' => 1,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'First City Monument Bank Plc','sector_id' => 3,'award_ids'=> $w1,'award_program_id' => 1,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Guaranty Trust Bank Plc','sector_id' => 3,'award_ids'=> $w1,'award_program_id' => 1,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'KeyStone Bank','sector_id' => 3,'award_ids'=> $w1,'award_program_id' => 1,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Polaris Bank','sector_id' => 3,'award_ids'=> $w1,'award_program_id' => 1,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Stanbic IBTC Bank Ltd.','sector_id' => 3,'award_ids'=> $w1,'award_program_id' => 1,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Standard Chartered Bank Nigeria Ltd.','sector_id' => 3,'award_ids'=> $w1,'award_program_id' => 1,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Sterling Bank Plc','sector_id' => 3,'award_ids'=> $w1,'award_program_id' => 1,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'SunTrust Bank Nigeria Limited','sector_id' => 3,'award_ids'=> $w1,'award_program_id' => 1,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Union Bank of Nigeria Plc','sector_id' => 3,'award_ids'=> $w1,'award_program_id' => 1,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'United Bank For Africa Plc','sector_id' => 3,'award_ids'=> $w1,'award_program_id' => 1,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Unity  Bank Plc','sector_id' => 3,'award_ids'=> $w1,'award_program_id' => 1,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Wema Bank Plc','sector_id' => 3,'award_ids'=> $w1,'award_program_id' => 1,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Zenith Bank Plc','sector_id' => 3,'award_ids'=> $w1,'award_program_id' => 1,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Heritage Banking Company Ltd.','sector_id' => 3,'award_ids'=> $w1,'award_program_id' => 1,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'First Bank Nigeria Limited','sector_id' => 3,'award_ids'=> $w1,'award_program_id' => 1,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Providus Bank','sector_id' => 3,'award_ids'=> $w1,'award_program_id' => 1,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Titan Trust Bank Ltd','sector_id' => 3,'award_ids'=> $w1,'award_program_id' => 1,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Globus Bank Limited','sector_id' => 3,'award_ids'=> $w1,'award_program_id' => 1,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'AIICO Insurance Plc','sector_id' => 4,'award_ids'=> $w2,'award_program_id' => 1,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'AXA Mansard Insurance Plc','sector_id' => 4,'award_ids'=> $w2,'award_program_id' => 1,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'CornerStone Insurance Plc','sector_id' => 4,'award_ids'=> $w2,'award_program_id' => 1,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'GoldLink Insurance Plc','sector_id' => 4,'award_ids'=> $w2,'award_program_id' => 1,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'LASACO Assurance Plc','sector_id' => 4,'award_ids'=> $w2,'award_program_id' => 1,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Leadway Assurance Company Ltd.','sector_id' => 4,'award_ids'=> $w2,'award_program_id' => 1,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Niger Insurance Ltd.','sector_id' => 4,'award_ids'=> $w2,'award_program_id' => 1,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Anchor Insurance Company Ltd.','sector_id' => 4,'award_ids'=> $w2,'award_program_id' => 1,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Custodian & Allied Insurance Ltd.','sector_id' => 4,'award_ids'=> $w2,'award_program_id' => 1,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Mutual Benefits Assurance Plc','sector_id' => 4,'award_ids'=> $w2,'award_program_id' => 1,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'NEM Insurance Plc','sector_id' => 4,'award_ids'=> $w2,'award_program_id' => 1,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Royal Exchange Plc','sector_id' => 4,'award_ids'=> $w2,'award_program_id' => 1,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Sovereign Trust Insurance Plc','sector_id' => 4,'award_ids'=> $w2,'award_program_id' => 1,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Coronation Insurance Plc','sector_id' => 4,'award_ids'=> $w2,'award_program_id' => 1,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'AFrican Alliance Insurance Company Ltd.','sector_id' => 4,'award_ids'=> $w2,'award_program_id' => 1,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'FBN Insurance ltd.','sector_id' => 4,'award_ids'=> $w2,'award_program_id' => 1,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Continental Reinsurance Plc','sector_id' => 4,'award_ids'=> $w2,'award_program_id' => 1,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Consolidated hallmark Insurance Plc','sector_id' => 4,'award_ids'=> $w2,'award_program_id' => 1,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'AIICO Insurance Plc','sector_id' => 5,'award_ids'=> $w2,'award_program_id' => 1,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'AXA Mansard Insurance Plc','sector_id' => 5,'award_ids'=> $w2,'award_program_id' => 1,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'CornerStone Insurance Plc','sector_id' => 5,'award_ids'=> $w2,'award_program_id' => 1,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'GoldLink Insurance Plc','sector_id' => 5,'award_ids'=> $w2,'award_program_id' => 1,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'LASACO Assurance Plc','sector_id' => 5,'award_ids'=> $w2,'award_program_id' => 1,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Leadway Assurance Company Ltd.','sector_id' => 5,'award_ids'=> $w2,'award_program_id' => 1,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Niger Insurance Ltd.','sector_id' => 5,'award_ids'=> $w2,'award_program_id' => 1,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Anchor Insurance Company Ltd.','sector_id' => 5,'award_ids'=> $w2,'award_program_id' => 1,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Custodian & Allied Insurance Ltd.','sector_id' => 5,'award_ids'=> $w2,'award_program_id' => 1,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Mutual Benefits Assurance Plc','sector_id' => 5,'award_ids'=> $w2,'award_program_id' => 1,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'NEM Insurance Plc','sector_id' => 5,'award_ids'=> $w2,'award_program_id' => 1,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Royal Exchange Plc','sector_id' => 5,'award_ids'=> $w2,'award_program_id' => 1,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Sovereign Trust Insurance Plc','sector_id' => 5,'award_ids'=> $w2,'award_program_id' => 1,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Coronation Insurance Plc','sector_id' => 5,'award_ids'=> $w2,'award_program_id' => 1,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'AFrican Alliance Insurance Company Ltd.','sector_id' => 5,'award_ids'=> $w2,'award_program_id' => 1,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'FBN Insurance ltd.','sector_id' => 5,'award_ids'=> $w2,'award_program_id' => 1,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Continental Reinsurance Plc','sector_id' => 5,'award_ids'=> $w2,'award_program_id' => 1,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Consolidated hallmark Insurance Plc','sector_id' => 5,'award_ids'=> $w2,'award_program_id' => 1,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Interswitch','sector_id' => 6,'award_ids'=>$w3,'award_program_id' => 1,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Cowrywise','sector_id' => 6,'award_ids'=>$w3,'award_program_id' => 1,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Carbon (formerly known as Paylater)','sector_id' => 6,'award_ids'=>$w3,'award_program_id' => 1,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'PalmPay','sector_id' => 6,'award_ids'=>$w3,'award_program_id' => 1,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'TeamApt','sector_id' => 6,'award_ids'=>$w3,'award_program_id' => 1,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Lidya','sector_id' => 6,'award_ids'=>$w3,'award_program_id' => 1,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Appzone','sector_id' => 6,'award_ids'=>$w3,'award_program_id' => 1,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'PayPad','sector_id' => 6,'award_ids'=>$w3,'award_program_id' => 1,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'PAGA','sector_id' => 6,'award_ids'=>$w3,'award_program_id' => 1,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'eTranzact','sector_id' => 6,'award_ids'=>$w3,'award_program_id' => 1,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'PiggyVest','sector_id' => 6,'award_ids'=>$w3,'award_program_id' => 1,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Flutterwave','sector_id' => 6,'award_ids'=>$w3,'award_program_id' => 1,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Paystack','sector_id' => 6,'award_ids'=>$w3,'award_program_id' => 1,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Remita / SystemSpecs','sector_id' => 6,'award_ids'=>$w3,'award_program_id' => 1,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Kuda','sector_id' => 6,'award_ids'=>$w3,'award_program_id' => 1,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Opay','sector_id' => 6,'award_ids'=>$w3,'award_program_id' => 1,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Credpal','sector_id' => 6,'award_ids'=>$w3,'award_program_id' => 1,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Fairmoney','sector_id' => 6,'award_ids'=>$w3,'award_program_id' => 1,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Fint','sector_id' => 6,'award_ids'=>$w3,'award_program_id' => 1,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Cellulant','sector_id' => 6,'award_ids'=>$w3,'award_program_id' => 1,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Wallet Africa','sector_id' => 6,'award_ids'=>$w3,'award_program_id' => 1,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Bankly','sector_id' => 6,'award_ids'=>$w3,'award_program_id' => 1,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Voguepay','sector_id' => 6,'award_ids'=>$w3,'award_program_id' => 1,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Patricia','sector_id' => 6,'award_ids'=>$w3,'award_program_id' => 1,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Abeg','sector_id' => 6,'award_ids'=>$w3,'award_program_id' => 1,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'AB Microfinance Bank Limited','sector_id' => 7,'award_ids' => $w4,'award_program_id' => 1,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Accion Microfinance Bank Limited','sector_id' => 7,'award_ids' => $w4,'award_program_id' => 1,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Addosser Microfinance Bank Limited','sector_id' => 7,'award_ids' => $w4,'award_program_id' => 1,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Finatrust Microfinance Bank Limited','sector_id' => 7,'award_ids' => $w4,'award_program_id' => 1,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Ibile Microfinance Bank LImited','sector_id' => 7,'award_ids' => $w4,'award_program_id' => 1,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Lapo Microfinance Bank Ltd','sector_id' => 7,'award_ids' => $w4,'award_program_id' => 1,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Mainstreet Microfinance Bank Limited','sector_id' => 7,'award_ids' => $w4,'award_program_id' => 1,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Neptune Microfinance Bank','sector_id' => 7,'award_ids' => $w4,'award_program_id' => 1,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Purple Money Microfinance Bank Limited','sector_id' => 7,'award_ids' => $w4,'award_program_id' => 1,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Richway Microfinance Bank Ltd','sector_id' => 7,'award_ids' => $w4,'award_program_id' => 1,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'AIICO Capital Limited','sector_id' => 8,'award_ids' => $w5,'award_program_id' => 1,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Arthur Stevens Asset Management Limited','sector_id' => 8,'award_ids' => $w5,'award_program_id' => 1,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'ARM Investment Managers Limited','sector_id' => 8,'award_ids' => $w5,'award_program_id' => 1,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'AXA Mansard Investments Ltd','sector_id' => 8,'award_ids' => $w5,'award_program_id' => 1,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'CardinalStone Partners Limited','sector_id' => 8,'award_ids' => $w5,'award_program_id' => 1,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Chapel Hill Denham Management Ltd','sector_id' => 8,'award_ids' => $w5,'award_program_id' => 1,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Comercio Partners Asset Management Limited','sector_id' => 8,'award_ids' => $w5,'award_program_id' => 1,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Cordros Asset Management Ltd','sector_id' => 8,'award_ids' => $w5,'award_program_id' => 1,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Coronation Asset Management Ltd','sector_id' => 8,'award_ids' => $w5,'award_program_id' => 1,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'EDC Fund Management Ltd','sector_id' => 8,'award_ids' => $w5,'award_program_id' => 1,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'FBNQuest Asset Management Limited','sector_id' => 8,'award_ids' => $w5,'award_program_id' => 1,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'FCMB Asset Management Limited','sector_id' => 8,'award_ids' => $w5,'award_program_id' => 1,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'FSDH Asset Management Ltd.','sector_id' => 8,'award_ids' => $w5,'award_program_id' => 1,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Greenwich Asset Management Ltd.','sector_id' => 8,'award_ids' => $w5,'award_program_id' => 1,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Investment One Funds Management','sector_id' => 8,'award_ids' => $w5,'award_program_id' => 1,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Kedari Capital Limited','sector_id' => 8,'award_ids' => $w5,'award_program_id' => 1,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Lotus Capital Ltd','sector_id' => 8,'award_ids' => $w5,'award_program_id' => 1,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Quantum Zenith Asset Management & Investments Limited','sector_id' => 8,'award_ids' => $w5,'award_program_id' => 1,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Stanbic IBTC Asset Management Limited','sector_id' => 8,'award_ids' => $w5,'award_program_id' => 1,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Sterling Capital Markets Ltd.','sector_id' => 8,'award_ids' => $w5,'award_program_id' => 1,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'United Capital Asset Management Limited','sector_id' => 8,'award_ids' => $w5,'award_program_id' => 1,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'AIICO Pension Managers Limited','sector_id' => 9,'award_ids' => $w6,'award_program_id' => 1,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'APT Pension Fund Managers Limited','sector_id' => 9,'award_ids' => $w6,'award_program_id' => 1,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'ARM Pension Managers Limited','sector_id' => 9,'award_ids' => $w6,'award_program_id' => 1,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'CrusaderSterling Pensions Limited','sector_id' => 9,'award_ids' => $w6,'award_program_id' => 1,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'FCMB Pensions Limited','sector_id' => 9,'award_ids' => $w6,'award_program_id' => 1,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Fidelity Pension Managers','sector_id' => 9,'award_ids' => $w6,'award_program_id' => 1,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'First Guarantee Pension Limited','sector_id' => 9,'award_ids' => $w6,'award_program_id' => 1,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'IEI-Anchor Pension Managers Limited','sector_id' => 9,'award_ids' => $w6,'award_program_id' => 1,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Investment One Pension Managers Limited','sector_id' => 9,'award_ids' => $w6,'award_program_id' => 1,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Leadway Pensure PFA Limited','sector_id' => 9,'award_ids' => $w6,'award_program_id' => 1,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'NLPC Pension Fund Administrators Limited','sector_id' => 9,'award_ids' => $w6,'award_program_id' => 1,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'OAK Pensions Limited','sector_id' => 9,'award_ids' => $w6,'award_program_id' => 1,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Pensions Alliance Limited','sector_id' => 9,'award_ids' => $w6,'award_program_id' => 1,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Premium Pension Limited','sector_id' => 9,'award_ids' => $w6,'award_program_id' => 1,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Radix Pension Managers Limited','sector_id' => 9,'award_ids' => $w6,'award_program_id' => 1,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Sigma Pensions Limited','sector_id' => 9,'award_ids' => $w6,'award_program_id' => 1,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Stanbic IBTC Pension Managers Limited','sector_id' => 9,'award_ids' => $w6,'award_program_id' => 1,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Tangerine Pensions Limited','sector_id' => 9,'award_ids' => $w6,'award_program_id' => 1,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Trustfund Pensions Limited','sector_id' => 9,'award_ids' => $w6,'award_program_id' => 1,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Veritas Glanvills Pensions Limited','sector_id' => 9,'award_ids' => $w6,'award_program_id' => 1,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Access Pension Fund Custodian Limited','sector_id' => 9,'award_ids' => $w6,'award_program_id' => 1,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'First Pension Custodian Nigeria Limited','sector_id' => 9,'award_ids' => $w6,'award_program_id' => 1,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'UBA Pensions Custodian Limited','sector_id' => 9,'award_ids' => $w6,'award_program_id' => 1,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Zenith Pensions Custodian Limited','sector_id' => 9,'award_ids' => $w6,'award_program_id' => 1,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'E-Four and AAF','sector_id' => 11,'award_ids' => $w7,'award_program_id' => 1,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'g-Log Consult','sector_id' => 11,'award_ids' => $w7,'award_program_id' => 1,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Financial Institutions Training Centre (FITC)','sector_id' => 11,'award_ids' => $w7,'award_program_id' => 1,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Tenol Alpha','sector_id' => 11,'award_ids' => $w7,'award_program_id' => 1,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Capacity for Africa','sector_id' => 11,'award_ids' => $w7,'award_program_id' => 1,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Fontini Consulting','sector_id' => 11,'award_ids' => $w7,'award_program_id' => 1,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'GTC Group','sector_id' => 11,'award_ids' => $w7,'award_program_id' => 1,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Compliance Institute Nigeria','sector_id' => 11,'award_ids' => $w7,'award_program_id' => 1,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'RIMAN','sector_id' => 11,'award_ids' => $w7,'award_program_id' => 1,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'McTimothy Associates Consulting LLC','sector_id' => 11,'award_ids' => $w7,'award_program_id' => 1,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Lagos Business School','sector_id' => 11,'award_ids' => $w7,'award_program_id' => 1,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'DataPro','sector_id' => 11,'award_ids' => $w7,'award_program_id' => 1,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'E-Four and AAF','sector_id' => 11,'award_ids' => $w8,'award_program_id' => 1,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'g-Log Consult','sector_id' => 11,'award_ids' => $w8,'award_program_id' => 1,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Financial Institutions Training Centre (FITC)','sector_id' => 11,'award_ids' => $w8,'award_program_id' => 1,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Tenol Alpha','sector_id' => 11,'award_ids' => $w8,'award_program_id' => 1,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Capacity for Africa','sector_id' => 11,'award_ids' => $w8,'award_program_id' => 1,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Fontini Consulting','sector_id' => 11,'award_ids' => $w8,'award_program_id' => 1,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'GTC Group','sector_id' => 11,'award_ids' => $w8,'award_program_id' => 1,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Compliance Institute Nigeria','sector_id' => 11,'award_ids' => $w8,'award_program_id' => 1,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'RIMAN','sector_id' => 11,'award_ids' => $w8,'award_program_id' => 1,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'McTimothy Associates Consulting LLC','sector_id' => 11,'award_ids' => $w8,'award_program_id' => 1,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Lagos Business School','sector_id' => 11,'award_ids' => $w8,'award_program_id' => 1,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'DataPro','sector_id' => 11,'award_ids' => $w8,'award_program_id' => 1,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'SentryGRC','sector_id' => 11,'award_ids' => $w9,'award_program_id' => 1,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Mitiget','sector_id' => 11,'award_ids' => $w9,'award_program_id' => 1,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Digital Jewel','sector_id' => 11,'award_ids' => $w9,'award_program_id' => 1,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Rhythex ','sector_id' => 11,'award_ids' => $w9,'award_program_id' => 1,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Idealab Management Services Limited','sector_id' => 11,'award_ids' => $w9,'award_program_id' => 1,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'ShuftiPro','sector_id' => 11,'award_ids' => $w10,'award_program_id' => 1,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Idealab Management Services Limited','sector_id' => 11,'award_ids' => $w10,'award_program_id' => 1,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Sanction Scanner','sector_id' => 11,'award_ids' => $w10,'award_program_id' => 1,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'YouVerify','sector_id' => 11,'award_ids' => $w10,'award_program_id' => 1,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Babajide SanwoOlu (Gov. of Lagos State)','sector_id' => 12,'award_ids' => $w11,'award_program_id' => 1,'created_at' => now(),'updated_at' => now()],
            

            ['name'=> 'Access Bank Plc','sector_id' => 13, 'award_ids'=> $w12, 'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Citibank Nigeria Limited','sector_id' => 13,'award_ids'=> $w12,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Ecobank Nigeria Plc','sector_id' => 13,'award_ids'=> $w12,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Fidelity Bank Plc','sector_id' => 13,'award_ids'=> $w12,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'First City Monument Bank Plc','sector_id' => 13,'award_ids'=> $w12,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Guaranty Trust Bank Plc','sector_id' => 13,'award_ids'=> $w12,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'KeyStone Bank','sector_id' => 13,'award_ids'=> $w12,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Polaris Bank','sector_id' => 13,'award_ids'=> $w12,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Stanbic IBTC Bank Ltd.','sector_id' => 13,'award_ids'=> $w12,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Standard Chartered Bank Nigeria Ltd.','sector_id' => 13,'award_ids'=> $w12,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Sterling Bank Plc','sector_id' => 13,'award_ids'=> $w12,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'SunTrust Bank Nigeria Limited','sector_id' => 13,'award_ids'=> $w12,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Union Bank of Nigeria Plc','sector_id' => 13,'award_ids'=> $w12,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'United Bank For Africa Plc','sector_id' => 13,'award_ids'=> $w12,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Unity  Bank Plc','sector_id' => 13,'award_ids'=> $w12,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Wema Bank Plc','sector_id' => 13,'award_ids'=> $w12,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Zenith Bank Plc','sector_id' => 13,'award_ids'=> $w12,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Heritage Banking Company Ltd.','sector_id' => 13,'award_ids'=> $w12,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'First Bank Nigeria Limited','sector_id' => 13,'award_ids'=> $w12,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Providus Bank','sector_id' => 13,'award_ids'=> $w12,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Titan Trust Bank Ltd','sector_id' => 13,'award_ids'=> $w12,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Globus Bank Limited','sector_id' => 13,'award_ids'=> $w12,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Premium Trust Bank','sector_id' => 13,'award_ids'=> $w12,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Parallex Bank','sector_id' => 13,'award_ids'=> $w12,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],

            ['name'=> 'Access Bank Plc','sector_id' => 14, 'award_ids'=> $w12,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Citibank Nigeria Limited','sector_id' => 14,'award_ids'=> $w12,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Ecobank Nigeria Plc','sector_id' => 14,'award_ids'=> $w12,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Fidelity Bank Plc','sector_id' => 14,'award_ids'=> $w12,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'First City Monument Bank Plc','sector_id' => 14,'award_ids'=> $w12,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Guaranty Trust Bank Plc','sector_id' => 14,'award_ids'=> $w12,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'KeyStone Bank','sector_id' => 14,'award_ids'=> $w12,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Polaris Bank','sector_id' => 14,'award_ids'=> $w12,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Stanbic IBTC Bank Ltd.','sector_id' => 14,'award_ids'=> $w12,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Standard Chartered Bank Nigeria Ltd.','sector_id' => 14,'award_ids'=> $w12,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Sterling Bank Plc','sector_id' => 14,'award_ids'=> $w12,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'SunTrust Bank Nigeria Limited','sector_id' => 14,'award_ids'=> $w12,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Union Bank of Nigeria Plc','sector_id' => 14,'award_ids'=> $w12,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'United Bank For Africa Plc','sector_id' => 14,'award_ids'=> $w12,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Unity  Bank Plc','sector_id' => 14,'award_ids'=> $w12,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Wema Bank Plc','sector_id' => 14,'award_ids'=> $w12,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Zenith Bank Plc','sector_id' => 14,'award_ids'=> $w12,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Heritage Banking Company Ltd.','sector_id' => 14,'award_ids'=> $w12,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'First Bank Nigeria Limited','sector_id' => 14,'award_ids'=> $w12,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Providus Bank','sector_id' => 14,'award_ids'=> $w12,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Titan Trust Bank Ltd','sector_id' => 14,'award_ids'=> $w12,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Globus Bank Limited','sector_id' => 14,'award_ids'=> $w12,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Premium Trust Bank','sector_id' => 14,'award_ids'=> $w12,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Parallex Bank','sector_id' => 14,'award_ids'=> $w12,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],

            ['name'=> 'Access Bank Plc','sector_id' => 15,'award_ids'=> $w12, 'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Citibank Nigeria Limited','sector_id' => 15,'award_ids'=> $w12,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Ecobank Nigeria Plc','sector_id' => 15,'award_ids'=> $w12,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Fidelity Bank Plc','sector_id' => 15,'award_ids'=> $w12,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'First City Monument Bank Plc','sector_id' => 15,'award_ids'=> $w12,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Guaranty Trust Bank Plc','sector_id' => 15,'award_ids'=> $w12,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'KeyStone Bank','sector_id' => 15,'award_ids'=> $w12,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Polaris Bank','sector_id' => 15,'award_ids'=> $w12,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Stanbic IBTC Bank Ltd.','sector_id' => 15,'award_ids'=> $w12,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Standard Chartered Bank Nigeria Ltd.','sector_id' => 15,'award_ids'=> $w12,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Sterling Bank Plc','sector_id' => 15,'award_ids'=> $w12,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'SunTrust Bank Nigeria Limited','sector_id' => 15,'award_ids'=> $w12,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Union Bank of Nigeria Plc','sector_id' => 15,'award_ids'=> $w12,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'United Bank For Africa Plc','sector_id' => 15,'award_ids'=> $w12,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Unity  Bank Plc','sector_id' => 15,'award_ids'=> $w12,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Wema Bank Plc','sector_id' => 15,'award_ids'=> $w12,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Zenith Bank Plc','sector_id' => 15,'award_ids'=> $w12,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Heritage Banking Company Ltd.','sector_id' => 15,'award_ids'=> $w12,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'First Bank Nigeria Limited','sector_id' => 15,'award_ids'=> $w12,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Providus Bank','sector_id' => 15,'award_ids'=> $w12,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Titan Trust Bank Ltd','sector_id' => 15,'award_ids'=> $w12,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Globus Bank Limited','sector_id' => 15,'award_ids'=> $w12,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Premium Trust Bank','sector_id' => 15,'award_ids'=> $w12,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Parallex Bank','sector_id' => 15,'award_ids'=> $w12,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],

            ['name'=> 'African Alliance Insurance Company Ltd.','sector_id' => 16,'award_ids'=> $w13,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'AIICO Insurance Plc','sector_id' => 16,'award_ids'=> $w13,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Allianz Nigeria Insurance','sector_id' => 16,'award_ids'=> $w13,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Anchor Insurance Company Ltd.','sector_id' => 16,'award_ids'=> $w13,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'AXA Mansard Insurance Plc','sector_id' => 16,'award_ids'=> $w13,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Consolidated Hallmark Insurance Plc','sector_id' => 16,'award_ids'=> $w13,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Continental Reinsurance Plc','sector_id' => 16,'award_ids'=> $w13,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'CornerStone Insurance Plc','sector_id' => 16,'award_ids'=> $w13,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Coronation Insurance Plc','sector_id' => 16,'award_ids'=> $w13,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Custodian & Allied Insurance Ltd.','sector_id' => 16,'award_ids'=> $w13,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'FBN Insurance ltd.','sector_id' => 16,'award_ids'=> $w13,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'GoldLink Insurance Plc','sector_id' => 16,'award_ids'=> $w13,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Great Nigeria Insurance Plc','sector_id' => 16,'award_ids'=> $w13,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Heirs Insurance','sector_id' => 16,'award_ids'=> $w13,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Industrial and General insurance Plc','sector_id' => 16,'award_ids'=> $w13,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'LASACO Assurance Plc','sector_id' => 16,'award_ids'=> $w13,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Law Union and Rock Insurances','sector_id' => 16,'award_ids'=> $w13,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Leadway Assurance Company Ltd.','sector_id' => 16,'award_ids'=> $w13,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Mutual Benefits Assurance Plc','sector_id' => 16,'award_ids'=> $w13,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'NEM Insurance Plc','sector_id' => 16,'award_ids'=> $w13,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Nicon insurance','sector_id' => 16,'award_ids'=> $w13,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Regency Alliance Insurance Plc','sector_id' => 16,'award_ids'=> $w13,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Royal Exchange Plc','sector_id' => 16,'award_ids'=> $w13,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Sovereign Trust Insurance Plc','sector_id' => 16,'award_ids'=> $w13,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Staco Insurance plc','sector_id' => 16,'award_ids'=> $w13,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            
            ['name'=> 'African Alliance Insurance Company Ltd.','sector_id' => 17,'award_ids'=> $w13,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'AIICO Insurance Plc','sector_id' => 17,'award_ids'=> $w13,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Allianz Nigeria Insurance','sector_id' => 17,'award_ids'=> $w13,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Anchor Insurance Company Ltd.','sector_id' => 17,'award_ids'=> $w13,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'AXA Mansard Insurance Plc','sector_id' => 17,'award_ids'=> $w13,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Consolidated Hallmark Insurance Plc','sector_id' => 17,'award_ids'=> $w13,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Continental Reinsurance Plc','sector_id' => 17,'award_ids'=> $w13,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'CornerStone Insurance Plc','sector_id' => 17,'award_ids'=> $w13,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Custodian & Allied Insurance Ltd.','sector_id' => 17,'award_ids'=> $w13,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'FBN Insurance ltd.','sector_id' => 17,'award_ids'=> $w13,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'GoldLink Insurance Plc','sector_id' => 17,'award_ids'=> $w13,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Great Nigeria Insurance Plc','sector_id' => 17,'award_ids'=> $w13,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Heirs Insurance','sector_id' => 17,'award_ids'=> $w13,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Industrial and General insurance Plc','sector_id' => 17,'award_ids'=> $w13,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'LASACO Assurance Plc','sector_id' => 17,'award_ids'=> $w13,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Law Union and Rock Insurances','sector_id' => 17,'award_ids'=> $w13,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Leadway Assurance Company Ltd.','sector_id' => 17,'award_ids'=> $w13,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Mutual Benefits Assurance Plc','sector_id' => 17,'award_ids'=> $w13,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'NEM Insurance Plc','sector_id' => 17,'award_ids'=> $w13,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Nicon insurance','sector_id' => 17,'award_ids'=> $w13,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Regency Alliance Insurance Plc','sector_id' => 17,'award_ids'=> $w13,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Royal Exchange Plc','sector_id' => 17,'award_ids'=> $w13,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Sovereign Trust Insurance Plc','sector_id' => 17,'award_ids'=> $w13,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Staco Insurance plc','sector_id' => 17,'award_ids'=> $w13,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],


            ['name'=> 'Interswitch','sector_id' => 18,'award_ids'=>$w14,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Cowrywise','sector_id' => 18,'award_ids'=>$w14,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Carbon (formerly known as Paylater)','sector_id' => 18,'award_ids'=>$w14,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'PalmPay','sector_id' => 18,'award_ids'=>$w14,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Mintyn','sector_id' => 18,'award_ids'=>$w14,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'PAGA','sector_id' => 18,'award_ids'=>$w14,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'eTranzact','sector_id' => 18,'award_ids'=>$w14,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'PiggyVest','sector_id' => 18,'award_ids'=>$w14,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Flutterwave','sector_id' => 18,'award_ids'=>$w14,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Paystack','sector_id' => 18,'award_ids'=>$w14,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Remita / SystemSpecs','sector_id' => 18,'award_ids'=>$w14,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Kuda','sector_id' => 18,'award_ids'=>$w14,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Opay','sector_id' => 18,'award_ids'=>$w14,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Voguepay','sector_id' => 18,'award_ids'=>$w14,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Accelerex','sector_id' => 18,'award_ids'=>$w14,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            
            ['name'=> 'AB Microfinance Bank Limited','sector_id' => 19,'award_ids' => $w15,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Accion Microfinance Bank Limited','sector_id' => 19,'award_ids' => $w15,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Addosser Microfinance Bank Limited','sector_id' => 19,'award_ids' => $w15,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Finatrust Microfinance Bank Limited','sector_id' => 19,'award_ids' => $w15,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Ibile Microfinance Bank LImited','sector_id' => 19,'award_ids' => $w15,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'LAPO Microfinance Bank Ltd','sector_id' => 19,'award_ids' => $w15,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Mainstreet Microfinance Bank Limited','sector_id' => 19,'award_ids' => $w15,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Neptune Microfinance Bank','sector_id' => 19,'award_ids' => $w15,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Purple Money Microfinance Bank Limited','sector_id' => 19,'award_ids' => $w15,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Richway Microfinance Bank Ltd','sector_id' => 19,'award_ids' => $w15,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'FBN Microfinance Bank','sector_id' => 19,'award_ids' => $w15,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Mutual Trust Microfinance Bank','sector_id' => 19,'award_ids' => $w15,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Rehoboth Microfinance Bank','sector_id' => 19,'award_ids' => $w15,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Altitude Microfinance Bank','sector_id' => 19,'award_ids' => $w15,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'VFD Microfinance Bank','sector_id' => 19,'award_ids' => $w15,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'BOI Microfinance Bank Nigeria','sector_id' => 19,'award_ids' => $w15,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],

            ['name'=> 'AIICO Capital Limited','sector_id' => 20,'award_ids' => $w16,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'ARM Investment Managers Limited','sector_id' => 20,'award_ids' => $w16,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'AXA Mansard Investments Ltd','sector_id' => 20,'award_ids' => $w16,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'CardinalStone Partners Limited','sector_id' => 20,'award_ids' => $w16,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Chapel Hill Denham Management Ltd','sector_id' => 20,'award_ids' => $w16,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Comercio Partners Asset Management Limited','sector_id' => 20,'award_ids' => $w16,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Cordros Asset Management Ltd','sector_id' => 20,'award_ids' => $w16,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Coronation Asset Management Ltd','sector_id' => 20,'award_ids' => $w16,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'EDC Fund Management Ltd','sector_id' => 20,'award_ids' => $w16,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'FBNQuest Asset Management Limited','sector_id' => 20,'award_ids' => $w16,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'FCMB Asset Management Limited','sector_id' => 20,'award_ids' => $w16,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'FSDH Asset Management Ltd.','sector_id' => 20,'award_ids' => $w16,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Greenwich Asset Management Ltd.','sector_id' => 20,'award_ids' => $w16,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Investment One Funds Management','sector_id' => 20,'award_ids' => $w16,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Kedari Capital Limited','sector_id' => 20,'award_ids' => $w16,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Lotus Capital Ltd','sector_id' => 20,'award_ids' => $w16,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Quantum Zenith Asset Management & Investments Limited','sector_id' => 20,'award_ids' => $w16,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Stanbic IBTC Asset Management Limited','sector_id' => 20,'award_ids' => $w16,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Sterling Capital Markets Ltd.','sector_id' => 20,'award_ids' => $w16,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'United Capital Asset Management Limited','sector_id' => 20,'award_ids' => $w16,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],

            
            ['name'=> 'ARM Pension Managers Limited','sector_id' => 21,'award_ids' => $w17,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'CrusaderSterling Pensions Limited','sector_id' => 21,'award_ids' => $w17,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'FCMB Pensions Limited','sector_id' => 21,'award_ids' => $w17,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Fidelity Pension Managers','sector_id' => 21,'award_ids' => $w17,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'First Guarantee Pension Limited','sector_id' => 21,'award_ids' => $w17,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Norrenberger Pension Limited','sector_id' => 21,'award_ids' => $w17,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Guaranty Trust Pension Managers Limited','sector_id' => 21,'award_ids' => $w17,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Leadway Pensure PFA Limited','sector_id' => 21,'award_ids' => $w17,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'NLPC Pension Fund Administrators Limited','sector_id' => 21,'award_ids' => $w17,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'OAK Pensions Limited','sector_id' => 21,'award_ids' => $w17,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Pensions Alliance Limited','sector_id' => 21,'award_ids' => $w17,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Premium Pension Limited','sector_id' => 21,'award_ids' => $w17,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Radix Pension Managers Limited','sector_id' => 21,'award_ids' => $w17,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Sigma Pensions Limited','sector_id' => 21,'award_ids' => $w17,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Stanbic IBTC Pension Managers Limited','sector_id' => 21,'award_ids' => $w17,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Tangerine Pensions Limited','sector_id' => 21,'award_ids' => $w17,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Trustfund Pensions Limited','sector_id' => 21,'award_ids' => $w17,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Veritas Glanvills Pensions Limited','sector_id' => 21,'award_ids' => $w17,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'First Pension Custodian Nigeria Limited','sector_id' => 21,'award_ids' => $w17,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'UBA Pensions Custodian Limited','sector_id' => 21,'award_ids' => $w17,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Zenith Pensions Custodian Limited','sector_id' => 21,'award_ids' => $w17,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            
            ['name'=> 'E-Four and AAF','sector_id' => 25,'award_ids' => $w18,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'g-Log Consult','sector_id' => 25,'award_ids' => $w18,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Financial Institutions Training Centre (FITC)','sector_id' => 25,'award_ids' => $w18,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Tenol Alpha','sector_id' => 25,'award_ids' => $w18,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Capacity for Africa','sector_id' => 25,'award_ids' => $w18,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Fontini Consulting','sector_id' => 25,'award_ids' => $w18,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'GTC Group','sector_id' => 25,'award_ids' => $w18,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Compliance Institute Nigeria','sector_id' => 25,'award_ids' => $w18,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'RIMAN','sector_id' => 25,'award_ids' => $w18,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'McTimothy Associates Consulting LLC','sector_id' => 25,'award_ids' => $w18,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Lagos Business School','sector_id' => 25,'award_ids' => $w18,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'DataPro','sector_id' => 25,'award_ids' => $w18,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'AGRC/LGCA','sector_id' => 25,'award_ids' => $w18,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],

            ['name'=> 'E-Four and AAF','sector_id' => 25,'award_ids' => $w19,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'g-Log Consult','sector_id' => 25,'award_ids' => $w19,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Financial Institutions Training Centre (FITC)','sector_id' => 25,'award_ids' => $w19,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Tenol Alpha','sector_id' => 25,'award_ids' => $w19,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Capacity for Africa','sector_id' => 25,'award_ids' => $w19,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Fontini Consulting','sector_id' => 25,'award_ids' => $w19,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'GTC Group','sector_id' => 25,'award_ids' => $w19,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Compliance Institute Nigeria','sector_id' => 25,'award_ids' => $w19,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'RIMAN','sector_id' => 25,'award_ids' => $w19,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'McTimothy Associates Consulting LLC','sector_id' => 25,'award_ids' => $w19,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Lagos Business School','sector_id' => 25,'award_ids' => $w19,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'DataPro','sector_id' => 25,'award_ids' => $w19,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'ACFCS (Nigeria Chapter)','sector_id' => 25,'award_ids' => $w19,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'AGRC/LGCA','sector_id' => 25,'award_ids' => $w19,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],

            ['name'=> 'SentryGRC','sector_id' => 25,'award_ids' => $w20,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Mitiget','sector_id' => 25,'award_ids' => $w20,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Digital Jewel','sector_id' => 25,'award_ids' => $w20,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Rhythex ','sector_id' => 25,'award_ids' => $w20,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Idealab Management Services Limited','sector_id' => 25,'award_ids' => $w20,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'ShuftiPro','sector_id' => 25,'award_ids' => $w21,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Idealab Management Services Limited','sector_id' => 25,'award_ids' => $w21,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Sanction Scanner','sector_id' => 25,'award_ids' => $w21,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'YouVerify','sector_id' => 25,'award_ids' => $w21,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],

            ['name'=> 'KPMG','sector_id' => 25,'award_ids' => $w22,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Deloitte','sector_id' => 25,'award_ids' => $w22,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'PWC','sector_id' => 25,'award_ids' => $w22,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'McKinsey Nigeria','sector_id' => 25,'award_ids' => $w22,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Grant Thorton Nigeria','sector_id' => 25,'award_ids' => $w22,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Ernst & Young Nigeria','sector_id' => 25,'award_ids' => $w22,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],

            ['name'=> 'Phillips Consulting','sector_id' => 25,'award_ids' => $w23,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Kimberly Ryan','sector_id' => 25,'award_ids' => $w23,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Workforce','sector_id' => 25,'award_ids' => $w23,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Jobberman','sector_id' => 25,'award_ids' => $w23,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'Vic Lawrence Associates','sector_id' => 25,'award_ids' => $w23,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],

            ['name'=> 'H.E. Babajide SanwoOlu (Gov. of Lagos State)','sector_id' => 26,'award_ids' => $w24,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'H.E. Seyi Makinde (Gov. of Oyo State)','sector_id' => 26,'award_ids' => $w24,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'H.E. Babagana Zulum (Gov. of Borno State)','sector_id' => 26,'award_ids' => $w24,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'H.E. Aminu Tambuwal (Gov. of Sokoto State)','sector_id' => 26,'award_ids' => $w24,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],
            ['name'=> 'H.E. Ifeanyichukwu Okowa (Gov. of Delta State)','sector_id' => 26,'award_ids' => $w24,'award_program_id' => 2,'created_at' => now(),'updated_at' => now()],

        ];

        foreach($nominees as $nominee){
            DB::table('nominees')->insert($nominee);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('nominees');
    }
}
