<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Module extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id',
        'title',
        'slug',
        'description',
        'order',
        'is_published',
        'duration',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($module) {
            $module->slug = Str::slug($module->title);
        });

        static::updating(function ($module) {
            $module->slug = Str::slug($module->title);
        });
    }

    /**
     * Get the course that owns the module
     */
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    /**
     * Get the lessons for the module
     */
    public function lessons()
    {
        return $this->hasMany(Lesson::class)->orderBy('order');
    }

    /**
     * Get the number of lessons in this module
     */
    public function getLessonsCountAttribute()
    {
        return $this->lessons()->count();
    }

    /**
     * Get the total duration of all lessons
     */
    public function getTotalDurationAttribute()
    {
        return $this->lessons()->sum('duration_minutes');
    }

    /**
     * Check if module is completed by user
     */
    public function isCompletedByUser($userId)
    {
        $completedLessons = $this->lessons()
            ->whereHas('completions', function($query) use ($userId) {
                $query->where('user_id', $userId);
            })
            ->count();

        return $completedLessons == $this->lessons_count;
    }
}