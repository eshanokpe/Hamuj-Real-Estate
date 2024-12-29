<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;

class ReferralController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth'); 
    }
 
    public function index(){
        $data['user'] = Auth::user();
        $user = Auth::user();
        $data['referralsMade'] = $user->referralsMade()->with('user', 'referrer')->get();
    
        return view('user.pages.referral.index', $data); 
    }
}
