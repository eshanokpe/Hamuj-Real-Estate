<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enrollment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'course_id',
        'status',
        'progress',
        'completed_modules',
        'completed_lessons',
        'enrolled_at',
        'completed_at',
    ];

    protected $casts = [
        'enrolled_at' => 'datetime',
        'completed_at' => 'datetime',
        'progress' => 'integer',
        'completed_modules' => 'integer',
        'completed_lessons' => 'integer',
    ];

    /**
     * Get the user that owns the enrollment
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the course that owns the enrollment
     */
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    /**
     * Scope for active enrollments
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope for completed enrollments
     */
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    /**
     * Mark enrollment as completed
     */
    public function markAsCompleted()
    {
        $this->update([
            'status' => 'completed',
            'progress' => 100,
            'completed_at' => now(),
        ]);
    }

    /**
     * Update progress
     */
    public function updateProgress($completedModules, $totalModules)
    {
        $progress = $totalModules > 0 ? round(($completedModules / $totalModules) * 100) : 0;
        
        $this->update([
            'progress' => $progress,
            'completed_modules' => $completedModules,
        ]);

        // Auto-complete if progress is 100%
        if ($progress >= 100 && $this->status !== 'completed') {
            $this->markAsCompleted();
        }
    }
}