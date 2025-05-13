<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    use HasFactory; 

    protected $fillable = [
        'user_id', 'user_email', 'balance','currency'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    
    
    public function transactions()
    {
        return $this->hasMany(WalletTransaction::class);
    }


}
