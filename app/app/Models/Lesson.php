<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Lesson extends Model
{
    use HasFactory;

    protected $fillable = [
        'module_id',
        'title',
        'slug',
        'content',
        'video_url',
        'video_type',
        'duration',
        'duration_minutes',
        'order',
        'is_published',
        'is_free_preview',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($lesson) {
            $lesson->slug = Str::slug($lesson->title);
        });

        static::updating(function ($lesson) {
            $lesson->slug = Str::slug($lesson->title);
        });
    }

    /**
     * Get the module that owns the lesson
     */
    public function module()
    {
        return $this->belongsTo(Module::class);
    }

    /**
     * Get the course through module
     */
    public function course()
    {
        return $this->module->course();
    }

    /**
     * Get lesson completions
     */
    public function completions()
    {
        return $this->hasMany(LessonCompletion::class);
    }

    /**
     * Check if lesson is completed by user
     */
    public function isCompletedByUser($userId)
    {
        return $this->completions()->where('user_id', $userId)->exists();
    }
}