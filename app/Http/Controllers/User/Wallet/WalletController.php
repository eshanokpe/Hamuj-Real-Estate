<?php

namespace App\Http\Controllers\User\Wallet;
use Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\WalletController  as PayStackWalletController;
use Illuminate\Support\Facades\Http;
use App\Models\WalletTransaction;


class WalletController extends Controller
{
    public function index(){  
        $user = Auth::user();
        $data = [
            'user' => $user,
            'referralsMade' => $user->referralsMade()->with('user', 'referrer')->take(6)->get(),
            'hasMoreReferrals' => $user->referralsMade()->count() > 6,
            'latestTransactions' => WalletTransaction::where('user_id', $user->id)
                ->select([
                    'id',
                    'type',
                    'amount',
                    'status',
                    'created_at',
                    'reason',
                    'metadata'
                ])
                ->orderBy('created_at', 'desc')
                ->limit(5)
                ->get()
        ];


        return view('user.pages.wallet.index', $data); 
    }

    public function topUp(){ 
        $data['user'] = Auth::user();
        $data['referralsMade'] = $data['user']->referralsMade()->with('user', 'referrer')->take(6)->get();
        $data['hasMoreReferrals'] = $data['referralsMade']->count() > 6;
        return view('user.pages.wallet.topUp.index', $data); 
    }

   
    public function withDraw(PayStackWalletController $paystackWalletController){ 

        $data['banks'] = $paystackWalletController->getBanks(); 
        // dd($data['banks']);

        $data['user'] = Auth::user();
        $data['referralsMade'] = $data['user']->referralsMade()->with('user', 'referrer')->take(6)->get();
        $data['hasMoreReferrals'] = $data['referralsMade']->count() > 6;

       

        return view('user.pages.wallet.withDraw.index', [ 
            'banks' => $data['banks'],
            'user' => $data['user'],
            'referralsMade' => $data['referralsMade'],
            'hasMoreReferrals' => $data['hasMoreReferrals'],
        ]);
    }

    public function verifyAccount(Request $request, PayStackWalletController $paystackWalletController)
    {
        $validated = $request->validate([
            'account_number' => 'required|string',
            'bank_code' => 'required|string',
        ]);

        // Your verification logic
        return response()->json(['account_name' => $validated['bank_code'] ]); // Example
    }
 

    public function paymentHistory(){
        $data['user'] = Auth::user();
        $data['referralsMade'] = $data['user']->referralsMade()->with('user', 'referrer')->take(6)->get();
        $data['hasMoreReferrals'] = $data['referralsMade']->count() > 6;
      
        return view('user.pages.wallet.payment.history', $data);
    }

    public function resolveAccount(Request $request) 
    {
        $response = Http::withToken(env('PAYSTACK_SECRET_KEY'))
            ->get('https://api.paystack.co/bank/resolve', [
                'account_number' => $request->account_number,
                'bank_code' => $request->bank_code,
            ]);
    
        if ($response->successful()) {
            return response()->json([
                'status' => 'success',
                'data' => $response['data'],
            ]);
        }
    
        return response()->json(['status' => 'error', 'message' => 'Unable to resolve account.']);
    }

    
}
