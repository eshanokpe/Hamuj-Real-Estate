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
   
    public function index(Request $request){
        $data['user'] = Auth::user();
        $user = Auth::user();
 
        $data['referralsMade'] = $user->referralsMade()->with('user', 'referrer', 'referred')->take(6)->get();
        $data['referralCount'] = $user->referralsMade()->count();  
        $data['hasMoreReferrals'] = $data['referralsMade']->count() > 6;  
        // dd($data['referralsMade']->commission_amount);

        if ($request->wantsJson() || $request->is('api/*')) {
            return response()->json([
                'referralsMade' => $data['referralsMade'],
                'referralCount' => $data['referralCount'],
                'hasMoreReferrals' => $data['hasMoreReferrals'],
            ]);
        }  
 
        return view('user.pages.referral.index', $data); 
    }
}
