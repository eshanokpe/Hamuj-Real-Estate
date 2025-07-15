<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
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

    public function verifyPasscodeOTP(Request $request)
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

    
}