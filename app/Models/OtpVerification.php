<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OtpVerification extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'otp',
        'email_otp',
        'phone_otp',
        'email_otp_expires_at',
        'phone_otp_expires_at',
        'email_verified',
        'phone_verified'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
} 
