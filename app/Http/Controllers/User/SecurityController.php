<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
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
            'new_password' => 'required|min:8|confirmed', 
        ]);

        $user = Auth::user();

        // Check if old password is correct
        if (!Hash::check($request->old_password, $user->password)) {
            if ($request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'The old password is incorrect.',
                ], 400); 
            } else {
                return back()->withErrors(['old_password' => 'The old password is incorrect.']);
            }
        }

        // Update the password
        $user->password = Hash::make($request->new_password);
        $user->save();
        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Password changed successfully. For security reasons, please log in again.',
            ], 200);
        } else {
            return back()->with('success', 'Password changed successfully. For security reasons, please log in again.');
        }
    }

    public function transactionPin(){
        $data['user'] = Auth::user();
        $data['referralsMade'] = $data['user']->referralsMade()->with('user', 'referrer')->take(6)->get();
        $data['hasMoreReferrals'] = $data['referralsMade']->count() > 6;
        return view('user.pages.security.transactionPin', $data); 
    }

    
    public function createTransactionPin(Request $request, $id)
    {
        $user = Auth::user();

        $rules = [
            'new_pin' => 'required|min:4|max:4', // New PIN is always required
            'new_pin_confirmation' => 'required|min:4|max:4|same:new_pin', // Ensure confirmation matches
        ];

        if ($user->transaction_pin) {
            $rules['old_pin'] = 'required|min:4|max:4'; // Old PIN is required
        }
       
        // $request->validate($rules);
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 400);
        }

        if ($user->transaction_pin) {
            if (!Hash::check($request->old_pin, $user->transaction_pin)) {
                return $this->sendErrorResponse('The old PIN is incorrect.', 400, $request);
            }
        }

        $user->transaction_pin = Hash::make($request->new_pin);
        $user->save();

        return $this->sendSuccessResponse('Transaction PIN created/updated successfully.', 200, $request);
    }

    private function sendErrorResponse($message, $statusCode, $request)
    {
        if ($request->wantsJson()) {
            return response()->json([
                'success' => false,
                'message' => $message,
            ], $statusCode);
        } else {
            return back()->withErrors(['error' => $message]);
        }
    }

    // Helper function to send success responses
    private function sendSuccessResponse($message, $statusCode, $request)
    {
        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => $message,
            ], $statusCode);
        } else {
            return back()->with('success', $message);
        }
    }

    public function getTransactionPin(Request $request, $userId)
    {
        try {
            // Ensure the authenticated user is accessing their own PIN
            if ($request->user()->id != $userId) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Unauthorized',
                ], 403);
            }

            // Fetch the user
            $user = $request->user();

            // Check if the user has a transaction PIN
            if (!$user->transaction_pin) {
                return response()->json([
                    'status' => 'success',
                    'data' => [
                        'has_pin' => false,
                        'message' => 'No transaction PIN set for this user',
                    ],
                ]); 
            }

            // Validate the request
            $validator = Validator::make($request->all(), [
                'entered_pin' => 'required|min:4|max:4', // Ensure the entered PIN is 4 digits
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Validation failed',
                    'errors' => $validator->errors(),
                ], 400);
            }

            // Compare the entered PIN with the stored hashed PIN
            $enteredPin = $request->entered_pin;
            $storedPin = $user->transaction_pin;

            if (Hash::check($enteredPin, $storedPin)) {
                return response()->json([
                    'status' => 'success',
                    'data' => [
                        'pin_match' => true,
                        'message' => 'The entered PIN matches the stored PIN.',
                    ],
                ]);
            } else {
                return response()->json([
                    'status' => 'success',
                    'data' => [
                        'pin_match' => false,
                        'message' => 'The entered PIN does not match the stored PIN.',
                    ],
                ]);
            }
        } catch (\Exception $e) {
            // Log the error
            // Log::error('Error fetching or comparing transaction PIN: ' . $e->getMessage());

            // Return an error response
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to fetch or compare transaction PIN',
            ], 500);
        }
    }

}
