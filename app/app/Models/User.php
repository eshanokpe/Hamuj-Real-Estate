<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{ 
    use HasApiTokens, HasFactory, Notifiable, HasRoles;
   
    public const AUTH_METHOD_PIN = 'pin';
    public const AUTH_METHOD_BIOMETRIC = 'biometric';
    public const AUTH_METHOD_BOTH = 'both';
    
    public const BIOMETRIC_FACE = 'face';
    public const BIOMETRIC_FINGERPRINT = 'fingerprint';
    public const BIOMETRIC_IRIS = 'iris';

    protected $fillable = [
        'first_name', 
        'last_name', 
        'email',
        'deactivation_reason',
        'deactivated_at',
        'password',
        'phone', 
        'dob',
        'recipient_id',
        'profile_image', 
        'referral_code', 
        'referred_by',
        'transaction_pin',
        'commission_balance',
        'hide_balance',
        'app_passcode', 
        'active', 
        'is_active',
        'registration_source',
        'biometric_types',
        'otp_verified_at',
        'otp_method',
        'otp',
        'otp_expires_at',
        'verification_method',
        'bvn',
        'bvn_verified_at',
        'nin',
        'nin_verified_at',
        'terms',
        'verified_at',
        'transaction_pin_updated_at',
        'bvn','nin'
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'app_passcode',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'transaction_pin_updated_at' => 'datetime',
        'hide_balance' => 'boolean',
        'last_login_at' => 'datetime',
        'dob' => 'date',
        'is_admin' => 'boolean',
        'is_active' => 'boolean',
        'otp_verified_at' => 'datetime',
        'biometric_data' => 'array',
        'bvn_verified_at' => 'datetime',
        'nin_verified_at' => 'datetime'
    ];

    public function isOnline()
    {
        return Cache::has('user-is-online-' . $this->id);
    }

    public function scopeAdmins($query)
    {
        return $query->where('is_admin', true)->where('is_active', true);
    }

    public function isAdministrator(): bool
    {
        return $this->is_admin && $this->is_active;
    }
 
    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }


    public function virtualAccounts()
    {
        return $this->hasMany(VirtualAccount::class);
    } 

    public function postProperty()
    {
        return $this->hasMany(AddProperty::class);
    } 

    public function wallet()
    {
        return $this->hasOne(Wallet::class);
    }
    public function referrals()
    {
        return $this->hasMany(ReferralLog::class);
    }
    public function notifications()
    {
        return $this->morphMany(CustomNotification::class, 'notifiable')->orderBy('created_at', 'desc');
    }
    public function referralsMade()
    {
        return $this->hasMany(ReferralLog::class, 'referrer_id');
    }
    public function referralsReceived()
    {
        return $this->hasMany(ReferralLog::class, 'id');
    }
    
    public function walletTransactions()
    {
        return $this->hasMany(WalletTransaction::class);
    }

    public function successfulReferrals()
    {
        return $this->referrals()
            ->where('status', ReferralLog::STATUS_PAID);
    }

    public function pendingReferrals()
    {
        return $this->referrals()
            ->where('status', ReferralLog::STATUS_PENDING);
    }

    public function totalCommissionEarned()
    {
        return $this->referrals()
            ->where('commission_paid', true)
            ->sum('commission_amount');
    }

    public function potentialCommission()
    {
        return $this->referrals()
            ->where('status', ReferralLog::STATUS_PENDING)
            ->sum('commission_amount');
    }

    protected function fullName(): Attribute
    {
        return Attribute::make(
            get: fn () => trim($this->first_name . ' ' . $this->last_name),
        );
    } 

    protected function authMethod(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value ?? self::AUTH_METHOD_PIN,
            set: fn ($value) => in_array($value, [
                self::AUTH_METHOD_PIN, 
                self::AUTH_METHOD_BIOMETRIC,
                self::AUTH_METHOD_BOTH
            ]) ? $value : self::AUTH_METHOD_PIN
        );
    }

    public function requiresPinAuth(): bool
    {
        return $this->auth_method === self::AUTH_METHOD_PIN || 
              ($this->auth_method === self::AUTH_METHOD_BOTH && empty($this->app_passcode));
    }

    public function requiresBiometricAuth(): bool
    {
        return $this->hasBiometricEnabled() && 
               ($this->auth_method === self::AUTH_METHOD_BIOMETRIC || 
                $this->auth_method === self::AUTH_METHOD_BOTH);
    }

    public function hasBiometricEnabled(): bool
    {
        return !empty($this->biometric_enabled_at) && 
               !empty($this->biometric_data);
    }
 
    public function canUseBiometric(): bool
    {
        return $this->hasBiometricEnabled() && 
               in_array($this->auth_method, [
                   self::AUTH_METHOD_BIOMETRIC,
                   self::AUTH_METHOD_BOTH
               ]);
    }

    public function supportedBiometricTypes(): array
    {
        if (empty($this->biometric_data)) {
            return [];
        }

        // If it's already an array, return it
        if (is_array($this->biometric_data)) {
            return $this->biometric_data;
        }

        // If it's a string (e.g., "fingerprint,face"), split into an array
        return explode(',', $this->biometric_data);
    }

    public function enableBiometric(array $biometricTypes): bool
    {
        if (empty($this->app_passcode)) {
            return false;
        }

        $this->biometric_data = json_encode(array_intersect($biometricTypes, [
            self::BIOMETRIC_FACE,
            self::BIOMETRIC_FINGERPRINT,
            self::BIOMETRIC_IRIS
        ]));

        $this->biometric_enabled_at = now();
        return $this->save();
    }

    public function disableBiometric(): bool
    {
        $this->biometric_data = null;
        $this->biometric_enabled_at = null;
        
        // If biometric was the only method, revert to PIN
        if ($this->auth_method === self::AUTH_METHOD_BIOMETRIC) {
            $this->auth_method = self::AUTH_METHOD_PIN;
        }
        
        return $this->save();
    }

    public function securitySettings(): array
    {
        return [
            'auth_method' => $this->auth_method,
            'has_passcode' => !empty($this->app_passcode),
            'biometric_available' => $this->canUseBiometric(),
            'biometric_types' => $this->supportedBiometricTypes(),
            'biometric_enabled' => $this->hasBiometricEnabled(),
        ];
    }

    public function paystackAccounts()
    {
        return $this->hasMany(PaystackAccount::class);
    }

    public function defaultPaystackAccount()
    {
        return $this->hasOne(PaystackAccount::class)->where('is_default', true);
    }

    public function transactions()
    { 
        return $this->hasMany(Transaction::class);
    }

    // Methods to check verification status
    public function hasVerifiedEmail()
    { 
        // return !is_null($this->email_verified_at);
        return !is_null($this->otp_verified_at);
    }

    public function hasVerifiedPhone()
    {
        return !is_null($this->phone_verified_at);
    }

    public function isFullyVerified()
    {
        return $this->hasVerifiedEmail() && $this->hasVerifiedPhone();
    }

    // Route notifications for the SMS channel
    public function routeNotificationForSms()
    {
        return $this->phone; 
    }

    public function hasVerifiedOtp()
    {
        return !is_null($this->otp_verified_at);
    }
}
 