<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Blog extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'content',
        'image',
        'status',
        'user_id',
        'meta_description',
        'meta_keywords',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(\App\Models\Admin::class, 'user_id');
    }

    public function getExcerptAttribute()
    {
        return Str::limit(strip_tags($this->content), 150);
    }

    public function getImageUrlAttribute()
    {
        if (!$this->image) {
            return asset('images/default-blog.jpg');
        }
        
        // Check if it's already a full URL
        if (Str::startsWith($this->image, ['http://', 'https://'])) {
            return $this->image;
        }
        
        // Check if file exists in storage
        if (Storage::disk('public')->exists($this->image)) {
            return asset('storage/' . $this->image);
        }
        
        return asset('images/default-blog.jpg');
    }

    public function getReadingTimeAttribute()
    {
        $wordCount = str_word_count(strip_tags($this->content));
        $readingTime = ceil($wordCount / 200); // 200 words per minute
        return $readingTime . ' min read';
    }
}