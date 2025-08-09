<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model; 

class ReferralLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'referrer_id',
        'referred_id',
        'referral_code',
        'referred_at',
        'status',
        'commission_amount',
        'commission_paid',
        'commission_paid_at',
        'property_id',
        'transaction_id',
    ]; 

    protected $casts = [
        'referred_at' => 'datetime',
        'commission_paid_at' => 'datetime',
        'commission_paid' => 'boolean',
    ];

    // Status constants
    const STATUS_REGISTERED = 'registered';
    const STATUS_PURCHASED = 'purchased';
    const STATUS_PENDING = 'commission_pending';
    const STATUS_PAID = 'paid';
    const STATUS_CANCELLED = 'cancelled';

    public function user()
    {
        return $this->belongsTo(User::class, 'referrer_id');
    }

    public function referrer()
    { 
        return $this->belongsTo(User::class, 'referrer_id');
    }

    
    public function referred()
    {
        return $this->belongsTo(User::class, 'referred_id');
    }

    public function property()
    {
        return $this->belongsTo(Property::class);
    }


    public function transaction()
    {
        return $this->belongsTo(Transaction::class, 'transaction_id', 'reference');
    }
}
 