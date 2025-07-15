<?php

namespace App\Services;

use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use App\Notifications\TransactionOtpNotification;
use Illuminate\Support\Str;

class OtpService
{
    protected $expirationMinutes = 15;
    protected $maxAttempts = 3;

    public function generateAndSendOtp($user)
    {
        $otp = random_int(100000, 999999);
        $expiresAt = now()->addMinutes($this->expirationMinutes);
        $otpHash = hash('sha256', $otp);

        $this->storeOtp($user, $otpHash, $expiresAt);
        $this->sendOtpToUser($user, $otp);

        return [
            'expires_at' => $this->expirationMinutes * 60,
            'delivery_methods' => $this->getDeliveryMethods($user)
        ];
    }

    protected function storeOtp($user, $otpHash, $expiresAt)
    {
        $identifier = Str::random(32); // OTP session identifier
        
        Cache::put("otp:{$identifier}", [
            'user_id' => $user->id,
            'code_hash' => $otpHash,
            'expires_at' => Carbon::createFromTimestamp($otpData['expires_at'])->toDateTimeString,
            'attempts' => 0,
            'verified' => false
        ], $expiresAt);

        return $identifier;
    }

    protected function sendOtpToUser($user, $otp)
    {
        try {
            $user->notify(new TransactionOtpNotification($otp));
            
            Log::info('OTP sent successfully', [
                'user_id' => $user->id,
                'otp' => $otp,
                'delivery_method' => 'email' // Could be SMS or other methods
            ]);
        } catch (\Exception $e) {
            Log::error('OTP delivery failed', [
                'user_id' => $user->id,
                'error' => $e->getMessage()
            ]);
            throw $e;
        }
    }

    protected function getDeliveryMethods($user)
    {
        $methods = ['email'];
        
        if ($user->phone_verified_at) {
            $methods[] = 'sms';
        }
        
        return $methods;
    }
}