<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Offerprice extends Model
{
    use HasFactory;

    protected $fillable =[
        'property_id',
        'buy_id',
        'amount',
    ];
} 
