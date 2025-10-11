<?php


namespace App\Http\Controllers\Auth; 

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Model\Admin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request; 
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;


class AdminLoginController extends Controller
{   
   
    public function showLogin()
    {
        return view('admin.auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);
        $credentials = $request->only('email', 'password');
 
        if (Auth::guard('admin')->attempt($credentials)) {
            return redirect()->route('admin.index');
        }
      
        return redirect()->back()->with('error', '❌ Incorrect email or password. Please try again.');
    }

    public function showChangePasswordForm()
    {
        return view('admin.auth.change_password');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|confirmed|min:5',
        ]);

        $admin = Auth::guard('admin')->user();

        // Check if the current password matches the one in the database
        if (!Hash::check($request->current_password, $admin->password)) {
            throw ValidationException::withMessages([
                'current_password' => ['The current password is incorrect.'],
            ]);
        }

        // Update admin's password
        $admin->password = Hash::make($request->password);
        $admin->save();

        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('admin.login')->with('success', 'Password updated successfully. Please login');
    }

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }

    
}