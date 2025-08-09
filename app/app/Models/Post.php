<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Post extends Model
{
    use HasFactory;
 
    protected $fillable = [
        'id',
        'title',
        'slug',
        'content',
        'image',
    ];

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->slug = Str::slug($model->title); 
        });

        static::updating(function ($model) {
            $model->slug = Str::slug($model->title); 
        });
    }
}
