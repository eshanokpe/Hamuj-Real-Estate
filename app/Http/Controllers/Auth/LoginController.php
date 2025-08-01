<?php

namespace App\Http\Controllers\Auth;
use Cache;
use App\Models\UserActivity;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth; 
use Illuminate\Validation\ValidationException;
use App\Services\OtpService;
use App\Notifications\SmsOtpNotification;
use App\Notifications\EmailOtpNotification;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
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
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    public function login(Request $request)
    { 
        $this->validateLogin($request);

        $credentials = $this->credentials($request);
        
        // Attempt to log in with credentials
        if (Auth::attempt($credentials)) {
            $user = Auth::user(); 
            // Check if the user account is active
            if (!$user->active) {
                Auth::logout();
                if ($request->wantsJson()) {
                    return response()->json([
                        'message' => 'Account deactivated.',
                        'error' => 'Your account has been deactivated. Please contact support.',
                    ], 403);
                }

                return back()->withErrors([
                    'login_error' => 'Your account has been deactivated. Please contact support.',
                ])->onlyInput('email');
            }
            if (Auth::user()->hasVerifiedEmail()) {
                $user->update([ 
                    'last_login_at' => now(),
                    'last_login_ip' => $request->ip(),
                ]);
                Cache::put('user-is-online-' . $user->id, true, now()->addMinutes(5));

                $user->load('virtualAccounts');
                // Log user activity
                UserActivity::create([
                    'user_id' => $user->id,
                    'activity' => 'logged in',
                    'ip_address' => $request->ip(),
                ]);
                
                if ($request->wantsJson()) {
                    return response()->json([ 
                        'message' => 'Login successful',
                        'user' => $user, 
                        'token' => Auth::user()->createToken('dohmayn')->plainTextToken, // For API Token
                    ], 200);
                } 
                return redirect()->route('user.dashboard');
            }
            Auth::logout();
            return $this->sendFailedLoginResponse($request);
        }
        if ($request->wantsJson()) {
            return response()->json([
                'message' => 'Login failed',
                'error' => 'Invalid email or password.',
            ], 401);
        }
        return back()->withErrors([
            'login_error' => 'Invalid email or password.',
        ])->onlyInput('email'); 
    }

    
    protected function sendFailedLoginResponse(Request $request)
    {
        $user = Auth::getProvider()->retrieveByCredentials($this->credentials($request));
        if ($request->wantsJson()) {
            // For API response. 
            return response()->json([
                'message' => 'Login failed',
                'error' => 'Your account has not been verified. Please check your email or sms for the OTP code.',
                'user_id' => $user ? $user->id : null,
                'phone' => $user ? $user->phone : null,
            ], 401); // Unauthorized
        }

        // For web response, redirect to verify.otp with the email
         if ($user && !$user->hasVerifiedEmail()) {
             \Log::error('hasVerifiedEmail:');
            
            // Send email OTP
            try {
                $user->notify(new EmailOtpNotification($otps['otp']));
                \Log::info('Email OTP sent successfully to ' . $user->email);
            } catch (\Exception $e) {
                \Log::error('Email OTP sending failed: ' . $e->getMessage());
            }

            // Send SMS OTP (you'll need to implement your SMS service)
            try {
                $user->notify(new SmsOtpNotification($otps['otp']));
            } catch (\Exception $e) {
                \Log::error('SMS OTP sending failed: ' . $e->getMessage());
            }
            return redirect()->route('verification.notice', ['user_id' => encrypt($user->id)])
                ->with('email', $user->email);
        }
    

        throw ValidationException::withMessages([
            $this->username() => 'Your account has not been verified. Please check your email or sms for the OTP code.',
        ]);
    }

  

   

    public function logout(Request $request)
    {
        $user = Auth::user();
        Cache::forget('user-is-online-' . $user->id);
        $user->tokens()->delete();
        Auth::logout();
        UserActivity::create([
            'user_id' => $user->id,
            'activity' => 'logged out',
            'ip_address' => $request->ip(),
        ]);
        // Invalidate and regenerate session
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        if ($request->wantsJson()) {
            return response()->json(['message' => 'Logged out successfully.'], 200);
        }

        return redirect('user/login'); 
    }

}
