<?php

namespace App\Http\Controllers\Auth;
use Mail;
use App\Models\User;
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
 
    public function register(Request $request)
    {
        // Validate the input
        $request->validate([
            'name' => 'required|string|max:50|unique:users',
            'email' => 'required|string|email|max:50|unique:users',
            'password' => ['required', 'confirmed', Password::min(8)->letters()->numbers()],
            // 'password' => 'required|string|min:8|confirmed',
        ]);

        // Create the user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'profile_image' => null,
            'referral_code' => $this->generateReferralCode(),
            'referred_by' => $this->handleReferralCode($request->referral_code),
        ]);
        $referralDetails = User::where('referral_code', $user->referral_code)->first();
        $referralLink = "https://dohmayn.com/user/register/referral/$request->referral_code";


        // Send verification email
        Mail::to($user->email)->send(new VerificationEmail($user, $referralLink));

        // Redirect to the intended page or dashboard
        return redirect()->route('login')->with('success', 'Please check your email to verify your account.');
    }
    
    private function generateReferralCode()
    {
        return strtoupper(substr(md5(uniqid(mt_rand(), true)), 0, 8));
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
