<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transfer extends Model
{
    use HasFactory;

    protected $fillable = [
        'property_id',
        'property_name',
        'land_size',
        'user_id',
        'user_email',
        'reference', 
        'recipient_id',
        'total_price',
        'status',
        'confirmation_status',
        'confirmation_date',
        'confirmed_by',
        'rejection_reason'
    ];
    
    public function property()
    {
        return $this->belongsTo(Property::class);
    }

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
 