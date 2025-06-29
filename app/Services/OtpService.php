<?php 
// app/Services/OtpService.php
namespace App\Services;

use App\Models\OtpVerification;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;

class OtpService
{
    public function generateOtp(User $user)
    {
        // Generate OTPs (6 digits)
        $otp = mt_rand(100000, 999999);
        $emailOtp = mt_rand(100000, 999999);
        $phoneOtp = mt_rand(100000, 999999);

        // Expiry time (15 minutes from now)
        $expiry = Carbon::now()->addMinutes(15);

        // Create or update OTP record
        OtpVerification::updateOrCreate(
            ['user_id' => $user->id],
            [
                'otp' => $otp,
                'email_otp' => $emailOtp,
                'phone_otp' => $phoneOtp,
                'email_otp_expires_at' => $expiry,
                'phone_otp_expires_at' => $expiry,
                'email_verified' => false,
                'phone_verified' => false
            ]
        );

        return [
            'otp' => $otp,
            'email_otp' => $emailOtp,
            'phone_otp' => $phoneOtp,
            'expires_at' => $expiry
        ];
    }

    public function verifyOtp(User $user, string $otp, string $type = 'email')
    {
        $otpRecord = OtpVerification::where('user_id', $user->id)->first();

        if (!$otpRecord) {
            return false;
        }

        $field = $type . '_otp';
        $expiryField = $type . '_otp_expires_at';
        $verifiedField = $type . '_verified';

        if ($otpRecord->$field !== $otp) {
            return false;
        }

        if (Carbon::now()->gt($otpRecord->$expiryField)) {
            return false;
        }

        $otpRecord->update([$verifiedField => true]);
        return true;
    }

    public function isVerified(User $user)
    {
        $otpRecord = OtpVerification::where('user_id', $user->id)->first();
        
        return $otpRecord && $otpRecord->email_verified && $otpRecord->phone_verified;
    }
}