<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VirtualAccount extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'user_id',
        'user_email',
        'bank_name', 
        'account_name',
        'account_number',
        'currency',
        'customer_code',
        'is_active',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
