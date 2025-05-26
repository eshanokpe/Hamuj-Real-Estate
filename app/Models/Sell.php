<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sell extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'property_id',
        'property_name',
        'selected_size_land',
        'remaining_size',
        'user_id',
        'user_email',
        'reference',
        'total_price',
        'status',
    ];
    
    public function property()
    {
        return $this->belongsTo(Property::class);
    }

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function valuationSummary()
    {
        return $this->hasOne(PropertyValuationSummary::class, 'property_id', 'property_id');
    }
}
