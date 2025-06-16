<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    use HasFactory; 

    protected $fillable = ['user_id', 'user_type', 'admin_id', 'subject', 'is_open'];

    public function messages()
    { 
        return $this->hasMany(Message::class);
    }

    // Relationship to the user (polymorphic)
    public function user() 
    {
        if ($this->user_type === 'registered') {
            return $this->belongsTo(User::class, 'user_id');
        }
        
        if ($this->user_type === 'guest') {
            return $this->belongsTo(GuestUser::class, 'user_id', 'session_id');
        }
        return $this->morphTo();
    }

    // Relationship to admin (regular User model)
    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }
}
