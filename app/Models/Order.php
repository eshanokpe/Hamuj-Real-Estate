<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'description',
        'revolut_order_id',
        'revolut_public_id',
        'amount',
        'currency',
        'state',
        'processed_at'
    ];

    // Optionally cast the amount to integer (since it's stored in cents)
    protected $casts = [
        'amount' => 'integer',
        'processed_at' => 'datetime'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
