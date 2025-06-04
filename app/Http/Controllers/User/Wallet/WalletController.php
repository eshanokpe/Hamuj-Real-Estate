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
    public function indexx() {
        $user = Auth::user();
        
        $walletTransactions = WalletTransaction::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        // Get regular transactions where payment method is wallet
        $walletPaymentTransactions = Transaction::where('user_id', $user->id)
            ->where('payment_method', 'wallet')
            ->orderBy('created_at', 'desc')
            ->get();
    
        // Combine and sort all transactions
        $allTransactions = $walletTransactions->concat($walletPaymentTransactions)
            ->sortByDesc('created_at')
            ->first();
        $data = [
            'user' => $user,
            'referralsMade' => $user->referralsMade()->with('user', 'referrer')->take(6)->get(),
            'hasMoreReferrals' => $user->referralsMade()->count() > 6,
            'latestTransactions' => collect([$allTransactions])
        ]; 
        // dd($data['latestTransactions']);
        return view('user.pages.wallet.index', $data); 
    }
   
    public function index() {
        $user = Auth::user();
        
        // Get wallet transactions
        $walletTransactions = WalletTransaction::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        // Get regular transactions where payment method is wallet
        $walletPaymentTransactions = Transaction::where('user_id', $user->id)
            ->where('payment_method', 'dedicated_nuban')
            ->orderBy('created_at', 'desc')
            ->get();

        // Combine and get the latest transaction only
        $latestTransaction = $walletTransactions
            ->concat($walletPaymentTransactions)
            ->sortByDesc('created_at')
            ->first();

        $data = [
            'user' => $user,
            'referralsMade' => $user->referralsMade()->with('user', 'referrer')->take(6)->get(),
            'hasMoreReferrals' => $user->referralsMade()->count() > 6,
            'latestTransactions' => $latestTransaction
        ]; 
        dd($data['latestTransactions']);

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
    
        $data = [
            'user' => $user,
            'referralsMade' => $user->referralsMade()->with('user', 'referrer')->take(6)->get(),
            'hasMoreReferrals' => $user->referralsMade()->count() > 6,
            'transactions' => WalletTransaction::where('user_id', $user->id)
                ->orderBy('created_at', 'desc')
                ->limit(10) // Increased to show more transactions
                ->get()
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
        // Try to find in WalletTransactions first

        // $data['transaction'] = WalletTransaction::find($id);
        
        // // If not found, try in Transactions
        // if (!$data['transaction'] ) {
        //     $transaction = Transaction::findOrFail($id);
        // }
         // Get wallet transactions
        $walletTransactions = WalletTransaction::where('id', $id)
            ->orderBy('created_at', 'desc')
            ->get();
            
        // Get regular transactions where payment method is wallet
        $walletPaymentTransactions = Transaction::where('id', $id)
            ->where('payment_method', 'wallet')
            ->orderBy('created_at', 'desc')
            ->get();
    
        // Combine and sort all transactions
        $data['transaction'] = $walletTransactions->concat($walletPaymentTransactions)
            ->sortByDesc('created_at')
            ->take(15);
        
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
