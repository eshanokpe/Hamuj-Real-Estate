<?php

namespace App\Services;
use Mail; 
use Log;
use App\Http\Controllers\WalletController;
use App\Models\User;
use App\Models\ReferralLog; 
use App\Models\VirtualAccount;
use Illuminate\Support\Str;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Mail\VerificationEmail;
use Illuminate\Validation\Rules\Password;
use App\Services\AuthService;
use App\Services\OtpService;
use Illuminate\Validation\ValidationException;
use App\Notifications\NewReferralSignupNotification;
use App\Notifications\ReferralConnectionNotification;
use App\Notifications\EmailOtpNotification;
use App\Notifications\SmsOtpNotification;
 
class AuthService
{
    // Register a user
    public function register(array $data, $walletController)
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
            'registration_source' => 'web',
            'phone' => $data['phone'] ?? null,
            'recipient_id' => $recipientId,
            'password' => isset($data['password']) ? Hash::make($data['password']) : null,
            'profile_image' => null,
            'referral_code' => $this->generateReferralCode(),
            'referred_by' => $referrer?->id,
            'otp_verified_at' => now(),
            'email_verified_at' => now(),
            'otp_method' => $data['otp_method'] ?? null,
            'otp' => $data['otp'] ?? null,
            'otp_expires_at' => $data['otp_expires_at'] ?? null,
            'verification_method' => $data['verification_method'] ?? null,
            'bvn' => $data['bvn'] ?? null, 
            'nin' => $data['nin'] ?? null,
            'terms' => isset($data['terms']),
            'verified_at' => now(),
        ]);

        // ✅ Assign "user" role if exists
        if (\Spatie\Permission\Models\Role::where('name', 'user')->exists()) {
            $user->assignRole('user');
        }

        // ✅ Referral Logic
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

        // ✅ Create Paystack Customer
        $customer = $walletController->createVirtualAccountCustomer($user);

        if (!$customer || empty($customer['customer_code'])) {
            $user->delete();
            throw ValidationException::withMessages([
                'wallet' => ['Failed to create Paystack customer.'],
            ]);
        }

        Log::debug('Paystack customer created', ['customer' => $customer]);
        $customerCode = $customer['customer_code'];

        // ✅ Create Dedicated Virtual Account
        $virtualAccountResponse = $walletController->createDedicatedAccount($customerCode);
        Log::debug('createDedicatedAccount', ['virtualAccountResponse' => $virtualAccountResponse]);

        if (is_array($virtualAccountResponse) && isset($virtualAccountResponse['account_number'])) {
            $virtualAccountData = $virtualAccountResponse;

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

            // ✅ Send verification email
            $referralLink = "https://dohmayn.com/user/register/referral/{$user->referral_code}";
            try {
                Mail::to($user->email)->send(new VerificationEmail($user, $referralLink, $virtualAccountData));
                \Log::info('VerificationEmail sent successfully');
            } catch (\Exception $e) {
                \Log::error('VerificationEmail sending failed: ' . $e->getMessage());
            }

            $token = $user->createToken('dohmayn')->plainTextToken;
 
            return [
                'user' => $user,
                'token' => $token,
                'otp_sent' => true,
                'message' => 'Registration successful. Please verify your email and phone with the OTPs sent.',
            ];
        }

        // ❌ Final fallback error if virtual account not created
        $user->delete();
        throw ValidationException::withMessages([
            'wallet' => ['Unable to register with Paystack. Please try again later.'],
        ]);
    }



    // Generate a unique recipient ID
    public function createRecipientId()
    {
        $prefix = "DOHMAYN";
        $randomNumber = rand(10000, 99999); 
        $uniqueCode = strtoupper(Str::random(10)); 
        
        $recipientId = "{$prefix}-{$randomNumber}-{$uniqueCode}";
        return $recipientId;
    }

    // Generate a unique referral code
    private function generateReferralCode()
    {
        do {
            $code = 'DOHMAYN' . strtoupper(Str::random(6));
        } while (User::where('referral_code', $code)->exists());

        return $code;
    }
}