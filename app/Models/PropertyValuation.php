<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PropertyValuation extends Model
{
    use HasFactory;
    protected $fillable = [
        'property_id',
        'valuation_type',
        'current_price',
        'market_value',
        'percentage_increase',
    ];

    public function property()
    {
        return $this->belongsTo(Property::class);
    }
    
}
 