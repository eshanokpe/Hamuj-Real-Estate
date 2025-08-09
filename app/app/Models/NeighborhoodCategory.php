<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NeighborhoodCategory extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'name',
    ];

    // Relationship to Properties (if needed)
    public function properties()
    {
        return $this->hasMany(Property::class);
    }
}
