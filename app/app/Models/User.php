<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    public const ROLE_TUTOR = 'tutor';
    public const ROLE_LEARNER = 'learner';
    
    public const STATUS_PENDING = 'pending';
    public const STATUS_ACTIVE = 'active';
    public const STATUS_SUSPENDED = 'suspended';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'profile_picture',
        'phone',
        'phone_country_code',
        'bio',
        'job_title',
        'company',
        'website',
        'country',
        'city',
        'state',
        'postal_code',
        'address',
        'linkedin_url',
        'twitter_url',
        'facebook_url',
        'instagram_url',
        'github_url',
        'email_notifications',
        'sms_notifications',
        'newsletter_subscription',
        'marketing_emails',
        'account_status',
        'account_type',
        'role',
        'status',
        'last_login_at',
        'enrolled_at',
        'email_verified_at',
        'profile_completed_at',
        'tutor_agreement_accepted_at',
    ]; 

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'tutor_agreement_accepted_at' => 'datetime',
        'last_login_at' => 'datetime',
        'enrolled_at' => 'datetime',
        'profile_completed_at' => 'datetime',
        'password' => 'hashed',
        'email_notifications' => 'boolean',
        'sms_notifications' => 'boolean',
        'newsletter_subscription' => 'boolean',
        'marketing_emails' => 'boolean',
        'deleted_at' => 'datetime',
    ];

    /**
     * Interact with the user's linkedin_url.
     */
    protected function linkedinUrl(): Attribute
    {
        return Attribute::make(
            set: fn (?string $value) => $this->normalizeLinkedinUrl($value),
        );
    }

    /**
     * Normalize LinkedIn URL
     */
    private function normalizeLinkedinUrl(?string $url): ?string
    {
        if (empty($url)) {
            return null;
        }

        // Ensure URL has proper format
        if (!preg_match("~^(?:f|ht)tps?://~i", $url)) {
            $url = "https://" . $url;
        }

        // Parse and validate LinkedIn domain
        $parsedUrl = parse_url($url);
        if (isset($parsedUrl['host']) && 
            (str_contains($parsedUrl['host'], 'linkedin.com') || 
             str_contains($parsedUrl['host'], 'linked.in'))) {
            return $url;
        }

        return null;
    }

    /**
     * Scope a query to only include tutors.
     */
    public function scopeTutors($query)
    {
        return $query->where('role', self::ROLE_TUTOR);
    }

    /**
     * Scope a query to only include learners.
     */
    public function scopeLearners($query)
    {
        return $query->where('role', self::ROLE_LEARNER);
    }

    /**
     * Scope a query to only include active users.
     */
    public function scopeActive($query)
    {
        return $query->where('status', self::STATUS_ACTIVE);
    }

    /**
     * Check if user is a tutor.
     */
    public function isTutor(): bool
    {
        return $this->role === self::ROLE_TUTOR;
    }

    /**
     * Check if user is a learner.
     */
    public function isLearner(): bool
    {
        return $this->role === self::ROLE_LEARNER;
    }

    /**
     * Check if user has accepted tutor agreement.
     */
    public function hasAcceptedTutorAgreement(): bool
    {
        return $this->isTutor() && $this->tutor_agreement_accepted_at !== null;
    }

    /**
     * Mark tutor agreement as accepted.
     */
    public function acceptTutorAgreement(): void
    {
        if ($this->isTutor()) {
            $this->update(['tutor_agreement_accepted_at' => now()]);
        }
    }

    /**
     * Relationship with blogs.
     */
    public function blogs()
    {
        return $this->hasMany(Blog::class);
    }

    /**
     * The courses that the user is enrolled in
     */
    public function courses()
    {
        return $this->belongsToMany(Course::class)
                    ->withPivot('progress', 'completed_modules', 'enrolled_at', 'completed_at')
                    ->withTimestamps();
    }

    /**
     * Get completed courses
     */
    public function completedCourses()
    {
        return $this->belongsToMany(Course::class)
                    ->wherePivot('completed_at', '!=', null)
                    ->withTimestamps();
    }

    public function cartItems()
    {
        return $this->hasMany(Cart::class);
    }

    public function cartCourses()
    {
        return $this->belongsToMany(Course::class, 'carts')
                    ->withPivot('price', 'discount_price', 'created_at')
                    ->withTimestamps();
    }

    /**
     * Get profile picture URL attribute
     */
    public function getProfilePictureUrlAttribute()
    {
        if ($this->profile_picture) {
            return Storage::url($this->profile_picture);
        }
        
        // Generate default avatar
        return 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&background=0A1F44&color=fff&size=200';
    }

    /**
     * Get full phone number attribute
     */
    public function getFullPhoneAttribute()
    {
        if (!$this->phone) {
            return null;
        }
        
        return ($this->phone_country_code ?: '+1') . ' ' . $this->phone;
    }

    /**
     * Get full address attribute
     */
    public function getFullAddressAttribute()
    {
        $parts = [];
        
        if ($this->address) $parts[] = $this->address;
        if ($this->city) $parts[] = $this->city;
        if ($this->state) $parts[] = $this->state;
        if ($this->postal_code) $parts[] = $this->postal_code;
        if ($this->country) $parts[] = $this->country;
        
        return implode(', ', $parts);
    }

    /**
     * Check if profile is complete
     */
    public function getIsProfileCompleteAttribute()
    {
        return !empty($this->name) && 
               !empty($this->email) && 
               !empty($this->phone) && 
               !empty($this->country) && 
               !empty($this->city);
    }

    /**
     * Get profile completion percentage
     */
    public function getProfileCompletionPercentageAttribute()
    {
        $fields = [
            'name' => !empty($this->name),
            'email' => !empty($this->email) && filter_var($this->email, FILTER_VALIDATE_EMAIL),
            'phone' => !empty($this->phone),
            'country' => !empty($this->country),
            'city' => !empty($this->city),
            'bio' => !empty($this->bio),
            'job_title' => !empty($this->job_title),
            'profile_picture' => !empty($this->profile_picture),
        ];
        
        $completed = count(array_filter($fields));
        $total = count($fields);
        
        return round(($completed / $total) * 100);
    }

    /**
     * Get the number of courses in progress
     */
    public function getCoursesInProgressAttribute()
    {
        return $this->courses()
            ->wherePivot('completed_at', null)
            ->wherePivot('progress', '>', 0)
            ->count();
    }

    /**
     * Get the number of courses not started
     */
    public function getCoursesNotStartedAttribute()
    {
        return $this->courses()
            ->wherePivot('completed_at', null)
            ->wherePivot('progress', 0)
            ->count();
    }

    /**
     * Get overall course progress percentage
     */
    public function getOverallProgressAttribute()
    {
        $totalCourses = $this->courses()->count();
        if ($totalCourses === 0) {
            return 0;
        }
        
        $completedCourses = $this->completedCourses()->count();
        return round(($completedCourses / $totalCourses) * 100);
    }

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }

    public function activeEnrollments()
    {
        return $this->enrollments()->where('status', 'active');
    }

    public function completedEnrollments()
    {
        return $this->enrollments()->where('status', 'completed');
    }

    public function enrolledCourses()
    {
        return $this->belongsToMany(Course::class, 'enrollments')
            ->withPivot('status', 'progress', 'completed_modules', 'enrolled_at', 'completed_at')
            ->withTimestamps();
    }

    public function getEnrollment($courseId)
    {
        return $this->enrollments()
            ->where('course_id', $courseId)
            ->first();
    }
}