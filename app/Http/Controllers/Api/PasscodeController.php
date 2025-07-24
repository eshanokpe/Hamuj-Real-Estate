<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Cache;
use Carbon\Carbon;
use App\Models\User;
use App\Services\OtpService;

class PasscodeController extends Controller
{
    protected $otpService;
    protected $maxAttempts = 3;

    public function __construct(OtpService $otpService)
    {
        $this->otpService = $otpService;
        $this->middleware('auth');
    }
    /**
     * Check passcode status
     */
    public function checkStatus() 
    { 
        $user = Auth::user();
        
        return response()->json([
            'status' => 'success',
            'isPasscodeSet' => !empty($user->app_passcode),
        ]);
    }

    /**
     * Set new passcode
     */
    public function setPasscode(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'passcode' => 'required|digits:4',
            'passcode_confirmation' => 'sometimes|required|same:passcode',
        ]);  

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $user = Auth::user();
        $user->app_passcode = Hash::make($request->passcode);
        $user->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Passcode set successfully',
        ]);
    }

    /**
     * Verify passcode
     */
    public function verifyPasscode(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'passcode' => 'required|digits:4',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $user = Auth::user();

        if (!Hash::check($request->passcode, $user->app_passcode)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid passcode',
            ], 401);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Passcode verified',
        ]);
    } 

    /**
     * Remove passcode
     */
    public function removePasscode(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'passcode' => 'required|digits:4',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $user = Auth::user();

        if (!Hash::check($request->passcode, $user->app_passcode)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid passcode',
            ], 401);
        }

        $user->app_passcode = null;
        $user->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Passcode removed successfully',
        ]);
    }

    public function verifyPassCodeOTP(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'passcode' => 'required|digits:4',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $user = Auth::user();

        if (!Hash::check($request->passcode, $user->app_passcode)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid passcode',
            ], 401);
        }

        // Generate and send OTP
        $otpData = $this->otpService->generateAndSendOtp($user);
        
        return response()->json([
            'status' => 'success',
            'message' => 'Passcode verified',
            'otp_data' => [
                'expires_at' => Carbon::createFromTimestamp($otpData['expires_at'])->toDateTimeString(),
                'delivery_method' => $otpData['delivery_method'],
                'identifier' => $otpData['identifier'] 
            ],
        ]);
    } 

    public function NoPassCodeOTP(Request $request, $id)
    {
        
        $user = User::findOrFail($id);

        // Generate and send OTP
        $otpData = $this->otpService->generateAndSendOtp($user);
        
        return response()->json([
            'status' => 'success',
            'message' => 'Passcode verified',
            'otp_data' => [
                'expires_at' => Carbon::createFromTimestamp($otpData['expires_at'])->toDateTimeString(),
                'delivery_method' => $otpData['delivery_method'],
                'identifier' => $otpData['identifier'] 
            ],
        ]);
    } 

    public function confirmPassCodeOTP(Request $request)
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
                    'delivery_method' => $otpData['delivery_method'],
                    'identifier' => $otpData['identifier'] 
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

    public function changePasscode(Request $request, $id)
    {
        // Validate the input
        $request->validate([
            'old_passcode' => 'required',
            'new_passcode' => 'required|min:4|confirmed', 
        ]);

        $user = Auth::user();

        // Check if old password is correct
        if (!Hash::check($request->old_passcode, $user->app_passcode)) {
            if ($request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'The old passcode is incorrect.',
                ], 400); 
            } else {
                return back()->withErrors(['old_passcode' => 'The old passcode is incorrect.']);
            }
        }

        // Update the password
        $user->app_passcode = Hash::make($request->new_passcode);
        $user->save();
        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Passcode changed successfully. For security reasons, please log in again.',
            ], 200);
        } else {
            return back()->with('success', 'Passcode changed successfully. For security reasons, please log in again.');
        }
    }

}