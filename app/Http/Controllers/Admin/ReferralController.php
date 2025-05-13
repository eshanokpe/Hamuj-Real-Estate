<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ReferralLog;
use Illuminate\Support\Facades\Log;

class ReferralController extends Controller
{
    public function index(){
        $referrals = ReferralLog::latest()->paginate(20);
        return view('admin.home.referral.index', compact('referrals'));
    }

    public function edit($id)
    {
        $referral = ReferralLog::findOrFail(decrypt($id));
        return view('admin.home.referral.show', compact('referral'));
    }


    public function update(Request $request, $id)
    {
       
            $validated = $request->validate([
                'commission_paid' => 'required',
            ]);

            //$user = User::findOrFail($id);
            $referral = ReferralLog::findOrFail(decrypt($id));


            $updateData = [
                
                'commission_paid' => $request->commission_paid,
            ];

            $referral->update($updateData);

            return redirect()->route('admin.referral')->with('success', 'Refferral Log updated successfully.');

        
    }


}
