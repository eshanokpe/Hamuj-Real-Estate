<?php
namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Services\WalletService; 
use App\Models\Wallet;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\WalletController  as PayStackWalletController;

class WalletController extends Controller
{
    public function getBalance()
    {
        $walletBalance = (new WalletService())->getWalletBalance(); 
       
        return response()->json([
            'success' => true,
            'balance' => $walletBalance,
        ]);
    }

    public function deductBalance(Request $request)
    {
        // Validate the request
        $validator = Validator::make($request->all(), [
            'amount' => 'required|numeric|min:0.01',
        ]);
 
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid input',
                'errors' => $validator->errors(),
            ], 422);
        }

        // Get the authenticated user
        $user = Auth::user();

        // Find the user's wallet
        $wallet = Wallet::where('user_id', $user->id)->first();

        if (!$wallet) {
            return response()->json([
                'status' => 'error',
                'message' => 'Wallet not found',
            ], 404);
        }

        // Check if the wallet has sufficient balance
        if ($wallet->balance < $request->amount) {
            return response()->json([
                'status' => 'error',
                'message' => 'Insufficient wallet balance',
            ], 400);
        }

        // Deduct the amount from the wallet
        $wallet->balance -= $request->amount;
        $wallet->save();

        // Return the updated wallet balance
        return response()->json([
            'status' => 'success',
            'message' => 'Amount deducted successfully',
            'balance' => $wallet,
        ]);
    }

    public function getBank(PayStackWalletController $paystackWalletController, Request $request){
        $data['banks'] = $paystackWalletController->getBanks(); 
        if ($request->wantsJson() || $request->is('api/*')) {
            return response()->json([
                'banks' => $data['banks'],
            ]);
        }
    }

}