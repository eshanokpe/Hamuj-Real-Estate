<?php

namespace App\Http\Controllers\Auth;
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
use App\Services\OtpService;
use App\Notifications\EmailOtpNotification;
use App\Notifications\SmsOtpNotification;
use Illuminate\Validation\ValidationException;
 
class RegisterController extends Controller
{
   
    protected $authService;
    protected $walletController;

    // use RegistersUsers;

    protected $redirectTo = '/login';
    public function __construct(AuthService $authService, WalletController $walletController)
    {
        $this->authService = $authService;
        $this->walletController = $walletController;
        $this->middleware('guest');
    }

    public function showRegistrationForm($referralCode = null)
    {
        return view('auth.register', ['referralCode' => $referralCode]);
    }

    public function getRegister(){
        return response()->json([
            'message' => 'Get Register',
        ], 200);
    }
    // protected function validator(array $data)

  
    public function register(Request $request, WalletController $walletController)
    {
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:50',
            'last_name' => 'required|string|max:50',
            'email' => 'required|string|email|max:50|unique:users,email',
            'phone' => 'required|string', 
            // 'registration_source' => 'nullable|string',
            'password' => 'required|confirmed|min:8', // At least 8 characters, letters and numbers
            // 'password' => ['required', 'confirmed', Password::min(8)->letters()->numbers()],
            'referral_code' => 'nullable|string|exists:users,referral_code',
            // 'dob' => [
            //     'nullable',
            //     'date', 
            //     'before:' . now()->subYears(18)->format('Y-m-d'),
            // ]
        ],
        [
            'password.required' => 'The password field is required.',
            'password.confirmed' => 'Password confirmation does not match.',
        ]
        //  [
        //     'dob.before' => 'You must be at least 18 years old to register.',
        // ]
    );

        // Handle validation failure
        if ($validator->fails()) {
            \Log::error('Validation failed:', $validator->errors()->toArray());
            return $this->handleValidationError($request, $validator);
        }

        try {
            // Call AuthService register method.   
            
            $result = app(AuthService::class)->register($request->all(), $walletController);
            return $this->handleRegistrationSuccess($request, $result);
        } catch (ValidationException $e) { 
            \Log::error('ValidationException:', $e->errors());
            return $this->handleExceptionError($request, $e, 422);
        } catch (\Exception $e) {
            \Log::error('Registration failed:', ['error' => $e->getMessage()]);
            return $this->handleExceptionError($request, $e, 500);
        }
    }

    private function handleValidationError(Request $request, $validator)
    {
        if ($request->wantsJson()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 422);
        }

        return redirect()->back()
            ->withErrors($validator->errors())
            ->withInput();
    }

    private function handleRegistrationSuccess(Request $request, $result)
    {
        if ($request->wantsJson()) {
            return response()->json([
                'message' => 'Registration successful',
                'user' => $result['user'],
                'token' => $result['token'],
            ], 201);
        }
 
        return redirect()->route('verification.notice', ['user_id' => encrypt($result['user']->id)])->with([
            'success' => 'Your account is not fully verified.  An OTP has been sent to your email and phone.',
           
        ]);
    }

    private function handleExceptionError(Request $request, \Exception $e, $statusCode)
    {
        if ($request->wantsJson()) {
            return response()->json([
                'message' => 'Registration failed',
                'error' => $e->getMessage(),
            ], $statusCode);
        }

        return redirect()->back()->with('error', $e->getMessage())->withInput();
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

    public function checkEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);
        $email = $request->input('email');
        $user = User::where('email', $email)->first();
        if ($user) {
            return response()->json([
                'message' => 'Email is already registered.',
                'exists' => true,
            ], 200);
        }
        return response()->json([
            'message' => 'Email is available.',
            'exists' => false,
        ], 200);
    }

    public function verifyEmailOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp' => 'required|digits:6'
        ]);

        $user = User::where('email', $request->email)->first();
        
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $otpService = app(OtpService::class);
        $verified = $otpService->verifyOtp($user, $request->otp, 'email');

        if ($verified) {
            $user->email_verified_at = now();
            $user->save();

            return response()->json([
                'message' => 'Email verified successfully',
                'email_verified' => true,
                'phone_verified' => $user->phone_verified_at !== null,
                'fully_verified' => $otpService->isVerified($user)
            ]);
        }

        return response()->json(['message' => 'Invalid OTP or expired'], 400);
    }

    public function verifyPhoneOtp(Request $request)
    {
        $request->validate([
            'phone' => 'required',
            'otp' => 'required|digits:6'
        ]);

        $user = User::where('phone', $request->phone)->first();
        
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $otpService = app(OtpService::class);
        $verified = $otpService->verifyOtp($user, $request->otp, 'phone');

        if ($verified) {
            $user->phone_verified_at = now();
            $user->save();

            return response()->json([
                'message' => 'Phone verified successfully',
                'phone_verified' => true,
                'email_verified' => $user->email_verified_at !== null,
                'fully_verified' => $otpService->isVerified($user)
            ]);
        }

        return response()->json(['message' => 'Invalid OTP or expired'], 400);
    }

    public function resendOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'type' => 'required|in:email,phone'
        ]);

        $user = User::where('email', $request->email)->first();
        
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $otpService = app(OtpService::class);
        $otps = $otpService->generateOtp($user);

        if ($request->type === 'email') {
            $user->notify(new EmailOtpNotification($otps['email_otp']));
            return response()->json(['message' => 'Email OTP resent successfully']);
        } else {
            $user->notify(new SmsOtpNotification($otps['phone_otp']));
            return response()->json(['message' => 'SMS OTP resent successfully']);
        }
    }

   
}
