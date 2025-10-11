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
            // Add JSON column to store biometric types
            $table->json('biometric_types')->nullable()->after('auth_method');
            
            // If you also need the auth_method column
            if (!Schema::hasColumn('users', 'auth_method')) {
                $table->string('auth_method')
                    ->default('pin')
                    ->after('remember_token');
            }
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
            $table->dropColumn('biometric_types');
            
            // Only drop auth_method if it didn't exist before
            if (Schema::hasColumn('users', 'auth_method') && 
                !Schema::hasColumn('users', 'auth_method_before_migration')) {
                $table->dropColumn('auth_method');
            }
        });
    }
};
