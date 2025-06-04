<?php

namespace App\Http\Controllers\User\Wallet;
use Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\WalletController  as PayStackWalletController;
use Illuminate\Support\Facades\Http;
use App\Models\Transaction;
use App\Models\WalletTransaction;
use Barryvdh\DomPDF\Facade\Pdf;


class WalletController extends Controller
{
   
   
    public function index()
    {
        $user = Auth::user();
        
        // Get wallet transactions
        $walletTransactions = WalletTransaction::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($item) {
                return $item->toArray();
            });

        $paymentTransactions = Transaction::where('user_id', $user->id)
            ->where('payment_method', 'dedicated_nuban')
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($item) {
                return $item->toArray();
            });

        $transactions = $walletTransactions->concat($paymentTransactions)
            ->sortByDesc('created_at')
            ->take(5)
            ->values();
        
        $data = [
            'user' => $user,
            'referralsMade' => $user->referralsMade()->with('user', 'referrer')->take(6)->get(),
            'hasMoreReferrals' => $user->referralsMade()->count() > 6,
            'transactions' => $transactions // Removed the array wrapper
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
       $user = Auth::user();
        
        // Get wallet transactions
        $walletTransactions = WalletTransaction::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($item) {
                return $item->toArray();
            });

        $paymentTransactions = Transaction::where('user_id', $user->id)
            ->where('payment_method', 'dedicated_nuban')
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($item) {
                return $item->toArray();
            });

        $transactions = $walletTransactions->concat($paymentTransactions)
            ->sortByDesc('created_at')
            ->take(10)
            ->values();
       
        
        $data = [
            'user' => $user,
            'referralsMade' => $user->referralsMade()->with('user', 'referrer')->take(6)->get(),
            'hasMoreReferrals' => $user->referralsMade()->count() > 6,
            'transactions' => $transactions
        ];
      
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

    public function show($id)
    {
        $data['user'] = Auth::user();

        $walletTransaction = WalletTransaction::where('id', decrypt($id))->first();

        $walletPaymentTransaction = Transaction::where('id', decrypt($id) )
            ->where('payment_method', 'dedicated_nuban')
            ->first();

         $data['transaction'] = collect([
            $walletTransaction,
            $walletPaymentTransaction
        ])->filter(); 

        $data['referralsMade'] = $data['user']->referralsMade()->with('user', 'referrer')->take(6)->get();
        $data['hasMoreReferrals'] = $data['user']->referralsMade()->count() > 6;

        return view('user.pages.wallet.show', $data);
    }



    public function download($id)
    {
        $transaction = WalletTransaction::find($id) ?? Transaction::findOrFail($id);
        
        $pdf = PDF::loadView('transactions.partials.receipt', compact('transaction'));
        
        return $pdf->download("receipt-{$transaction->reference}.pdf");
    }

    
}
