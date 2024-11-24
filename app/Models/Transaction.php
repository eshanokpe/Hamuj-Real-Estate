<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'email', 
        'reference',
        'status',
        'amount',
        'property_id',
        'property_name',
        'payment_method',
        'transaction_state',
        'paid_at',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function property()
    {
        return $this->belongsTo(Property::class); 
    }
}
