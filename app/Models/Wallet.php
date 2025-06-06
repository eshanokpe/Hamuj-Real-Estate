<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    use HasFactory; 

    protected $fillable = [
        'user_id', 
        'user_email', 
        'balance',
        'gbp_balance',
        'usd_balance',
        'currency'
    ];  
 
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function transactions()
    {
        return $this->hasMany(WalletTransaction::class);
    }

    public function getDefaultBalanceAttribute()
    {
        return $this->{$this->currency . '_balance'} ?? 0;
    }

    public function getBalance($currency)
    {
        $currency = strtolower($currency);
        return $this->{"{$currency}_balance"} ?? 0;
    }

    public function setBalance($currency, $amount)
    {
        $currency = strtolower($currency);
        $this->{"{$currency}_balance"} = $amount;
        return $this;
    }

    

}
