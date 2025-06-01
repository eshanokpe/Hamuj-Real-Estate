<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Buy extends Model
{
    use HasFactory;
 
    protected $fillable = [ 
        'id',
        'user_id',
        'user_email', 
        'property_id',
        'transaction_id',
        'selected_size_land', 
        'remaining_size',
        'total_price',
        'use_referral',      
        'referral_amount', 
        'final_amount',
        'status',
    ];

    public function property()
    {
        return $this->belongsTo(Property::class, 'property_id');
    }

    public function valuationSummary()
    {
        return $this->hasOne(PropertyValuationSummary::class, 'property_id', 'property_id');
    }

    // Calculate final amount before saving
    public static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            $model->final_amount = $model->use_referral
                ? max(0, $model->total_price - $model->referral_amount)
                : $model->total_price;
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
