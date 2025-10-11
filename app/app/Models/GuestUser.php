<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GuestUser extends Model
{
    use HasFactory;

    protected $primaryKey = 'session_id';
    public $incrementing = false;
    protected $keyType = 'string'; 
    
    protected $fillable = [
        'session_id', 'name', 'email', 'phone'
    ];

    public function conversations()
    {
        return $this->morphMany(Conversation::class, 'user');
    }
}
