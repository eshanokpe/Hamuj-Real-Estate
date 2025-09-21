<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage; // Added for Storage usage

class AddProperty extends Model
{
    use HasFactory;

    protected $table = 'add_properties';

    protected $fillable = [
        'title',
        'user_id',
        'description',
        'price',
        'location',
        'caption',
        'media_path',
        'media_type',
        'mime_type',
        'is_favorite',
        'favorite_count',
        'property_type_id', 
        'property_subtitle',  
    ];

    protected $casts = [
        'price' => 'decimal:2', 
        'price' => 'decimal:2',
        'is_favorite' => 'boolean', 
    ];

   
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Correct return type with proper import
    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class, 'property_id');
    }

    public function media()
    {
        return $this->hasMany(PostPropertyMedia::class, 'property_id'); // Specify foreign key
    }
    

    public function propertyType()
    {
        return $this->belongsTo(PropertyType::class, 'property_type_id');
    }

    public function property()
    {
        return $this->belongsTo(AddProperty::class);
    }
    
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
