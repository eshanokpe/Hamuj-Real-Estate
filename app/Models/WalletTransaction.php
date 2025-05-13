<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WalletTransaction extends Model
{
    use HasFactory; 

    protected $fillable = [
        'user_id',          
        'wallet_id',       
        'type',            
        'accountName',            
        'bankName',            
        'amount',           
        'reason',     
        'recipient_code', 
        'status',           
        'metadata',         
    ];

    protected $casts = [
        'metadata' => 'array', // Cast metadata to an array
    ];

    public function wallet()
    {
        return $this->belongsTo(Wallet::class);
    }
 
    public function user()
    {
        return $this->belongsTo(User::class);
    }

} 
