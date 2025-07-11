<?php

namespace App\Http\Controllers\Auth;
use Mail; 
use App\Http\Controllers\WalletController;
use App\Models\User;
use Illuminate\Support\Facades\Http;
use App\Models\ReferralLog;
use App\Models\VirtualAccount;
use Illuminate\Support\Str;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Mail\OtpMail;
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
        /**
         * Format the phone number to E.164 format for Twilio.
         * You may need to adjust this logic to fit your requirements.
         */
       
    
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

    public function sendOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'otp_method' => 'required|in:email,phone',
            'contact' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ]);
        }
        // Generate and send OTPs 
        $otp = rand(100000, 999999);
        session([
            'otp' => $otp, 
            'otp_contact' => $request->contact
        ]);
 
        $method = $request->otp_method;
        $contact = $request->contact;

        if($method == 'email'){ 
            Mail::to($contact)->send(new OtpMail($otp));
        } else if($method == 'phone'){
            // new SmsOtpNotification($otp);  
            $this->sendViaTwilio($contact, $otp);
        }

        return response()->json([
            'success' => true,
            'message' => 'OTP sent successfully'
        ]);
    }

    public function formatPhoneNumber($phone)
    {
        // Example: Ensure phone starts with + and country code (e.g., +234 for Nigeria)
        $phone = preg_replace('/[^0-9]/', '', $phone); // Remove non-numeric chars
        if (strpos($phone, '0') === 0) {
            // Replace leading 0 with country code, e.g., +234
            $phone = '+234' . substr($phone, 1);
        } elseif (strpos($phone, '+') !== 0) {
            // If not starting with +, add your default country code
            $phone = '+234' . $phone;
        } else {
            $phone = '+' . ltrim($phone, '+');
        }
        return $phone;
    }
    protected function sendViaTwilio($phone, $otp)
    {
        $sid = config('services.twilio.sid');
        $token = config('services.twilio.token');
        $from = config('services.twilio.from');
        $messagingServiceSid = config('services.twilio.messagingServiceSid');
        $message =  "DO NOT DISCLOSE. Dear Customer,\n"
                    . "The code for your phone number authentication is: " . $otp . " \n"
                    . "No Staff of Dohmayn will ask for this code!\n"
                    . "Valid for 15 minutes. Do not share to anyone!.\n"
                    . config('app.name'); 
        $twilio = new \Twilio\Rest\Client($sid, $token);

        $twilio->messages->create(
            $this->formatPhoneNumber($phone), 
            [
                'body' => $message,
                'messagingServiceSid' => $messagingServiceSid
            ]
        );
    }

    public function verifyOtp(Request $request)
    {
       
        $validator = Validator::make($request->all(), [
            'otp' => 'required|digits:6',
            'method' => 'required|in:email,phone',
            'contact' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ]);
        }

        $storedOtp = session('otp');
        $storedContact = session('otp_contact');

        if ($storedOtp && $storedContact === $request->contact && $storedOtp == $request->otp) {
            session(['otp_verified' => true]);
            return response()->json([
                'success' => true,
                'message' => 'OTP verified successfully',
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Invalid OTP',
            'storedOtp' => $storedOtp,
            'storedContact' => $storedContact,
        ]);
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

    public function verifyBvn(Request $request)
    {
        
        $validator = Validator::make($request->all(), [
            'bvn' => 'required|digits:11',
            'firstname' => 'sometimes|string',
            'lastname' => 'sometimes|string',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->first()
            ]);
        }
        try {
            $response = Http::asForm()
            ->withHeaders([
                'accept' => 'application/json',
                'content-type' => 'application/x-www-form-urlencoded',
                'x-api-key' => 'sandbox_sk_a5IgBKvHTYJXsd4d1rt8eABRKwBjw8NrC0xvKsV',
            ])
            ->post('https://api.prembly.com/identitypass/verification/bvn_validation', [
                'number' => $request->bvn,
            ]);


            $data = $response->json();
           
            if ($response->successful() && $data['status'] && $data['response_code'] === '00') {
                // Verify names match if provided
                if ($request->firstname && $request->lastname) {
                    $bvnFirstName = strtolower($data['data']['firstName']);
                    $bvnLastName = strtolower($data['data']['lastName']);
                    $inputFirstName = strtolower($request->firstname);
                    $inputLastName = strtolower($request->lastname);

                    if ($bvnFirstName !== $inputFirstName || $bvnLastName !== $inputLastName) {
                        return response()->json([
                            'status' => false,
                            'message' => 'Names do not match BVN records'
                        ]);
                    }
                }

                return response()->json([
                    'status' => true,
                    'message' => 'BVN verified successfully',
                    'data' => $data['data']
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'data' => $data,
                    'message' => $data['detail'] ?? 'BVN verification failed'
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Error connecting to BVN service',
                'error' => $e->getMessage()
            ]);
        }
        // return response()->json([
        //     'status' => false,
        //     'message' => 'Error connecting to BVN service'
        // ]);
        
    }

   
}
