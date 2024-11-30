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
        'city',
        'country',
        'lunch_price', 
        'price',
        'percentage_increase',
        'size',
        'available_size',
        'gazette_number',
        'tenure_free', 
        'property_images',
        'payment_plan',
        'brochure', 
        'land_survey',
        'video_link',
        'google_map',
        'status', 
        'property_state',
        'year',
    ];  

    public function buys()
    {
        return $this->hasMany(Buy::class, 'property_id');
    }
 
    public function transaction(){
        return $this->hasMany(Transaction::class);
    }
    
    public function priceUpdates()
    {
        return $this->hasMany(PropertyPriceUpdate::class);
    }

   
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
 