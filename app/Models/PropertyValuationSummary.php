<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PropertyValuationSummary extends Model
{
    use HasFactory;  
 
    protected $fillable = [ 
        'id',
        'property_id', 
        'property_valuation_id', 
        'initial_value_sum',
        'current_value_sum',
        'percentage_value',
    ];

    // public function property()
    // {
    //     return $this->belongsTo(Property::class);
    // }

    public function propertyValuation()
    {
        return $this->belongsTo(PropertyValuation::class);
    }

    public function property()
    {
        return $this->belongsTo(Property::class, 'property_id', 'id');
    }
}
