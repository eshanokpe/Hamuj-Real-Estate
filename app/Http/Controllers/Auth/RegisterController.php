<?php

namespace App\Http\Controllers\Auth;
use Cache;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use App\Http\Controllers\Controller;
use App\Http\Controllers\WalletController;
use App\Http\Requests\RegisterRequest;
use App\Mail\OtpMail;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use App\Notifications\EmailOtpNotification;
use App\Notifications\SmsOtpNotification;
use App\Services\AuthService;
use App\Services\OtpService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Events\Registered;
use Twilio\Rest\Client as TwilioClient;

class RegisterController extends Controller
{
    protected AuthService $authService;
    protected WalletController $walletController;

    public function __construct(AuthService $authService, WalletController $walletController)
    {
        $this->authService = $authService;
        $this->walletController = $walletController;
        $this->middleware('guest');
        $this->middleware('throttle:10,1')->only('sendOtp', 'verifyOtp', 'register');
    }

    public function showRegistrationForm($referralCode = null)
    {
        return view('auth.register', ['referralCode' => $referralCode]);
    }

    public function register(RegisterRequest $request)
    {
        try {
            $validatedData = $request->validated();
            Log::error('validatedData success:', ['validatedData' => $validatedData]);

            $result = $this->authService->register($validatedData, $this->walletController);
            Log::error('Registration success:', ['result' => $result]);
            
            return $this->handleRegistrationSuccess($request, $result);
        } catch (ValidationException $e) {
            Log::error('ValidationException:', $e->errors());
            return $this->handleExceptionError($request, $e, 422);
        } catch (\Exception $e) {
            Log::error('Registration failed:', ['error' => $e->getMessage()]);
            return $this->handleExceptionError($request, $e, 500);
        }
    }

    private function handleExceptionError(Request $request, \Exception $e, int $statusCode)
    {
        if ($request->wantsJson()) {
            return response()->json([
                'message' => 'Registration failed',
                'error' => $e->getMessage(),
            ], $statusCode);
        }

        return redirect()->back()
            ->with('error', $e->getMessage())
            ->withInput();
    }

    private function handleRegistrationSuccess(Request $request, $result)
    {
        
        if ($request->wantsJson()) {
            return response()->json([
                'message' => 'Registration successful',
                'user' =>  $result['user'],
                'token' => $result['token'],
            ], 201);
        }
        Log::error('Registration success:', ['user' => $result]);

        event(new Registered($result['user']));
        \Auth::login($result['user']);
        
        return response()->json([
            'success' => true,
            'message' => 'Registration successful! Your account has been verified.',
        ], 201);
    }

