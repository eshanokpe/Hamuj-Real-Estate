<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PropertyType extends Model
{
    use HasFactory;
    protected $table = 'property_types'; 

    protected $fillable = ['title', 'subtitles'];

    protected $casts = [
        'subtitles' => 'array',
    ];

    public function properties()
    {
        return $this->hasMany(AddProperty::class, 'property_type_id');
    }
}