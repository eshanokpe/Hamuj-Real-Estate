<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostPropertyMedia extends Model
{
    use HasFactory;

     protected $fillable = [
        'property_id',
        'media_path',
        'media_type',
        'mime_type',
    ];

    /**
     * Get the property that owns the media.
     */
    public function property()
    {
        return $this->belongsTo(AddProperty::class);
    }
}
