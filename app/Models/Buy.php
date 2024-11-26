<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Buy extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'user_email',
        'property_id',
        'transaction_id',
        'selected_size_land',
        'remaining_size',
        'total_price',
        'status',
    ];
}
