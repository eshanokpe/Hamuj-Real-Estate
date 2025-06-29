<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KycDetail extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'full_name',
        'date_of_birth',
        'gender',
        'phone_number',
        'bvn',
        'bank_account_name',
        'bank_account_number',
        'id_type',
        'id_number',
        'id_image_path',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
