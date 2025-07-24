<?php

namespace App\Http\Controllers\User;
use Auth;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Exception; 
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
 
  
class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth'); 
    }

    
    public function index() { 
        $user = Auth::user();
        $user->load('virtualAccounts');
        
    
        if (request()->wantsJson()) {
            return response()->json([
                'status' => 'success',
                'message' => 'Profile retrieved successfully!',
                'user' => $user,
                'isPasscodeSet' => !empty($user->app_passcode),
            ], 200);
        }
    
        return view('user.pages.profile.index', ['user' => $user]);
    }
    
    public function setPasscode(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'passcode' => 'required|digits:4|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }
        
        $user = Auth::user();
        $user->app_passcode = Hash::make($request->passcode);
        $user->save();
        
        return response()->json([
            'success' => true,
            'message' => 'Passcode set successfully',
        ]);
    }

    public function verifyPasscode(Request $request)
    {
        $request->validate([
            'passcode' => 'required|digits:4',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }
        $user = Auth::user();
        
        if (!Hash::check($request->passcode, $user->app_passcode)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid passcode',
            ], 401);
        }
        
        return response()->json([
            'success' => true,
            'message' => 'Passcode verified',
        ]);
    }

    public function removePasscode(Request $request)
    {
        $request->validate([
            'passcode' => 'required|digits:4',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }
        
        $user = Auth::user();
        
        if (!Hash::check($request->passcode, $user->app_passcode)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid passcode',
            ], 401);
        }
        
        $user->app_passcode = null;
        $user->save();
        
        return response()->json([
            'success' => true,
            'message' => 'Passcode removed successfully',
        ]);
    }
        

    public function edit($id)
    {
        $data['user'] = User::findOrFail(decrypt($id));
        return view('user.pages.profile.edit',$data); 
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
   
   
    public function update(Request $request)
    {
        try {
            $request->validate([
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'phone' => 'nullable|string|max:15',
                'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif',
                'referral_code' => 'nullable|string|exists:users,referral_code',
                'bvn' => 'nullable|string',
                'nin' => 'nullable|string',
                'dob' => [
                    'nullable',
                    'date',
                    'before:' . now()->subYears(18)->format('Y-m-d'),
                ]
            ], [
                'dob.before' => 'You must be at least 18 years old to update.',
            ]);

            $user = Auth::user();

            // Update basic info
            $user->first_name = $request->first_name;
            $user->last_name = $request->last_name;
            $user->phone = $request->phone;
            $user->bvn = $request->bvn;
            $user->nin = $request->nin;

            if ($request->filled('dob')) {
                $user->dob = Carbon::parse($request->dob)->format('Y-m-d');
            }

            // Handle profile image upload
            if ($request->hasFile('profile_image')) {
                $image = $request->file('profile_image');
                $imageName = time() . '.' . $image->extension();
                $destinationPath = public_path('assets/profile/');

                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0755, true); 
                }

                $image->move($destinationPath, $imageName);
                $user->profile_image = 'assets/profile/' . $imageName;
            }

            $user->save(); // Save all changes at once

            if ($request->wantsJson()) {
                $user = Auth::user();
                $user->load('virtualAccounts');
                return response()->json([
                    'status' => 'success',
                    'message' => 'Profile updated successfully!',
                    'user' => $user,
                ], 200);
            }

            return redirect()->back()->with('success', 'Profile updated successfully!');
        } catch (\Exception $e) {  // Fixed Exception handling
            if ($request->wantsJson()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Something went wrong! ' . $e->getMessage(),
                ], 500);
            }
            return redirect()->back()->with('error', 'Something went wrong! ' . $e->getMessage());
        }
    }

    
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function verifyToken(Request $request)
    {
        $user = Auth::user();
        
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User not authenticated',
            ], 401);
        }
        
        return response()->json([
            'success' => true,
            'message' => 'Token is valid',
            'user' => $user,
        ]);
    }
}
