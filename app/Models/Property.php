<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Property extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'location',
        'lunch_price',
        'price',
        'price_increase',
        'size',
        'gazette_number',
        'tenure_free',
        'property_images',
        'payment_plan',
        'brochure',
        'land_survey',
        'video_link',
        'status',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->slug = Str::slug($model->name); 
        });
 
        static::updating(function ($model) {
            $model->slug = Str::slug($model->name); 
        });
    }
}
 