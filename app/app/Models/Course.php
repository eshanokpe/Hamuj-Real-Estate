<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'short_title',
        'description',
        'short_description',
        'image', 
        'video', // Add this
        'video_type', // Add this (upload, youtube, vimeo)
        'video_url', // Add this for embedded videos
        'delivery_method',
        'category',
        'level',
        'format',
        'duration',
        'modules_count',
        'completed_modules',
        'price',
        'discount_price',
        'status',
        'course_user',
        'is_featured',
        'is_popular',
        'meta_description',
        'meta_keywords',
        'learning_outcomes',
        'prerequisites',
        'target_audience',
        'certification',
        'user_id',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'discount_price' => 'decimal:2',
        'modules_count' => 'integer',
        'completed_modules' => 'integer',
        'is_featured' => 'boolean',
        'is_popular' => 'boolean',
    ];

   
     /**
     * Get the users enrolled in this course
     */
    public function users()
    {
        return $this->belongsToMany(User::class)
                    ->withPivot('progress', 'completed_modules', 'enrolled_at', 'completed_at')
                    ->withTimestamps();
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function modules()
    {
        return $this->hasMany(Module::class)->orderBy('order');
    }

    public function lessons()
    {
        return $this->hasManyThrough(Lesson::class, Module::class);
    }

    public function getModulesCountAttribute()
    {
        return $this->modules()->count();
    }

    public function getExcerptAttribute()
    {
        return Str::limit(strip_tags($this->description), 150);
    }

    public function getImageUrlAttribute()
    {
        if (!$this->image) {
            return asset('assets/images/home-three/service/service-img1.png');
        }
        
        if (filter_var($this->image, FILTER_VALIDATE_URL)) {
            return $this->image;
        }
        
        return asset('storage/' . $this->image);
    }

    public function getProgressPercentageAttribute()
    {
        if ($this->modules_count == 0) return 0;
        return round(($this->completed_modules / $this->modules_count) * 100);
    }
 
    public function getCurrentPriceAttribute()
    {
        return $this->discount_price > 0 ? $this->discount_price : $this->price;
    }

    public function getHasDiscountAttribute()
    {
        return $this->discount_price > 0 && $this->discount_price < $this->price;
    }

    public function getDiscountPercentageAttribute()
    {
        if (!$this->has_discount) {
            return 0;
        }
        return round((($this->price - $this->discount_price) / $this->price) * 100);
    }

    public function getStatusBadgeAttribute()
    {
        $statuses = [
            'published' => ['class' => 'bg-success', 'text' => 'Published'],
            'draft' => ['class' => 'bg-warning', 'text' => 'Draft'],
            'archived' => ['class' => 'bg-secondary', 'text' => 'Archived']
        ];

        $status = $statuses[$this->status] ?? $statuses['draft'];
        
        return '<span class="badge ' . $status['class'] . '">' . $status['text'] . '</span>';
    }

    public function getLevelBadgeAttribute()
    {
        $levels = [
            'beginner' => ['class' => 'bg-primary', 'text' => 'Beginner'],
            'intermediate' => ['class' => 'bg-info', 'text' => 'Intermediate'],
            'advanced' => ['class' => 'bg-warning', 'text' => 'Advanced'],
            'expert' => ['class' => 'bg-danger', 'text' => 'Expert']
        ];

        $level = $levels[$this->level] ?? $levels['beginner'];
        
        return '<span class="badge ' . $level['class'] . '">' . $level['text'] . '</span>';
    }

    public function getFormatBadgeAttribute()
    {
        $formats = [
            'self_paced' => ['class' => 'bg-info', 'text' => 'Self-Paced'],
            'instructor_led' => ['class' => 'bg-success', 'text' => 'Instructor-Led'],
            'hybrid' => ['class' => 'bg-warning', 'text' => 'Hybrid']
        ];

        $format = $formats[$this->format] ?? $formats['self_paced'];
        
        return '<span class="badge ' . $format['class'] . '">' . $format['text'] . '</span>';
    }

    public function getVideoUrlAttribute()
    {
        if ($this->video_type === 'upload' && $this->video) {
            return asset('storage/' . $this->video);
        } elseif ($this->video_type === 'youtube' && $this->video_url) {
            return $this->video_url;
        } elseif ($this->video_type === 'vimeo' && $this->video_url) {
            return $this->video_url;
        }
        return null;
    }

    public function getVideoEmbedCodeAttribute()
    {
        if ($this->video_type === 'youtube' && $this->video_url) {
            // Extract YouTube video ID from URL
            preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/', $this->video_url, $matches);
            if (isset($matches[1])) {
                return 'https://www.youtube.com/embed/' . $matches[1];
            }
        } elseif ($this->video_type === 'vimeo' && $this->video_url) {
            // Extract Vimeo video ID from URL
            preg_match('/vimeo.com\/(?:video\/)?(\d+)/', $this->video_url, $matches);
            if (isset($matches[1])) {
                return 'https://player.vimeo.com/video/' . $matches[1];
            }
        }
        return null;
    }

    public function reviews()
    {
        return $this->hasMany(CourseReview::class);
    }

    public function averageRating()
    {
        return $this->reviews()->avg('rating');
    }

    public function reviewsCount()
    {
        return $this->reviews()->count();
    }

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }

    public function activeEnrollments()
    {
        return $this->enrollments()->where('status', 'active');
    }

    public function getEnrollmentsCountAttribute()
    {
        return $this->enrollments()->count();
    }

    public function getActiveEnrollmentsCountAttribute()
    {
        return $this->activeEnrollments()->count();
    }

    public function isEnrolledByUser($userId)
    {
        return $this->enrollments()
            ->where('user_id', $userId)
            ->where('status', 'active')
            ->exists();
    }

    public function getUserEnrollment($userId)
    {
        return $this->enrollments()
            ->where('user_id', $userId)
            ->first();
    }

    public function instructor()
    {
        // If you have an instructor_id column, use that
        return $this->belongsTo(User::class, 'instructor_id');
        
        // Otherwise, use the user_id as instructor
        // return $this->belongsTo(User::class, 'user_id');
    }

}