<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory; 

    protected $fillable = ['conversation_id', 'user_id', 'user_type', 'content','read'];

    public function conversation()
    {
        return $this->belongsTo(Conversation::class);
    }

    public function user()
    {
        if ($this->user_type === 'registered') {
            return $this->belongsTo(User::class, 'user_id');
        }
        
        // Return a generic relation for guest users
        return $this->belongsTo(User::class, 'user_id')->withDefault([
            'name' => 'Guest User',
            'email' => null,
            'phone' => null
        ]);
    }
}
