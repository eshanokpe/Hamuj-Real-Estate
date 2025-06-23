<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Beneficiary extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'account_name',
        'account_number',
        'bank_code',
        'bank_name',
        'recipient_code'
    ];

    /**
     * Get the user that owns the beneficiary.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope a query to only include beneficiaries for a given user.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  mixed  $userId
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Get the display name for the beneficiary.
     *
     * @return string
     */
    public function getDisplayNameAttribute()
    {
        return "{$this->account_name} - {$this->account_number} ({$this->bank_name})";
    }

    /**
     * Check if this beneficiary matches given account details.
     *
     * @param string $accountNumber
     * @param string $bankCode
     * @return bool
     */
    public function matches($accountNumber, $bankCode)
    {
        return $this->account_number === $accountNumber 
            && $this->bank_code === $bankCode;
    }
}