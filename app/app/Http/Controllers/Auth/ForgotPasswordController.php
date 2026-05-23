<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Models\User;

class ForgotPasswordController extends Controller
{
    /**
     * Send password reset link to email
     * POST /api/auth/forgot-password
     */
    public function sendResetLink(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Please provide a valid email address.',
                'errors' => $validator->errors()
            ], 422);
        }

        // Always return success even if email not found (security best practice)
        // This prevents email enumeration attacks
        $user = User::where('email', strtolower(trim($request->email)))->first();

        if (!$user) {
            return response()->json([
                'success' => true,
                'message' => 'If an account exists with this email, you will receive a reset link shortly.',
            ], 200);
        }

        // Delete any existing reset tokens for this user
        DB::table('password_reset_tokens')
            ->where('email', $user->email)
            ->delete();

        // Generate a secure token
        $token = Str::random(64);

        // Store token with expiry (60 minutes)
        DB::table('password_reset_tokens')->insert([
            'email'      => $user->email,
            'token'      => hash('sha256', $token),
            'created_at' => Carbon::now(),
        ]);

        // Send email with deep link
        $user->sendPasswordResetDeepLinkNotification($token);

        return response()->json([
            'success' => true,
            'message' => 'If an account exists with this email, you will receive a reset link shortly.',
        ], 200);
    }

    /**
     * Validate reset token (called before showing reset form)
     * GET /api/auth/reset-password/validate/{token}?email={email}
     */
    public function validateToken(Request $request, $token)
    {
        $email = $request->query('email');

        if (!$email || !$token) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid reset link.',
            ], 400);
        }

        $record = DB::table('password_reset_tokens')
            ->where('email', $email)
            ->first();

        if (!$record) {
            return response()->json([
                'success' => false,
                'message' => 'This password reset link is invalid.',
            ], 400);
        }

        // Check expiry (60 minutes)
        if (Carbon::parse($record->created_at)->addMinutes(60)->isPast()) {
            DB::table('password_reset_tokens')
                ->where('email', $email)
                ->delete();

            return response()->json([
                'success' => false,
                'message' => 'This password reset link has expired. Please request a new one.',
            ], 400);
        }

        // Verify token hash
        if (!hash_equals($record->token, hash('sha256', $token))) {
            return response()->json([
                'success' => false,
                'message' => 'This password reset link is invalid.',
            ], 400);
        }

        return response()->json([
            'success' => true,
            'message' => 'Token is valid.',
            'email'   => $email,
        ], 200);
    }
}