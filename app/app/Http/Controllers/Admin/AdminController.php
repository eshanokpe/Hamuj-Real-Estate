<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Admin;
use App\Models\User;
use App\Models\Blog;
use App\Models\Event;

class AdminController extends Controller
{
    /**
     * Show admin login form
     */
    public function login()
    {
        // If admin is already logged in, redirect to dashboard
        if (Auth::guard('admin')->check()) {
            return redirect()->route('admin.dashboard');
        }

        return view('admin.auth.login');
    }

    /**
     * Handle admin login request
     */
    public function authenticate(Request $request)
    {
        // Validation rules
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:6'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput($request->except('password'));
        }

        // Attempt to log the admin in using admin guard
        $credentials = $request->only('email', 'password');

        if (Auth::guard('admin')->attempt($credentials) ){
            $request->session()->regenerate();

            // SUCCESS: Redirect to admin dashboard
            return redirect()->route('admin.dashboard')
                ->with('success', 'Welcome to Admin Dashboard!');
        }

        // If authentication fails
        return redirect()->back()
            ->with('error', 'Invalid credentials. Please try again.')
            ->withInput($request->except('password'));
    }

    /**
     * Admin dashboard
     */
    public function dashboard()
    {
        // Get the authenticated admin
        $admin = Auth::guard('admin')->user();
        
        // You can fetch stats from both Admin and User models as needed
        $stats = [
            'total_admins' => Admin::count(),
            'total_users' => User::count(),
            'total_blogs' => Blog::count() ?? 0,
            'total_events' => Event::count() ?? 0,
            'admin_name' => $admin->name,
        ]; 

        return view('admin.dashboard', compact('stats'));
    } 

    /**
     * Admin logout
     */
    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login')
            ->with('success', 'You have been logged out successfully.');
    }
}