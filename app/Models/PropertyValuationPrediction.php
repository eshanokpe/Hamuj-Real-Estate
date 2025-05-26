<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PropertyValuationPrediction extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'property_id',
        'future_date',
        'current_price',
        'future_market_value', 
        'percentage_increase',
    ];

    public function property()
    {
        return $this->belongsTo(Property::class);
    }
}
