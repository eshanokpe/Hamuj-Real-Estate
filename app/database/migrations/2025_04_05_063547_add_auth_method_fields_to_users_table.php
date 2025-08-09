<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->json('biometric_data')
                  ->nullable()
                  ->comment('Stores supported biometric types as JSON');
            
            $table->timestamp('biometric_enabled_at')
                  ->nullable()
                  ->comment('When biometric was enabled');
        }); 
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'biometric_data', 
                'biometric_enabled_at'
            ]);
        });
    }
};
