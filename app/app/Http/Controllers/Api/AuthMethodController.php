<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class AuthMethodController extends Controller
{
    public function update(Request $request)
    {
        $validated = $request->validate([
            'auth_method' => [
                'required',
                'string',
                Rule::in([User::AUTH_METHOD_PIN, User::AUTH_METHOD_BIOMETRIC, User::AUTH_METHOD_BOTH])
            ],
            'biometric_types' => [
                'required_if:auth_method,biometric',
            ],
        ]);

        $user = auth()->user();

        // Validate PIN is set for biometric methods
        if (in_array($validated['auth_method'], [User::AUTH_METHOD_BIOMETRIC, User::AUTH_METHOD_BOTH])) {
            if (empty($user->app_passcode)) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Please set a PIN first before enabling biometric authentication'
                ], 422);
            }

            if (empty($validated['biometric_types'])) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'No supported biometric methods provided'
                ], 422);
            }
        }

        // Update user settings
        $user->auth_method = $validated['auth_method'];
        
        if ($validated['auth_method'] === User::AUTH_METHOD_PIN) {
            $user->biometric_types = null;
        } else {
            $user->biometric_types = $validated['biometric_types'];
        }

        $user->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Authentication method updated successfully',
            'data' => [
                'auth_method' => $user->auth_method,
                'biometric_types' => $user->biometric_types,
                'has_passcode' => !empty($user->app_passcode)
            ]
        ]);
    }

    public function checkBiometricSupport()
    {
        $user = Auth::user();
        
        return response()->json([
            'status' => 'success',
            'data' => [
                // 'biometric_available' => $user->canUseBiometric(),
                'supported_types' => $user->supportedBiometricTypes(),
                'is_configured' => $user->hasBiometricEnabled()
            ]
        ]);
    }


    public function show()
    {
        $user = Auth::user();
        
        return response()->json([
            'status' => 'success',
            'data' => $user->securitySettings()
        ]);
    }

     public function deactivateAccount(Request $request)
    {
        $request->validate([
            'user_id' => 'required|integer|exists:users,id',
            'reason' => 'required|string|max:255',
        ]);

        $user = User::find($request->user_id);

        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'User not found.',
            ], 404);
        }

        \Log::info("User {$user->id} deactivated account. Reason: " . $request->reason);

        $user->update([
            'active' => 0,
            'is_active' => 0,
            'deactivated_at' => now(),
            'deactivation_reason' => $request->reason,
        ]);

        // Revoke tokens
        $user->tokens()->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Account successfully deactivated.',
        ], 200);
    }

}