<?php

namespace App\Models;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Models\Property;

class CustomNotification extends DatabaseNotification
{
    use HasFactory;
  
   

    public function property()
    {
        $property = $this->hasOne(Property::class, 'id', 'property_id');
        
        return $property;

    }
}
