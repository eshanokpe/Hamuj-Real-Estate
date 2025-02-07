<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Hash;

class SecurityController extends Controller
{
    public function __construct() 
    {
        $this->middleware('auth');
    }

    public function index(){
        $data['user'] = Auth::user();
        $data['referralsMade'] = $data['user']->referralsMade()->with('user', 'referrer')->take(6)->get();
        $data['hasMoreReferrals'] = $data['referralsMade']->count() > 6;
        return view('user.pages.security.index', $data); 
    }

    public function changePassword(){
        $data['user'] = Auth::user();
        $data['referralsMade'] = $data['user']->referralsMade()->with('user', 'referrer')->take(6)->get();
        $data['hasMoreReferrals'] = $data['referralsMade']->count() > 6;
        return view('user.pages.security.changePassword', $data); 
    }

    public function changePasswordPost(Request $request, $id)
    {
        // Validate the input
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|min:8|confirmed', // Automatically checks for 'new_password_confirmation'
        ]);

        $user = Auth::user();

        // Check if old password is correct
        if (!Hash::check($request->old_password, $user->password)) {
            return back()->withErrors(['old_password' => 'The old password is incorrect.']);
        }

        // Update the password
        $user->password = Hash::make($request->new_password);
        $user->save();

        return back()->with('success', 'Password changed successfully.');
    }

    public function transactionPin(){
        $data['user'] = Auth::user();
        $data['referralsMade'] = $data['user']->referralsMade()->with('user', 'referrer')->take(6)->get();
        $data['hasMoreReferrals'] = $data['referralsMade']->count() > 6;
        return view('user.pages.security.transactionPin', $data); 
    }

    public function createTransactionPin(Request $request, $id)
    {
        $request->validate([
            'old_pin' => 'nullable|min:4|max:4', 
            'new_pin' => 'required|min:4|max:4|confirmed', 
        ]);

        $user = Auth::user();

        if ($user->transaction_pin) {
            if (!Hash::check($request->old_pin, $user->transaction_pin)) {
                return back()->withErrors(['old_pin' => 'The old PIN is incorrect.']);
            }
        } else {
            if ($request->old_pin) {
                return back()->withErrors(['old_pin' => 'You do not have an old PIN set. Leave this field blank.']);
            }
        }

        $user->transaction_pin = Hash::make($request->new_pin);
        $user->save();

        return back()->with('success', 'Transaction PIN created/updated successfully.');
    }

}
