<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'description',
        'revolut_order_id',
        'revolut_public_id',
        'amount',
        'currency',
        'state'
    ];

    // Optionally cast the amount to integer (since it's stored in cents)
    protected $casts = [
        'amount' => 'integer'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
