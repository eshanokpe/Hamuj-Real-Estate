<?php

namespace App\Models;
 
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class Event extends Model
{ 
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'short_description',
        'image', 
        'start_date',
        'end_date',
        'start_time',
        'end_time', 
        'location',
        'address',
        'venue',
        'capacity',
        'available_seats',
        'status',
        'is_featured',
        'meta_description',
        'meta_keywords',
        'user_id',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'price' => 'decimal:2',
        'is_featured' => 'boolean',
        'capacity' => 'integer',
        'available_seats' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(\App\Models\Admin::class, 'user_id');
    }

    public function getExcerptAttribute()
    {
        return Str::limit(strip_tags($this->description), 150);
    }

    public function getImageUrlAttribute()
    {
        if (!$this->image) {
            return asset('images/default-event.jpg');
        }
        
        return asset('storage/' . $this->image);
    }

    public function getEventDateAttribute()
    {
        if ($this->start_date->eq($this->end_date)) {
            return $this->start_date->format('M d, Y');
        }
        
        return $this->start_date->format('M d') . ' - ' . $this->end_date->format('M d, Y');
    }

    public function getEventTimeAttribute()
    {
        return $this->start_time . ' - ' . $this->end_time;
    }

    public function getStatusBadgeAttribute()
    {
        $statuses = [
            'published' => ['class' => 'bg-success', 'text' => 'Published'],
            'draft' => ['class' => 'bg-warning', 'text' => 'Draft'],
            'cancelled' => ['class' => 'bg-danger', 'text' => 'Cancelled']
        ];

        $status = $statuses[$this->status] ?? $statuses['draft'];
        
        return '<span class="badge ' . $status['class'] . '">' . $status['text'] . '</span>';
    }

    public function getIsUpcomingAttribute()
    {
        return $this->start_date->gt(Carbon::now());
    }

    public function getIsOngoingAttribute()
    {
        $now = Carbon::now();
        return $this->start_date->lte($now) && $this->end_date->gte($now);
    }

    public function getIsPastAttribute()
    {
        return $this->end_date->lt(Carbon::now());
    }

    public function getRegistrationStatusAttribute()
    {
        if ($this->available_seats <= 0) {
            return 'sold_out';
        } elseif ($this->available_seats < 10) {
            return 'few_seats';
        } else {
            return 'available';
        }
    }
}