<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable
{
    use HasFactory, Notifiable;
    

    protected $fillable = [
        'name', 'email', 'password', 'phone', 'last_login', 'login_ip', 'otp'
    ];

    public function notifications()
    {
        return $this->morphMany(CustomNotification::class, 'notifiable')->orderBy('created_at', 'desc');
    }
}
