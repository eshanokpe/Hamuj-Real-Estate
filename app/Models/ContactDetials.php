<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactDetials extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_name',
        'first_phone',  
        'second_phone', 
        'first_email', 
        'second_email',
        'first_address',
        'second_address',
        'site_logo',
        'favicon',
    ];
}
