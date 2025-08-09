<?php

namespace App\Http\Controllers\User\Wallet;
use Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\WalletController  as PayStackWalletController;
use Illuminate\Support\Facades\Http;
use DB;

class ExchangeController extends Controller
{
    public function index($fromCurrency){  
        // dd($fromCurrency);
        $user = Auth::user();
        $referralsMade = $user->referralsMade()->with('user', 'referrer')->take(6)->get();
        $hasMoreReferrals = $referralsMade->count() > 6;

        $user = Auth::user();
        $wallet = $user->wallet;
        
        // Validate the from currency
        $validCurrencies = ['gbp', 'ngn']; // Add other currencies as needed
        if (!in_array(strtolower($fromCurrency), $validCurrencies)) {
            abort(404);
        }
        
        // Get available Paystack accounts
        $paystackAccounts = $user->paystackAccounts()->get();
        
        // Get exchange rates from config
        $exchangeRates = [
            'gbp_to_ngn' => config('services.exchange.gbp_to_ngn'),
            'ngn_to_gbp' => 1 / config('services.exchange.gbp_to_ngn')
        ];


        // Calculate the exchange rate
        // return view('user.pages.wallet.exchange.index', $data); 
        return view('user.pages.wallet.exchange.index', [
            'fromCurrency' => strtoupper($fromCurrency),
            'availableBalance' => $fromCurrency === 'gbp' ? $wallet->gbp_balance : $wallet->balance,
            'paystackAccounts' => $paystackAccounts,
            'user' => $user,
            'referralsMade' => $referralsMade,
            'hasMoreReferrals' => $hasMoreReferrals,
            'exchangeRates' => $exchangeRates
        ]);
    }

    public function exchangeNgnToGbp(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:100|max:10000000'
        ]);

        $user = Auth::user();

        // Get MOST RECENT exchange within time window
        $recentExchange = $user->transactions()
            ->where('transaction_type', 'exchange_ngn_to_gbp')
            ->where('status', 'completed') // Only check completed transactions
            ->orderBy('created_at', 'desc') // Get most recent first
            ->first();

        // Only block if found AND within time window
        if ($recentExchange && $recentExchange->created_at > now()->subMinutes(5)) {
            return view('user.pages.wallet.exchange.success', [
                'success' => false,
                'message' => 'You recently performed this exchange'
            ]);
        }

        $amount = $request->amount;
        $exchangeRate = config('services.exchange.gbp_to_ngn');
        $gbpAmount = $amount / $exchangeRate;

        if ($user->wallet->balance < $amount) {
            return response()->json([
                'success' => false,
                'message' => 'Insufficient NGN balance',
                'required' => $amount,
                'available' => $user->wallet->balance ?? 0
            ], 400);
        }

        DB::beginTransaction();
        try {
            if (isset($user->wallet->balance)) {
                $user->wallet->decrement('balance', $amount);
            }

            $user->wallet->increment('gbp_balance', $gbpAmount);

            $transaction = $user->transactions()->create([
                'transaction_type' => 'exchange_ngn_to_gbp',
                'amount' => $amount,
                'currency' => 'NGN',
                'status' => 'completed',
                'description' => 'NGN to GBP Exchange',
                'metadata' => [
                    'exchange_rate' => $exchangeRate,
                    'gbp_amount' => $gbpAmount,
                    'fee' => 0
                ]
            ]);

            DB::commit();

            $formattedNgnAmount = number_format($amount, 2);
            $formattedGbpAmount = number_format($gbpAmount, 2);

            return view('user.pages.wallet.exchange.success', [
                'success' => true,
                'message' => 'You\'ve exchanged ₦'.$formattedNgnAmount. ' to £' .$formattedGbpAmount,
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            report($e);
            
            return response()->json([
                'success' => false,
                'message' => 'Exchange failed: '.$e->getMessage()
            ], 500);
        }
    }
    

    public function exchangeGbpToNgn(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1|max:10000'
        ]);

        $user = $request->user();
        $wallet = $user->wallet;
        $amount = $request->amount;
        $exchangeRate = config('services.exchange.gbp_to_ngn');
        $ngnAmount = $amount * $exchangeRate;

        // Check for duplicate transaction within last 1 minute
        $recentExchange = $user->transactions()
            ->where('transaction_type', 'exchange_gbp_to_ngn')
            ->where('status', 'completed')
            ->where('created_at', '>', now()->subMinute()) // 1-minute cooldown
            ->orderBy('created_at', 'desc')
            ->first();
            
        if ($recentExchange) {
            return view('user.pages.wallet.exchange.success', [
                'success' => false,
                'message' => 'Please wait at least 1 minute before performing another exchange.'
            ]);
        }

        // Rest of the method remains the same...
        if ($wallet->gbp_balance < $amount) {
            return response()->json([
                'success' => false,
                'message' => 'Insufficient GBP balance. You need £'.$amount.' but only have £'.$wallet->gbp_balance
            ], 400);
        }

        DB::beginTransaction();
        try {
            $wallet->decrement('gbp_balance', $amount);
            $wallet->increment('balance', $ngnAmount);

            $transaction = $user->transactions()->create([
                'transaction_type' => 'exchange_gbp_to_ngn',
                'amount' => $amount,
                'currency' => 'GBP',
                'status' => 'completed',
                'description' => 'GBP to NGN Exchange',
                'metadata' => [
                    'exchange_rate' => $exchangeRate,
                    'ngn_amount' => $ngnAmount
                ]
            ]);

            DB::commit();

            return view('user.pages.wallet.exchange.success', [
                'success' => true,
                'transaction_id' => $transaction->id,
                'gbp_amount' => $amount,
                'ngn_amount' => $ngnAmount,
                'message' => 'Exchange successful! ₦'.number_format($ngnAmount, 2).' has been added to your NGN balance'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            report($e);
            
            return view('user.pages.wallet.exchange.success', [
                'success' => false,
                'message' => 'Exchange failed: '.$e->getMessage()
            ]);
        }
    }

    public function exchangeSuccess(Request $request)
    {
        // Check if the success data exists in session
        if (!$request->session()->has('exchange_success')) {
            return redirect()->route('wallet')->with('error', 'No exchange data found');
        }

        // Get the success data from session
        $exchangeData = $request->session()->get('exchange_success');
        
        // Clear the session data immediately after retrieving it
        $request->session()->forget('exchange_success');

        return view('user.pages.wallet.exchange.success', [
            'transaction_id' => $exchangeData['transaction_id'],
            'gbp_amount' => $exchangeData['gbp_amount'],
            'ngn_amount' => $exchangeData['ngn_amount'],
            'message' => $exchangeData['message']
        ]);
    }

}
