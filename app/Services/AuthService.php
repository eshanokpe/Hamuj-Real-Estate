<?php

namespace App\Services;
use Mail; 
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
use Illuminate\Validation\ValidationException;
use App\Notifications\NewReferralSignupNotification;
use App\Notifications\ReferralConnectionNotification;
 
class AuthService
{
    // Register a user
    public function register(array $data, $walletController)
    {
        // Generate the recipient ID
        $recipientId = $this->createRecipientId();
        $referrer = null;

        // Check if referral code is provided and valid
        if (!empty($data['referral_code'])) {
            $referrer = User::where('referral_code', $data['referral_code'])->first();
            if (!$referrer) {
                throw ValidationException::withMessages([
                    'referral_code' => ['Invalid referral code.'],
                ]);
            }
        }

        // Create the user
        $user = User::create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'registration_source' => $data['registration_source'],
            'dob' => $data['dob'],
            'phone' => $data['phone'],
            'recipient_id' => $recipientId,
            'password' => Hash::make($data['password']),
            'profile_image' => null,
            'referral_code' => $this->generateReferralCode(),
            'referred_by' => $referrer ? $referrer->id : null,
        ]);

        // Create referral log if referrer exists
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
            // Notify referrer about new referral signup
            $referrer->notify(new NewReferralSignupNotification($user));

            // Notify new user about successful referral connection
            $user->notify(new ReferralConnectionNotification($referrer));
        }
        


        // Create a virtual account
        $customerId = $walletController->createVirtualAccountCustomer($user);

        if ($customerId) {
            $virtualAccountResponse = $walletController->createDedicatedAccount($customerId);
 
            if ($virtualAccountResponse['status'] === true) {
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

                // Create wallet for the user
                $user->wallet()->create([
                    'user_id' => $user->id,
                    'user_email' => $user->email,
                    'balance' => 0.00,
                    // 'balance' => 500000.00,
                    'currency' => $virtualAccountData['currency'] ?? 'NGN',
                ]);

                // Send verification email and referral link
                $referralLink = "https://dohmayn.com/user/register/referral/{$user->referral_code}";
                Mail::to($user->email)->send(new VerificationEmail($user, $referralLink, $virtualAccountData));
 
                // Return the user and token for API
                $token = $user->createToken('authToken')->plainTextToken;
                return [ 
                    'user' => $user,
                    'token' => $token, 
                ];
            }
        }
 
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