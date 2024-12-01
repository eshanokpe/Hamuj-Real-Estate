<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PropertyPriceUpdate extends Model
{
    use HasFactory;

    protected $fillable = [
        'property_id',
        'previous_price',
        'previous_percentage_increase',
        'previous_year',
        'updated_price', 
        'percentage_increase',
        'updated_year',
    ];

    public function property()
    {
        return $this->belongsTo(Property::class);
    }
}
