<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\KycDetail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Auth;

class UserIdentityController extends Controller
{
   public function showForm()
    {
        return view('user.pages.identity_verification.index');
    }
    
    public function submitDetails(Request $request)
    {
        $request->validate([
            'bvn' => 'required|digits:11',
            'nin' => 'required|digits:11',
        ]);
        
        $user = Auth::user();
        
        try {
            // Here you would typically call verification APIs
            // For now, we'll just store them (in production, encrypt these!)
            
            $user->bvn = $request->bvn;
            $user->nin = $request->nin;
            $user->identity_verified_at = now();
            $user->save();
            
            return back()->with([
                'verification_status' => 'success',
                'verification_message' => 'Identity verification submitted successfully!'
            ]);
            
        } catch (\Exception $e) {
            return back()->with([
                'verification_status' => 'error',
                'verification_message' => 'Verification failed: ' . $e->getMessage()
            ]);
        }
    }
  
    /**
     * Update BVN in database
     */
    public function updateBvn(Request $request)
    {
        $request->validate([
            'bvn' => 'required|digits:11|unique:users,bvn,'.$request->user()->id
        ]); 

        try {
            $user = $request->user();
            $user->bvn = $request->bvn;
            $user->bvn_verified_at = now();
            $user->save();

            return response()->json([
                'success' => true,
                'message' => 'BVN updated successfully'
            ]);

        } catch (\Exception $e) {
            Log::error('BVN Update Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to update BVN: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update NIN in database
     */
    public function updateNin(Request $request)
    {
        $request->validate([
            'nin' => 'required|digits:11|unique:users,nin,'.$request->user()->id
        ]);

        try {
            $user = $request->user();
            $user->nin = $request->nin;
            $user->nin_verified_at = now();
            $user->save();

            return response()->json([
                'success' => true,
                'message' => 'NIN updated successfully'
            ]);

        } catch (\Exception $e) {
            Log::error('NIN Update Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to update NIN: ' . $e->getMessage()
            ], 500);
        }
    }

}