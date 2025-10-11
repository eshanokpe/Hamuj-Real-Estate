<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'id', 
        'transaction_type',
        'type',
        'source',
        'metadata',
        'user_id', 
        'email',  
        'reference',
        'status',
        'amount',
        'balance_before', // NEW
        'balance_after', // NEW
        'property_id',
        'property_name',
        'payment_method',
        'description',
        'transaction_state',
        'paid_at',
        'recipient_name',
        'recipient_code',
        'account_number',
        'account_name',
        'bank_name',
        'reversal_reason', // NEW
        'reversed_by', // NEW
        'reversed_transaction_id', // NEW
        'reversed_at', // NEW
    ]; 

    protected $casts = [
        'metadata' => 'array',
        'balance_before' => 'decimal:2',
        'balance_after' => 'decimal:2',
        'amount' => 'decimal:2',
        'reversed_at' => 'datetime',
        'paid_at' => 'datetime',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function property()
    {
        return $this->belongsTo(Property::class); 
    }

    public function reversedTransaction()
    {
        return $this->belongsTo(Transaction::class, 'reversed_transaction_id');
    }

    /**
     * Scope for reversal transactions
     */
    public function scopeReversals($query)
    {
        return $query->where('type', 'reversal');
    }

    /**
     * Scope for payment transactions
     */
    public function scopePayments($query)
    {
        return $query->where('type', 'payment');
    }

    /**
     * Check if transaction is a reversal
     */
    public function isReversal()
    {
        return $this->type === 'reversal';
    }

    /**
     * Check if transaction has been reversed
     */
    public function isReversed()
    {
        return !is_null($this->reversed_at);
    }
}
