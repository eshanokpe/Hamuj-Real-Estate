<?php

namespace App\Services;

use App\Http\Controllers\WalletController;
use App\Models\User;
use App\Models\ReferralLog;
use App\Models\VirtualAccount;
use App\Mail\VerificationEmail;
use App\Notifications\NewReferralSignupNotification;
use App\Notifications\ReferralConnectionNotification;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;

class AuthService
{
    public function register(array $data, WalletController $walletController)
    {
        $recipientId = $this->createRecipientId();
        $referrer = null;

        if (!empty($data['referral_code'])) {
            $referrer = User::where('referral_code', $data['referral_code'])->first();
            if (!$referrer) {
                throw ValidationException::withMessages([
                    'referral_code' => ['Invalid referral code.'],
                ]);
            }
        }

        $user = User::create([
            'first_name' => $data['firstname'] ?? null,
            'last_name' => $data['lastname'] ?? null,
            'email' => $data['email'] ?? null,
            'phone' => $data['phone'] ?? null,
            'recipient_id' => $recipientId,
            'password' => isset($data['password']) ? Hash::make($data['password']) : null,
            'profile_image' => null,
            'referral_code' => $this->generateReferralCode(),
            'referred_by' => $referrer ? $referrer->id : null,
            'otp_verified_at' => null,
            'otp_method' => $data['otp_method'] ?? null,
            'otp' => $data['otp'] ?? null,
            'otp_expires_at' => $data['otp_expires_at'] ?? null,
            'verification_method' => $data['verification_method'] ?? null,
            'bvn' => $data['bvn'] ?? null,
            'nin' => $data['nin'] ?? null,
            'terms' => isset($data['terms']),
            'verified_at' => null,
        ]);

        if ($referrer) {
            ReferralLog::create([
                'referrer_id' => $referrer->id,
                'referred_id' => $user->id,
                'referral_code' => $data['referral_code'],
                'referred_at' => now(),
                'commission_amount' => 0,
                'commission_paid' => false,
                'commission_paid_at' => null,
                'status' => 'registered',
                'property_id' => null,
                'transaction_id' => null,
            ]);
            
            $referrer->notify(new NewReferralSignupNotification($user));
            $user->notify(new ReferralConnectionNotification($referrer));
        }

        try {
            $customerId = $walletController->createVirtualAccountCustomer($user);
            
            if (!$customerId) {
                throw new \Exception('Failed to create virtual account customer');
            }

            $virtualAccountResponse = $walletController->createDedicatedAccount($customerId);
            
            if ($virtualAccountResponse['status'] !== true) {
                throw new \Exception('Failed to create dedicated account');
            }

            $virtualAccountData = $virtualAccountResponse['data'];

            VirtualAccount::create([
                'user_id' => $user->id,
                'user_email' => $user->email,
                'bank_name' => $virtualAccountData['bank']['name'],
                'account_name' => $virtualAccountData['account_name'],
                'account_number' => $virtualAccountData['account_number'],
                'currency' => $virtualAccountData['currency'],
                'customer_code' => $virtualAccountData['customer']['customer_code'],
                'is_active' => true,
            ]);

            $user->wallet()->create([
                'user_id' => $user->id,
                'user_email' => $user->email,
                'balance' => 0.00,
                'currency' => $virtualAccountData['currency'] ?? 'NGN',
            ]);

            $referralLink = "https://dohmayn.com/user/register/referral/{$user->referral_code}";
            Mail::to($user->email)->send(new VerificationEmail($user, $referralLink, $virtualAccountData));

            $token = $user->createToken('authToken')->plainTextToken;
            
            return [
                'user' => $user,
                'token' => $token,
                'status' => 'success',
                'otp_sent' => true,
                'message' => 'Registration successful. Please verify your email and phone with the OTPs sent.'
            ];

        } catch (\Exception $e) {
            // Delete the user if wallet creation fails
            \Log::error('Wallet creation failed:', ['error' => $e->getMessage()]);
            // $user->delete();
            User::where('id', $user->id)->delete();
            
            throw ValidationException::withMessages([
                'wallet' => ['Registration failed: ' . $e->getMessage()],
            ]);
        }
    }

    public function createRecipientId()
    {
        $prefix = "DOHMAYN";
        $randomNumber = rand(10000, 99999);
        $uniqueCode = strtoupper(Str::random(10));
        
        return "{$prefix}-{$randomNumber}-{$uniqueCode}";
    }

    private function generateReferralCode()
    {
        do {
            $code = 'DOHMAYN' . strtoupper(Str::random(6));
        } while (User::where('referral_code', $code)->exists());

        return $code;
    }
}