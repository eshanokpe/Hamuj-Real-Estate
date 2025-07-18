<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller; 
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Auth; 
use Carbon\Carbon;
use App\Models\User;
use Cache;
use App\Services\OtpService;
use Illuminate\Support\Facades\Hash;

class SecurityController extends Controller
{
    protected $otpService;
    protected $maxAttempts = 3;

    public function __construct(OtpService $otpService)
    {
        $this->otpService = $otpService;
        $this->middleware('auth');
    }

    public function index(){
        $data['user'] = Auth::user();
        $data['referralsMade'] = $data['user']->referralsMade()->with('user', 'referrer')->take(6)->get();
        $data['hasMoreReferrals'] = $data['referralsMade']->count() > 6;
        return view('user.pages.security.index', $data); 
    }

    public function changePassword(){
        $data['user'] = Auth::user();
        $data['referralsMade'] = $data['user']->referralsMade()->with('user', 'referrer')->take(6)->get();
        $data['hasMoreReferrals'] = $data['referralsMade']->count() > 6;
        return view('user.pages.security.changePassword', $data); 
    }

    public function changePasswordPost(Request $request, $id)
    {
        // Validate the input
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|min:8|confirmed', 
        ]);

        $user = Auth::user();

        // Check if old password is correct
        if (!Hash::check($request->old_password, $user->password)) {
            if ($request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'The old password is incorrect.',
                ], 400); 
            } else {
                return back()->withErrors(['old_password' => 'The old password is incorrect.']);
            }
        }

        // Update the password
        $user->password = Hash::make($request->new_password);
        $user->save();
        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Password changed successfully. For security reasons, please log in again.',
            ], 200);
        } else {
            return back()->with('success', 'Password changed successfully. For security reasons, please log in again.');
        }
    }

    public function transactionPin(){
        $data['user'] = Auth::user();
        $data['referralsMade'] = $data['user']->referralsMade()->with('user', 'referrer')->take(6)->get();
        $data['hasMoreReferrals'] = $data['referralsMade']->count() > 6;
        return view('user.pages.security.transactionPin', $data); 
    }
    
    public function createTransactionPin(Request $request, $id)
    {
        $user = Auth::user();

        $rules = [
            'new_pin' => 'required|min:4|max:4', // New PIN is always required
            'new_pin_confirmation' => 'required|min:4|max:4|same:new_pin', // Ensure confirmation matches
        ];

        if ($user->transaction_pin) {
            $rules['old_pin'] = 'required|min:4|max:4'; // Old PIN is required
        }
       
        // $request->validate($rules);
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 400);
        }

        if ($user->transaction_pin) {
            if (!Hash::check($request->old_pin, $user->transaction_pin)) {
                return $this->sendErrorResponse('The old PIN is incorrect.', 400, $request);
            }
        }

        $user->transaction_pin = Hash::make($request->new_pin);
        $user->save();

        return $this->sendSuccessResponse('Transaction PIN created/updated successfully.', 200, $request);
    }

    public function verifyTransactionPin(Request $request)
    {
        $request->validate([
            'pin' => 'required|digits:4'
        ]);

        $user = Auth::user();

        if (!Hash::check($request->pin, $user->transaction_pin)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid PIN'
            ], 401);
        }

        // Generate and send OTP
        $otpData = $this->otpService->generateAndSendOtp($user);
        
        return response()->json([
            'success' => true,
            'otp_data' => [
                'expires_at' => Carbon::createFromTimestamp($otpData['expires_at'])->toDateTimeString(),
                'delivery_method' => $otpData['delivery_method'],
                'identifier' => $otpData['identifier'] // Add this line
            ],
            'message' => 'OTP sent successfully'
        ]);
    }

    // In your Laravel controller
    public function resetTransactionPin(Request $request, $userId)
    {
        $request->validate([
            'new_pin' => 'required|digits:4',
            'new_pin_confirmation' => 'required|same:new_pin',
        ]);
        $user = User::findOrFail($userId);
        
        // Verify user has permission
        if (Auth::id() != $user->id) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 403);
        }

        $user->update([
            'transaction_pin' => Hash::make($request->new_pin),
            'transaction_pin_updated_at' => now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Transaction PIN reset successfully'
        ]);
    }

    public function verifyOTP(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'otp' => 'required|digits:6',
                'identifier' => 'required|string'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid OTP format',
                    'errors' => $validator->errors()
                ], 422);
            }

            $user = Auth::user();
            $otpCacheKey = 'otp:' . $request->identifier;

            if (!Cache::has($otpCacheKey)) {
                return response()->json([
                    'success' => false,
                    'message' => 'OTP has expired or was not requested'
                ], 400);
            }

            $otpData = Cache::get($otpCacheKey);

            // Verify expiration first
            if (now()->timestamp > $otpData['expires_at']) {
                Cache::forget($otpCacheKey);
                return response()->json([
                    'success' => false,
                    'message' => 'OTP has expired'
                ], 400);
            }

            // Verify user match
            if ($otpData['user_id'] != $user->id) {
                return response()->json([
                    'success' => false,
                    'message' => 'OTP does not belong to this user'
                ], 403);
            }

            // Check maximum attempts (using the class property)
            if ($otpData['attempts'] >= $this->maxAttempts) {
                Cache::forget($otpCacheKey);
                return response()->json([
                    'success' => false,
                    'message' => 'Maximum OTP attempts reached. Please request a new OTP.'
                ], 429);
            }

            // Verify OTP code
            if (!hash_equals($otpData['code_hash'], hash('sha256', $request->otp))) {
                $remainingAttempts = $this->maxAttempts - ($otpData['attempts'] + 1);
                Cache::put($otpCacheKey, array_merge($otpData, [
                    'attempts' => $otpData['attempts'] + 1
                ]), Carbon::createFromTimestamp($otpData['expires_at'])->diffInSeconds(now()));

                return response()->json([
                    'success' => false,
                    'message' => 'Invalid OTP code',
                    'attempts_remaining' => $remainingAttempts
                ], 401);
            }

            // Generate transaction token
            $token = Str::random(64);
            $tokenExpiry = now()->addMinutes(30);
            
            Cache::put("transaction_token:{$token}", [
                'user_id' => $user->id,
                'verified_at' => now()->timestamp,
                'expires_at' => $tokenExpiry->timestamp
            ], $tokenExpiry);

            // Clear used OTP
            Cache::forget($otpCacheKey);

            return response()->json([
                'success' => true,
                'message' => 'OTP verified successfully',
                'token' => $token,
                'token_expires_at' => $tokenExpiry->toDateTimeString()
            ]);

        } catch (\Exception $e) {
            \Log::error('OTP Verification Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'An error occurred during OTP verification',
                'error' => env('APP_DEBUG') ? $e->getMessage() : null
            ], 500);
        }
    }

    public function resendOTP(Request $request)
    {
        try {
            $user = Auth::user();
            
            // Validate if user has an active OTP request
            $otpCacheKey = 'otp:user:' . $user->id;
            
            if (Cache::has($otpCacheKey)) {
                $existingOtp = Cache::get($otpCacheKey);
                
                // Prevent OTP reset abuse
                if (now()->diffInMinutes($existingOtp['created_at']) < 1) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Please wait before requesting a new OTP'
                    ], 429);
                }
                
                // Clear existing OTP
                Cache::forget($otpCacheKey);
            }

            // Generate and send new OTP
            $otpData = $this->otpService->generateAndSendOtp($user);
            
            return response()->json([
                'success' => true,
                'otp_data' => [
                    'expires_at' => \Carbon\Carbon::createFromTimestamp($otpData['expires_at'])->toDateTimeString(),
                    'delivery_method' => $otpData['delivery_method'] // email/sms
                ],
                'message' => 'New OTP has been sent successfully'
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to reset OTP',
                'error' => env('APP_DEBUG') ? $e->getMessage() : null
            ], 500);
        }
    }

    private function sendErrorResponse($message, $statusCode, $request)
    {
        if ($request->wantsJson()) {
            return response()->json([
                'success' => false,
                'message' => $message,
            ], $statusCode);
        } else {
            return back()->withErrors(['error' => $message]);
        }
    }

    // Helper function to send success responses
    private function sendSuccessResponse($message, $statusCode, $request)
    {
        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => $message,
            ], $statusCode);
        } else {
            return back()->with('success', $message);
        }
    }
 
    public function getTransactionPin(Request $request, $userId)
    {
        try {
             
            // Ensure the authenticated user is accessing their own PIN
            if ($request->user()->id != $userId) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Unauthorized',
                ], 403);
            }

            // Fetch the user
            $user = $request->user();

            // Check if the user has a transaction PIN
            if (!$user->transaction_pin) {
                return response()->json([
                    'status' => 'success',
                    'data' => [
                        'has_pin' => false,
                        'message' => 'No transaction PIN set for this user',
                    ],
                ]); 
            }

            // Validate the request
            $validator = Validator::make($request->all(), [
                'entered_pin' => 'required|min:4|max:4', // Ensure the entered PIN is 4 digits
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Validation failed',
                    'errors' => $validator->errors(),
                ], 400);
            }

            // Compare the entered PIN with the stored hashed PIN
            $enteredPin = $request->entered_pin;
            $storedPin = $user->transaction_pin;

            if (Hash::check($enteredPin, $storedPin)) {
                return response()->json([
                    'status' => 'success',
                    'data' => [
                        'pin_match' => true,
                        'message' => 'The entered PIN matches the stored PIN.',
                    ],
                ]);
            } else {
                return response()->json([
                    'status' => 'success',
                    'data' => [
                        'pin_match' => false,
                        'message' => 'The entered PIN does not match the stored PIN.',
                    ],
                ]);
            }
        } catch (\Exception $e) {
            // Log the error
            // Log::error('Error fetching or comparing transaction PIN: ' . $e->getMessage());

            // Return an error response
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to fetch or compare transaction PIN',
            ], 500);
        }
    }

    public function verifyPinWeb(Request $request)
    {
        // Fetch the user
        $user = $request->user();
        // 1. Get all input data
        $input = $request->all();
        
        // 2. Access specific fields (both methods work)
        $enteredPin = $request->input('entered_pin');  // Recommended
        $userId = $request->user_id; 

        // 3. Validate the request
        $validator = Validator::make($request->all(), [
            'entered_pin' => 'required|digits:4',
            'user_id' => 'required|numeric'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ]);
        }

        if ($request->user()->id == $userId) {
            // Compare the entered PIN with the stored hashed PIN
            if (Hash::check($request->entered_pin, $user->transaction_pin)) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'PIN verification successful',
                    'pin_match' => true,
                ]);
            }
            return response()->json([
                'status' => 'error',
                'message' => 'The entered PIN is incorrect',
                'pin_match' => false,
            ]); 
            
        }else{
            return response()->json([
                'status' => 'error',
                'message' => 'An unexpected error occurred',
                // 'userId' => $user->transaction_pin,
                // 'id' => $request->user_id ,
                // 'entered_pin' => $request->entered_pin ,
            ]);
        }
            
    }
}
