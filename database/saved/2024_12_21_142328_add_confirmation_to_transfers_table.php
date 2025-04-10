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
        Schema::table('transfers', function (Blueprint $table) {
            $table->enum('recipient_confirmation', ['pending', 'confirmed', 'declined'])->default('pending')->after('status');
            $table->timestamp('confirmed_at')->nullable()->after('recipient_confirmation'); // Optional field to track the exact confirmation time
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('transfers', function (Blueprint $table) {
            $table->dropColumn(['recipient_confirmation', 'confirmed_at']);
        });
    }
};