    public function sendOtp(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'email' => 'required|email',
                'phone' => 'required|string|min:10',
            ]);

            // Generate 6-digit numeric OTP
            $otp = random_int(100000, 999999);
            $expiresAt = now()->addMinutes(15);

            // Cache keys for email and phone
            $emailCacheKey = 'otp_email_' . md5($validated['email']);
            $phoneCacheKey = 'otp_phone_' . md5($validated['phone']);

            
            // Store OTP in cache
            Cache::put($emailCacheKey, [
                'code' => $otp,
                'expires_at' => $expiresAt
            ], $expiresAt);

            Cache::put($phoneCacheKey, [
                'code' => $otp,
                'expires_at' => $expiresAt
            ], $expiresAt);

            // Send email OTP
            try {
                Log::debug('Generated OTP for email', [
                    'email' => $validated['email'],
                    'otp' => $otp
                ]);
                $this->sendEmailOtp($validated['email'], $otp);
            } catch (\Exception $e) {
                Log::error('Email OTP sending failed', [
                    'email' => $validated['email'],
                    'error' => $e->getMessage()
                ]);

                return response()->json([
                    'success' => false,
                    'message' => 'Failed to send OTP to email.',
                    'error' => env('APP_DEBUG') ? $e->getMessage() : 'Please try again.'
                ], 500);
            }

            return response()->json([
                'success' => true,
                'message' => 'OTP sent successfully to email.',
                'otp' => $otp,
                'expires_at' => $expiresAt->toDateTimeString()
            ]);

        } catch (\Illuminate\Validation\ValidationException $validationException) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validationException->errors()
            ], 422);

        } catch (\Exception $generalException) {
            Log::error('OTP sending failed', [
                'error' => $generalException->getMessage(),
                'trace' => $generalException->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'An unexpected error occurred while sending OTP',
                'error' => env('APP_DEBUG') ? $generalException->getMessage() : 'Please try again later'
            ], 500);
        }
    }

    protected function sendEmailOtp(string $email, int $otp): void
    {
        Mail::to($email)->send(new OtpMail($otp));
    }

    protected function sendSmsOtp(string $phone, int $otp): void
    {
        $twilio = new TwilioClient(
            config('services.twilio.sid'),
            config('services.twilio.token')
        );

        $message = "Your verification code is: $otp\nValid for 15 minutes. Do not share this code.";
        
        $twilio->messages->create(
            $this->formatPhoneNumber($phone),
            [
                'body' => $message,
                'messagingServiceSid' => config('services.twilio.messagingServiceSid')
            ]
        );
    }

    public function verifyOtp(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'otp' => 'required|digits:6',
                'email' => 'required|email',
                'phone' => 'required|string|min:10'
            ]);

            // Check both email and phone OTPs
            $emailCacheKey = 'otp_email_' . md5($validated['email']);
            $phoneCacheKey = 'otp_phone_' . md5($validated['phone']);

            $emailOtp = Cache::get($emailCacheKey) == null ? $validated['email'] : null;
            $phoneOtp = Cache::get($phoneCacheKey) == null ? $validated['phone'] : null;
            \Log::warning("Cache data ", [
                'otp' => $validated['otp'],
                'email' => $emailOtp,
                'phone' => $phoneOtp
            ]);

            if (!$emailOtp || !$phoneOtp) {
                \Log::warning("OTP data not found", [
                    'email' => $validated['email'],
                    'phone' => $validated['phone']
                ]);
                return response()->json([
                    'success' => false,
                    'message' => 'OTP expired or invalid. Please request a new one.'
                ], 422);
            }

            // Verify OTPs haven't expired
            if (now()->gt($emailOtp['expires_at']) || now()->gt($phoneOtp['expires_at']) ) {
                \Log::warning("Expired OTP attempt", [
                    'email' => $validated['email'],
                    'phone' => $validated['phone']
                ]);
                
                // Clean up expired OTPs
                Cache::forget($emailCacheKey);
                Cache::forget($phoneCacheKey);
                
                return response()->json([
                    'success' => false,
                    'message' => 'OTP has expired. Please request a new one.'
                ], 422);
            }

            // Verify OTP matches for both channels
            if (!hash_equals((string)$emailOtp['code'], (string)$validated['otp']) || 
                !hash_equals((string)$phoneOtp['code'], (string)$validated['otp'])) {
                \Log::warning("Invalid OTP attempt", [
                    'email' => $validated['email'],
                    'phone' => $validated['phone'],
                    'attempt' => $validated['otp']
                ]);
                
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid OTP code.'
                ], 422);
            }

            // Mark both channels as verified
            $verificationExpiry = now()->addMinutes(15);
            
            $emailVerificationKey = 'otp_verified_email_' . md5($validated['email']);
            $phoneVerificationKey = 'otp_verified_phone_' . md5($validated['phone']);
            
            Cache::put($emailVerificationKey, [
                'verified_at' => now(),
                'contact' => $validated['email']
            ], $verificationExpiry);

            Cache::put($phoneVerificationKey, [
                'verified_at' => now(),
                'contact' => $validated['phone']
            ], $verificationExpiry);

            // Clean up OTP data
            Cache::forget($emailCacheKey);
            Cache::forget($phoneCacheKey);

            \Log::info("Dual OTP verification successful", [
                'email' => $validated['email'],
                'phone' => $validated['phone']
            ]);

            return response()->json([
                'success' => true,
                'message' => 'OTP verified successfully',
                'verified_email' => $validated['email'],
                'verified_phone' => $validated['phone'],
                'expires_at' => $verificationExpiry->toDateTimeString()
            ]);

        } catch (ValidationException $e) {
            \Log::error("OTP validation failed", ['errors' => $e->errors()]);
            return response()->json([
                'success' => false,
                'message' => 'Invalid request data',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            \Log::error("OTP verification error: " . $e->getMessage(), [
                'exception' => $e,
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'An error occurred during verification. Please try again.'
            ], 500);
        }
    }

    public function verifyOTPAPI(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'otp' => 'required|digits:6',
                'email' => 'required|email',
                'phone' => 'required|string|min:10'
            ]);

            $emailCacheKey = 'otp:email:' . md5($validated['email']);
            $phoneCacheKey = 'otp:phone:' . md5($validated['phone']);

            $emailOtpData = Cache::get($emailCacheKey);
            $phoneOtpData = Cache::get($phoneCacheKey);

            // Check if OTP exists
            if (!$emailOtpData || !$phoneOtpData) {
                return response()->json([
                    'success' => false,
                    'message' => 'OTP expired or invalid'
                ], 422);
            }

            // Check attempts limit (max 5 attempts)
            if ($emailOtpData['attempts'] >= 5 || $phoneOtpData['attempts'] >= 5) {
                Cache::forget($emailCacheKey);
                Cache::forget($phoneCacheKey);
                return response()->json([
                    'success' => false,
                    'message' => 'Too many attempts. Please request a new OTP.'
                ], 429);
            }

            // Verify expiration
            if (now()->gt($emailOtpData['expires_at'])) {
                return response()->json([
                    'success' => false,
                    'message' => 'OTP has expired'
                ], 422);
            }

            // Verify OTP (timing-safe comparison)
            $otpHash = hash('sha256', $validated['otp']);
            if (!hash_equals($emailOtpData['code_hash'], $otpHash)) {
                // Increment attempts
                Cache::increment("{$emailCacheKey}.attempts");
                Cache::increment("{$phoneCacheKey}.attempts");

                return response()->json([
                    'success' => false,
                    'message' => 'Invalid OTP code',
                    'attempts_remaining' => 5 - ($emailOtpData['attempts'] + 1)
                ], 422);
            }

            // Mark as verified
            $verificationExpiry = now()->addMinutes(30);
            $verificationKey = 'auth:verified:' . md5($validated['email'] . $validated['phone']);

            Cache::put($verificationKey, [
                'email' => $validated['email'],
                'phone' => $validated['phone'],
                'verified_at' => now()
            ], $verificationExpiry);

            // Cleanup OTP data
            Cache::forget($emailCacheKey);
            Cache::forget($phoneCacheKey);

            return response()->json([
                'success' => true,
                'message' => 'OTP verified successfully',
                'verification_expires_at' => $verificationExpiry->toDateTimeString()
            ]);

        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid input data',
                'errors' => $e->errors()
            ], 422);

        } catch (\Exception $e) {
            Log::error('OTP verification error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Verification failed. Please try again.'
            ], 500);
        }
    }

    public function verifyBvn(Request $request): JsonResponse
    {

        $validated = $request->validate([
            'bvn' => 'required|digits:11',
            'firstname' => 'sometimes|string|max:50',
            'lastname' => 'sometimes|string|max:50',
            'email' => 'sometimes|string|max:50',
        ]);

        try {
            $response = Http::asForm()
            ->withHeaders([
                'accept' => 'application/json',
                'content-type' => 'application/x-www-form-urlencoded',
                'x-api-key' => config('services.prembly.api_key'),
                'app-id' => config('services.prembly.app_id'),
            ])
            ->post(config('services.prembly.base_url').config('services.prembly.bvn_validation_url'), [
                'number' => $request->bvn,
            ]);

            $data = $response->json();

            if (!$response->successful() || !$data['status'] || $data['response_code'] !== '00') {
                return response()->json([
                    'status' => false,
                    'message' => $data['detail'] ?? 'BVN verification failed'
                ], 422);
            }

            // Verify names match if provided
            // if (isset($validated['email'])) {
            //     $bvnEmail = strtolower($data['data']['email']);
            //     $inputEmail = strtolower($validated['email']);
            //     if ($bvnEmail !== $inputEmail) {
            //         return response()->json([
            //             'status' => false,
            //             'message' => 'Email do not match BVN records'
            //         ], 422);
            //     }
            // }

            // Verify names match if provided
            if (isset($validated['firstname']) && isset($validated['lastname'])) {
                $bvnFirstName = strtolower(trim($data['data']['firstName']));
                $bvnLastName = strtolower(trim($data['data']['lastName']));
                $inputFirstName = strtolower(trim($validated['firstname']));
                $inputLastName = strtolower(trim($validated['lastname']));

                if ($bvnFirstName !== $inputFirstName || $bvnLastName !== $inputLastName) {
                    return response()->json([
                        'status' => false,
                        'message' => 'Names do not match BVN records'
                    ], 422);
                }
            }
            // Store BVN verification data
            $request->session()->put('bvn_verification', $data);
            
            return response()->json([
                'status' => true,
                'message' => 'BVN verified successfully',
                'data' => $data['data']
            ]);

        } catch (\Exception $e) {
            Log::error('BVN verification error:', ['error' => $e->getMessage()]);
            return response()->json([
                'status' => false,
                'message' => 'Error connecting to BVN service'
            ], 500);
        }
    }

    public function verifyNin(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'bvn' => 'required|digits:11', // Note: You're validating 'bvn' but using NIN endpoint
            'firstname' => 'sometimes|string|max:50',
            'lastname' => 'sometimes|string|max:50',
            'email' => 'sometimes|string|email|max:50',
        ]);

        try {
            $response = Http::withHeaders([
                'accept' => 'application/json',
                'content-type' => 'application/json', // Changed from form to json
                'x-api-key' => config('services.prembly.api_key'),
                'app-id' => config('services.prembly.app_id'),
            ])
            ->post(config('services.prembly.base_url').config('services.prembly.nin_validation_url'), [
                'number_nin' => $request->bvn, // Note: Field name should match API expectation
            ]);

            $data = $response->json();

            if (!$response->successful() || !isset($data['status'])) {
                return response()->json([
                    'status' => false,
                    'message' => $data['detail'] ?? 'NIN verification failed'
                ], 422);
            } 

            if ($data['response_code'] !== '00') {
                return response()->json([
                    'status' => false,
                    'message' => $data['detail'] ?? 'NIN verification unsuccessful',
                    'response_code' => $data['response_code']
                ], 422);
            }

            // Store NIN verification data
            $request->session()->put('nin_data', $data['nin_data'] ?? $data['data']);
            
            return response()->json([
                'status' => true,
                'message' => $data['detail'] ?? 'NIN verified successfully',
                'data' => $data['nin_data'] ?? $data['data']
            ]);

        } catch (\Exception $e) {
            Log::error('NIN verification error:', ['error' => $e->getMessage()]);
            return response()->json([
                'status' => false,
                'message' => 'Error connecting to NIN service: ' . $e->getMessage()
            ], 500);
        }
    }

    public function verifyBvnFace(Request $request): JsonResponse
    {
        $request->validate([
            'face_image' => 'required|image|max:2048',
            'bvn' => 'required|string|size:11'
        ]);

        // Get BVN verification data from session
        $bvnVerification = $request->session()->get('bvn_verification');
        // Get the actual uploaded file
        $faceImage = $request->file('face_image');
        if (!$bvnVerification) {
            return response()->json([
                'status' => false,
                'message' => 'BVN verification required first'
            ], 400);
        }

        try {
            // Upload to Cloudinary
            $uploadedFile = $request->file('face_image');
            $cloudinaryResponse = Cloudinary::upload($uploadedFile->getRealPath(), [
                'folder' => 'face_verifications',
                'public_id' => 'face_'.time().'_'.$request->bvn
            ]);
            $imageUrl = $cloudinaryResponse->getSecurePath();

            $response = Http::asForm()
                ->withHeaders([
                    'accept' => 'application/json',
                    'content-type' => 'application/x-www-form-urlencoded',
                    'x-api-key' => config('services.prembly.api_key'),
                    'app-id' => config('services.prembly.app_id'),
                ])
                //])->attach('image', $faceImage->get(), $faceImage->getClientOriginalName())
                ->post('https://api.prembly.com/identitypass/verification/bvn_w_face', [
                    'number' => $request->bvn,
                    // 'image' => 'https://res.cloudinary.com/duxyik2cv/image/upload/v1751799017/face_verifications/face_1751799015_54651333604.jpg',
                    'image' => 'https://res.cloudinary.com/dh3i1wodq/image/upload/v1675417496/cbimage_3_drqdoc.jpg'
  
                ]);


            if ($response->successful()) {
                $data = $response->json();
                
                if ($data['status'] && $data['face_data']['status']) {
                    return response()->json([
                        'status' => true,
                        'face_data' => $data['face_data'],
                        'detail' => $data['detail']
                    ]);
                }
            }

            // If we get here, verification failed
            return response()->json([
                'status' => false,
                'message' => $data['message'] ?? 'Face verification failed',
                'bvn' => $request->bvn,
                'image_received' => true
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Verification service error: ' . $e->getMessage(),
                'bvn' => $request->bvn,
                'image_received' => $request->hasFile('face_image')
            ], 500);
        }
    }

    protected function formatPhoneNumber(string $phone): string
    {
        $phone = preg_replace('/[^0-9]/', '', $phone);
        
        if (str_starts_with($phone, '0')) {
            return '+234' . substr($phone, 1);
        }
        
        if (!str_starts_with($phone, '+')) {
            return '+234' . $phone;
        }
        
        return $phone;
    }

   

  
}