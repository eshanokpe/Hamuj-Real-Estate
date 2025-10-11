<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // First, check if columns exist before adding them
        Schema::table('transactions', function (Blueprint $table) {
            // Check and add 'type' column if it doesn't exist
            if (!Schema::hasColumn('transactions', 'type')) {
                $table->string('type', 50)->nullable()->after('transaction_type');
                $table->string('reversed_by', 50)->nullable()->after('reversed_by');
            }
             if (!Schema::hasColumn('transactions', 'reversed_by')) {
                $table->string('reversed_by', 50)->nullable()->after('type');
            }
            
            // Check and add 'balance_before' column if it doesn't exist
            if (!Schema::hasColumn('transactions', 'balance_before')) {
                $table->decimal('balance_before', 15, 2)->nullable()->after('amount');
            }
            
            // Check and add 'balance_after' column if it doesn't exist
            if (!Schema::hasColumn('transactions', 'balance_after')) {
                $table->decimal('balance_after', 15, 2)->nullable()->after('balance_before');
            }
            
            // Check and add 'reversal_reason' column if it doesn't exist
            if (!Schema::hasColumn('transactions', 'reversal_reason')) {
                $table->text('reversal_reason')->nullable()->after('balance_after');
            }
        });

        // Add indexes separately after ensuring columns exist
        Schema::table('transactions', function (Blueprint $table) {
            // Check if index exists before adding
            $indexes = collect(DB::select('SHOW INDEX FROM transactions'))->pluck('Key_name');
            
            if (!$indexes->contains('transactions_type_index')) {
                $table->index(['type'], 'transactions_type_index');
            }
            
            if (!$indexes->contains('transactions_reference_index')) {
                $table->index(['reference'], 'transactions_reference_index');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            // Drop indexes if they exist
            $indexes = collect(DB::select('SHOW INDEX FROM transactions'))->pluck('Key_name');
            
            if ($indexes->contains('transactions_type_index')) {
                $table->dropIndex('transactions_type_index');
            }
            
            if ($indexes->contains('transactions_reference_index')) {
                $table->dropIndex('transactions_reference_index');
            }
            
            // Drop columns if they exist
            if (Schema::hasColumn('transactions', 'type')) {
                $table->dropColumn('type');
            }
            
            if (Schema::hasColumn('transactions', 'balance_before')) {
                $table->dropColumn('balance_before');
            }
            
            if (Schema::hasColumn('transactions', 'balance_after')) {
                $table->dropColumn('balance_after');
            }
            
            if (Schema::hasColumn('transactions', 'reversal_reason')) {
                $table->dropColumn('reversal_reason');
            }
        });
    }
};