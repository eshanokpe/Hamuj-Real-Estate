<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionUpdateLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaction_id',
        'previous_amount',
        'new_amount',
        'price_ratio',
    ];

    protected $casts = [
        'previous_amount' => 'decimal:2',
        'new_amount' => 'decimal:2',
        'price_ratio' => 'decimal:4',
    ];

    /**
     * Get the transaction that owns the log entry.
     */
    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }
}