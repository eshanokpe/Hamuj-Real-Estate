<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transfer extends Model
{
    use HasFactory; 

    protected $fillable = [
        'id',
        'property_id',
        'buy_id',
        'property_name',
        'land_size',
        'user_id',
        'user_email',
        'reference', 
        'recipient_id',
        'total_price',
        'purchase_date',
        'roi_percentage',
        'total_roi',
        'monthly_roi',
        'roi_due_date',
        'is_matured',
        'months_elapsed',
        'days_into_month',
        'status',
        'confirmation_status',
        'confirmation_date',
        'confirmed_by',
        'rejection_reason'
    ];

    protected $casts = [
        'purchase_date' => 'datetime',
        'roi_due_date' => 'datetime',
        'is_matured' => 'boolean',
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
 
