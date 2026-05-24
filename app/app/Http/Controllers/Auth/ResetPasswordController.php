<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use App\Models\User;

class ResetPasswordController extends Controller
{
    /**
     * Reset password with token
     * POST /api/auth/reset-password
     */
    public function reset(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'token'                 => 'required|string',
            'email'                 => 'required|email',
            'password'              => 'required|min:8|confirmed',
            'password_confirmation' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed.',
                'errors'  => $validator->errors()
            ], 422);
        }

        // Find token record
        $record = DB::table('password_reset_tokens')
            ->where('email', strtolower(trim($request->email)))
            ->first();

        if (!$record) {
            return response()->json([
                'success' => false,
                'message' => 'This password reset link is invalid.',
            ], 400);
        }

        // Check expiry
        if (Carbon::parse($record->created_at)->addMinutes(60)->isPast()) {
            DB::table('password_reset_tokens')
                ->where('email', $request->email)
                ->delete();

            return response()->json([
                'success' => false,
                'message' => 'This password reset link has expired. Please request a new one.',
            ], 400);
        }

        // Verify token hash
        if (!hash_equals($record->token, hash('sha256', $request->token))) {
            return response()->json([
                'success' => false,
                'message' => 'This password reset link is invalid.',
            ], 400);
        }

        // Find user
        $user = User::where('email', strtolower(trim($request->email)))->first();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'No account found with this email.',
            ], 404);
        }

        // Update password
        $user->password = Hash::make($request->password);
        $user->save();

        // Delete used token
        DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->delete();
        // ✅ Store a short-lived token so Flutter can clear the passcode
        $clearToken = Str::random(64);
        Cache::put("password_reset_verified:{$clearToken}", [
            'user_id'    => $user->id,
            'reset_at'   => now()->timestamp,
        ], now()->addMinutes(5)); // 5 min — just enough for the app to call clear


        return response()->json([
            'success' => true,
            'message' => 'Password reset successfully.',
            'passcode_clear_token'   => $clearToken, // ✅ Flutter uses this
        ], 200);
    }

    /**
     * Handle deep link redirect from email
     * GET /reset-password/{token}?email={email}
     * This is a WEB route — redirects to Flutter app via deep link
     */
    public function redirectToApp(Request $request, $token)
    {
        $email = $request->query('email');

        if (!$email || !$token) {
            return view('auth.reset-password-error', [
                'message' => 'Invalid reset link.'
            ]);
        }

        // Validate token before redirecting
        $record = DB::table('password_reset_tokens')
            ->where('email', $email)
            ->first();

        if (!$record || Carbon::parse($record->created_at)->addMinutes(60)->isPast()) {
            return view('auth.reset-password-error', [
                'message' => 'This reset link has expired. Please request a new one.'
            ]);
        }

        if (!hash_equals($record->token, hash('sha256', $token))) {
            return view('auth.reset-password-error', [
                'message' => 'This reset link is invalid.'
            ]);
        }

        // ✅ Deep link — redirects to Flutter app
        // Format: dohmayn://reset-password?token={token}&email={email}
        $deepLink = "dohmayn://reset-password?token={$token}&email=" . urlencode($email);

        return view('auth.reset-password-redirect', [
            'deepLink' => $deepLink,
            'token'    => $token,
            'email'    => $email,
        ]);
    }
}