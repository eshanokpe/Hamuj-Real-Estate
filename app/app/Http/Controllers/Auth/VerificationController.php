<?php

namespace App\Http\Controllers\Auth;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\VerifiesEmails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Models\OtpVerification;

class VerificationController extends Controller
{ 
    /*
    |--------------------------------------------------------------------------
    | Email Verification Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling email verification for any
    | user that recently registered with the application. Emails may also
    | be re-sent if the user didn't receive the original email message.
    |
    */

    use VerifiesEmails;

    /**
     * Where to redirect users after verification.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
        $this->middleware('signed')->only('verify');
        $this->middleware('throttle:6,1')->only('verify', 'resend');
    }
  
    public function verify($id, $hash)
    {
        $user = User::findOrFail($id);
        if (sha1($user->email) !== $hash) {
            return redirect('/')->with('error', 'Invalid verification link.');
        }
        $user->markEmailAsVerified();
        return redirect()->route('login')->with('success', '🎉 Congratulations, ! You have successfully registered.');
    } 

    public function notice(Request $request, $user_id)
    {

        return view('auth.verify-otp', [
            'email' => session('email'),
            'phone' => session('phone'),
            'user_id' => $user_id ? decrypt($user_id) : null,
        ]);
    }

    public function verifyOtp(Request $request)
    {
        // dd($request->all());
        // Validate input
        $validated = $request->validate([
            'otp' => 'required|digits:6',
            'user_id' => 'required|exists:users,id'
        ]);

        // Find user and stored OTP
        $user = User::findOrFail($validated['user_id']);
        $storedOtp = OtpVerification::where('user_id', $user->id)->first();

        // Check if OTP exists
        if (!$storedOtp) {
            return back()->withErrors(['otp' => 'OTP expired or not found.']);
        }

        // Check if OTP matches
        if ($validated['otp'] !== $storedOtp->otp) {
            return back()->withErrors(['otp' => 'Invalid OTP code.']);
        }

        // Check if OTP is expired (optional)
        if ($storedOtp->expires_at && now()->gt($storedOtp->expires_at)) {
            return back()->withErrors(['otp' => 'OTP has expired.']);
        }

        // Mark user as verified
        $user->update([
            'otp_verified_at' => now(),
        ]);

        return redirect()->route('login')->with('success', 'OTP verified successfully!');
    }
}
