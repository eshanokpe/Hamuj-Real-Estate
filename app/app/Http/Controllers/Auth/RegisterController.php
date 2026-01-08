<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Mail\VerificationEmail;
use App\Mail\WelcomeEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rules;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    /**
     * Where to redirect users after successful registration.
     */
    protected $redirectTo = '/registration/success';

    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Show the application registration form.
     */
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    /**
     * Handle a registration request for the application.
     */
    public function register(Request $request)
    {
        $validator = $this->validator($request->all());

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput($request->except('password', 'password_confirmation'))
                ->with('error', 'Please correct the errors below.');
        }

        $user = $this->create($request->all());

        // Handle tutor agreement if applicable
        if ($user->isTutor() && $request->boolean('tutor_agreement')) {
            $user->acceptTutorAgreement();
        }

        // Send verification email
        $this->sendVerificationEmail($user);

        // Log registration event
        \Log::info('New user registered', [
            'user_id' => $user->id,
            'email' => $user->email,
            'role' => $user->role,
            'ip_address' => $request->ip(),
        ]);

        return redirect()->route('registration.success')
            ->with('success', 'Registration successful! Please check your email to verify your account.');
    }

    /**
     * Get a validator for an incoming registration request.
     */
    protected function validator(array $data): \Illuminate\Contracts\Validation\Validator
    {
        $rules = [
            'role' => ['required', 'string', Rule::in([User::ROLE_TUTOR, User::ROLE_LEARNER])],
            'name' => ['required', 'string', 'max:255', 'regex:/^[\pL\s\-\.]+$/u'],
            'email' => ['required', 'string', 'email:rfc,dns', 'max:255', 'unique:users'],
            'linkedin_url' => [
                'required', 
                'url', 
                'max:500',
                'regex:/^https?:\/\/(www\.)?linkedin\.com\/.+/i'
            ],
            'password' => [
                'required', 
                'confirmed', 
                Rules\Password::defaults()
                    ->min(8)
                    ->letters()
                    ->mixedCase()
                    ->numbers()
                    ->symbols()
            ],
        ];

        // Add tutor agreement validation only for tutors
        if (isset($data['role']) && $data['role'] === User::ROLE_TUTOR) {
            $rules['tutor_agreement'] = ['required', 'accepted'];
        } 

        $messages = [
            'name.regex' => 'Please enter a valid name (letters, spaces, hyphens, and dots only).',
            'email.email' => 'Please enter a valid email address.',
            'linkedin_url.regex' => 'Please enter a valid LinkedIn profile URL.',
            'password.confirmed' => 'The password confirmation does not match.',
            'tutor_agreement.accepted' => 'You must accept the Tutor Agreement to register as a tutor.',
        ];

        return Validator::make($data, $rules, $messages);
    }

    /**
     * Create a new user instance after a valid registration.
     */
    protected function create(array $data): User
    {
        return User::create([
            'name' => trim($data['name']),
            'email' => strtolower(trim($data['email'])),
            'linkedin_url' => $data['linkedin_url'],
            'password' => Hash::make($data['password']),
            'role' => $data['role'],
            'status' => User::STATUS_PENDING,
            'email_verification_token' => Str::random(60),
        ]);
    }

    /**
     * Send verification email to user.
     */
    protected function sendVerificationEmail(User $user): void
    {
        try {
            Mail::to($user->email)->send(new VerificationEmail($user));
        } catch (\Exception $e) {
            \Log::error('Failed to send verification email', [
                'user_id' => $user->id,
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Show registration success page.
     */
    public function showSuccessPage()
    {
        return view('auth.registration-success');
    }

    /**
     * Check if email already exists (for AJAX validation).
     */
    public function checkEmail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:users'
        ]);

        return response()->json([
            'valid' => !$validator->fails(),
            'message' => $validator->fails() ? 'This email is already registered.' : null
        ]);
    }
}