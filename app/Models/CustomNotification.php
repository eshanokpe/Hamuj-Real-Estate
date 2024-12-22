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
        // $property = $this->belongsTo(Property::class, 'property_id');
        $property = $this->hasOne(Property::class, 'id', 'property_id');
        // \Log::info('Property Relationship Query', ['query' => $property->toSql()]);
        
        return $property;

        // $propertyId = $this->data['property_id'] ?? null;

        // if ($propertyId) {
        //     $property = Property::find($propertyId);
        // \Log::info('Property Relationship Query', ['query' => $property->toSql()]);

        //     return $property;
        // }
        // return null;
    }

    // public function property()
    // {
    //     // Fetch the property using the property_id from the notification data (cast to integer)
    //     return Property::where('id', $this->data['property_id'])->first();
    // }
}
