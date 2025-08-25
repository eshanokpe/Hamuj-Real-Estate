<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AddProperty extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'price',
        'location',
        'caption',
        'media_path',
        'media_type',
        'mime_type'
    ];

    protected $casts = [
        'price' => 'decimal:2'
    ];

    /**
     * Get the full URL for the media file
     */
    public function getMediaUrlAttribute()
    {
        return $this->media_path ? Storage::disk('public')->url($this->media_path) : null;
    }

    /**
     * Scope a query to only include properties with images.
     */
    public function scopeWithImages($query)
    {
        return $query->where('media_type', 'image');
    }

    /**
     * Scope a query to only include properties with videos.
     */
    public function scopeWithVideos($query)
    {
        return $query->where('media_type', 'video');
    }
}