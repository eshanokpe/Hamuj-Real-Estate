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
            'biometric_types' => 'nullable|array',
            'biometric_types.*' => 'string|in:'.implode(',', [
                User::BIOMETRIC_FACE, 
                User::BIOMETRIC_FINGERPRINT,
                User::BIOMETRIC_IRIS
            ])
        ]);

        $user = Auth::user();
        
        if (in_array($validated['auth_method'], [User::AUTH_METHOD_BIOMETRIC, User::AUTH_METHOD_BOTH])) {
            // Validate PIN is set
            if (empty($user->app_passcode)) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Please set a PIN first before enabling biometric authentication'
                ], 422);
            }

            // Validate biometric types are provided
            if (empty($validated['biometric_types'])) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'No supported biometric methods provided'
                ], 422);
            }

            // Enable biometric
            $user->enableBiometric($validated['biometric_types']);
        } else {
            // Disable biometric if switching to PIN-only
            $user->disableBiometric();
        }

        $user->auth_method = $validated['auth_method'];
        $user->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Authentication method updated successfully',
            'data' => $user->securitySettings()
        ]);
    }

    public function checkBiometricSupport()
    {
        $user = Auth::user();
        
        return response()->json([
            'status' => 'success',
            'data' => [
                'biometric_available' => $user->canUseBiometric(),
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
}