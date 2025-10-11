<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Neighborhood extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'property_id',
        'neighborhood_category_id',
        'neighborhood_name',
        'distance',
    ];

    // Define relationships
    public function property()
    {
        return $this->belongsTo(Property::class);
    }

    public function category()
    {
        return $this->belongsTo(NeighborhoodCategory::class, 'neighborhood_category_id');
    }
}
