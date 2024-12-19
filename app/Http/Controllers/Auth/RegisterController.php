<?php

namespace App\Http\Controllers\Auth;
use Mail;
use App\Http\Controllers\WalletController;
use App\Models\User;
use App\Models\VirtualAccount;
use Illuminate\Support\Str;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Mail\VerificationEmail;
use Illuminate\Validation\Rules\Password;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/login';

    public function __construct()
    {
        $this->middleware('guest');
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }
 
    public function register(Request $request, WalletController $walletController)
    {
        // Validate the input
        $request->validate([
            'first_name' => 'required|string|max:50|unique:users',
            'last_name' => 'required|string|max:50|unique:users',
            'email' => 'required|string|email|max:50|unique:users',
            'phone' => 'required|string|regex:/^\+?[0-9]{10,15}$/|unique:users',
            'password' => ['required', 'confirmed', Password::min(8)->letters()->numbers()],
            'referral_code' => 'nullable|string|exists:users,referral_code',
        ]);
     
        // Generate the recipient ID
        $recipientId = $this->createRecipientId();
        
        // Create the user
        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'recipient_id' => $recipientId,
            'password' => Hash::make($request->password),
            'profile_image' => null,
            'referral_code' => $this->generateReferralCode(),
            'referred_by' => $request->referral_code
                ? User::where('referral_code', $request->referral_code)->value('id')
                : null,
        ]);
        // Create a virtual account
        $customerId = $walletController->createVirtualAccountCustomer($user);

        if ($customerId) {
           $virtualAccountResponse = $walletController->createDedicatedAccount($customerId);
           if ($virtualAccountResponse['status'] === true) {
                $virtualAccountData = $virtualAccountResponse['data'];
                // Store virtual account details in the new table
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
            }
        } else {
            return redirect()->back()->withErrors('Unable to register with Paystack. Please try again later.');
        }
        // $users = Auth::user();
        // Create a wallet for the user
        $user->wallet()->create([
            'user_id' => $user->id,
            'user_email' =>$user->email,
            'balance' => 0.00,
            'currency' => $virtualAccountData['currency'] ?? 'NGN',
        ]);

         // Send verification email and referral link
        $referralLink = "https://dohmayn.com/user/register/referral/{$user->referral_code}";
        Mail::to($user->email)->send(new VerificationEmail($user, $referralLink,  $virtualAccountData));

        // Redirect to the intended page or dashboard
        return redirect()->route('login')->with('success', 'Please check your email to verify your account.');
    }
    
    private function generateReferralCode()
    {
        return strtoupper(substr(md5(uniqid(mt_rand(), true)), 0, 8));
    }

    public function createRecipientId()
    {
        $prefix = "DOHMAYN";
        $randomNumber = rand(10000, 99999); 
        $uniqueCode = strtoupper(Str::random(10)); 
        
        $recipientId = "{$prefix}-{$randomNumber}-{$uniqueCode}";
        return $recipientId;
    }

    protected function handleReferralCode($referralCode)
    {
        if ($referralCode) {
            $referrer = User::where('referral_code', $referralCode)->first();

            if ($referrer) {
                return $referrer->id; 
            }
        }
        return null; 
    }

   
}
