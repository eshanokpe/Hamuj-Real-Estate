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
            $table->string('otp_method')->nullable()->after('remember_token');
            $table->string('otp')->nullable()->after('otp_method');
            $table->timestamp('otp_expires_at')->nullable()->after('otp');
            $table->string('verification_method')->nullable()->after('otp_expires_at');
            $table->string('bvn', 11)->nullable()->after('verification_method');
            $table->string('nin', 11)->nullable()->after('bvn');
            $table->boolean('terms')->default(false)->after('nin');
            $table->timestamp('verified_at')->nullable()->after('terms');
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
                'otp_method',
                'otp',
                'otp_expires_at',
                'verification_method',
                'bvn',
                'nin',
                'terms',
                'verified_at'
            ]);
        });
    }
};
