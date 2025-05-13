<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Buy extends Model
{
    use HasFactory;

    protected $fillable = [ 
        'id',
        'user_id',
        'user_email', 
        'property_id',
        'transaction_id',
        'selected_size_land', 
        'remaining_size',
        'total_price',
        'status',
    ];

    public function property()
    {
        return $this->belongsTo(Property::class, 'property_id');
    }

    public function valuationSummary()
    {
        return $this->hasOne(PropertyValuationSummary::class, 'property_id', 'property_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
} 
