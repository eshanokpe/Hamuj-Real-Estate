<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaystackAccount extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'bank_name',
        'account_number',
        'account_name',
        'recipient_code',
        'currency',
        'is_default'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
