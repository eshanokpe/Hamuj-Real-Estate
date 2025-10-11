<?php

namespace App\Http\Controllers\User;

use Auth;

use Carbon\Carbon;
use Illuminate\Http\Request; 
use App\Models\User;
use App\Models\Faqs;
use App\Models\Neighborhood;
use App\Models\Property;
use App\Models\Transaction;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
<<<<<<< HEAD
{ 
=======
{
>>>>>>> f05b4bbffab5bd853e1aa5c5441f81520cf51ab7
    public function __construct() 
    {
        $this->middleware('auth');
    }
 
    public function index(Request $request){
        
        $user = Auth::user();
        $wallet = Auth::user()->wallet; 
        $balance = $wallet ? $wallet->balance : 0;
        $data['transactions'] = Transaction::where('user_id', $user->id)
        ->where('email', $user->email)
        ->whereIn('payment_method', ['transfer_property', 'buy_property'])
        ->latest()->limit(5)->get();
          
        $data['totalWalletAmount'] = Transaction::where('user_id', $user->id)
                                            ->where('email', $user->email)
                                            ->where('transaction_type', 'wallet')
                                            ->sum('amount');

        $data['totalPropertyAmount'] = Transaction::where('user_id', $user->id)
                                            ->where('email', $user->email)
                                            ->whereNotNull('property_id') // Property transactions have property_id
                                            ->sum('amount');
  
        $data['totalTransactionsAssets'] = Transaction::where('user_id', $user->id)
                                            ->where('email', $user->email)
                                            // ->where('status', 'success')
                                            ->distinct('property_id')
                                            ->count('property_id');
                                            
<<<<<<< HEAD
                                             
=======
                                            
>>>>>>> f05b4bbffab5bd853e1aa5c5441f81520cf51ab7
        $data['user'] = User::where('id', $user->id)
                            ->where('email', $user->email)
                            ->first();
        $data['referralsMade'] = $user->referralsMade()->with('user', 'referrer', 'referred')->take(6)->get();
        $data['hasMoreReferrals'] = $data['referralsMade']->count() > 6;
        
        if ($request->wantsJson() || $request->is('api/*')) {
            return response()->json([
                'referralsMade' => $data['referralsMade'],
                'hasMoreReferrals' => $data['hasMoreReferrals'],
                'totalAmount' => $data['totalPropertyAmount'], 
                'totalPropertyAmount' => $data['totalPropertyAmount'],
                'totalAssets' => $data['totalTransactionsAssets'],
                'transactions' => $data['transactions'],
            ]); 
        }  
  
        return view('user.dashboard', $data); 
    }

    public function transactionReport(Request $request)
    {
        $query = Transaction::with('user')->latest();
        if ($request->has('filter')) {
            switch ($request->filter) {
                case 'today':
                    $query->whereDate('created_at', Carbon::today());
                    break;
                case 'yesterday':
                    $query->whereDate('created_at', Carbon::yesterday());
                    break;
                case 'last7days':
                    $query->where('created_at', '>=', Carbon::now()->subDays(7));
                    break;
                case 'thismonth':
                    $query->whereMonth('created_at', Carbon::now()->month)
                        ->whereYear('created_at', Carbon::now()->year);
                    break;
                case 'lastmonth':
                    $query->whereMonth('created_at', Carbon::now()->subMonth()->month)
                        ->whereYear('created_at', Carbon::now()->subMonth()->year);
                    break;
            }
        }

        $transactions = $query->paginate(10); 
        return view('user.dashboard',  compact('transactions')); 
    }

    public function properties()
    {
        try {
            $user = Auth::user();

            // Get all transactions for the logged-in user
            $transactions = Transaction::where('user_id', $user->id)->pluck('property_id')->toArray();

            // Fetch properties related to the user's transactions and paginate them
            $properties = Property::whereIn('id', $transactions)->latest()->paginate(10);

            // Attach related transactions to each property for the view
            foreach ($properties as $property) {
                $property->transaction = $property->transaction()
                    ->where('user_id', $user->id)
                    ->where('email', $user->email)
                    ->first();
            }
            $users = Auth::user();
            $user = User::where('id', $users->id)
                        ->where('email', $users->email)
                        ->first();

            return view('user.pages.properties.index', compact('properties','user'));

        } catch (\Exception $e) {
            \Log::error('Error fetching properties: ' . $e->getMessage());
            return redirect()->route('home')->with('error', 'An unexpected error occurred. Please try again later.');
        }
    }

    
    public function propertiesShow($id)
    {  
        $users = Auth::user();
        $data['property'] = Property::findOrFail(decrypt($id));
        $data['user'] = User::where('id', $users->id)
                        ->where('email', $users->email)
                        ->first();
        $neighborhoods = Neighborhood::with(['property', 'category'])->get();

        $data['neighborhoods'] = $neighborhoods->groupBy(function ($item) {
            return $item->category->name ?? 'Uncategorized';
        });
        return view('user.pages.properties.show', $data);
    }  

    public function toggleHideBalance(Request $request)
    {
        $user = Auth::user();

        $user->hide_balance = $request->hide_balance;
        $user->save();

        return response()->json(['success' => true]);
    }

    public function faqs() {
        $faqs = Faqs::all();

        return response()->json([
            'status' => 'success',
            'data' => $faqs,
        ], 200);

    }

    public function purchases(){
        $purchases = Transaction::where('user_id', auth()->id())->get();
        // dd($purchases);
        return view('user.pages.success.index',compact('purchases'));
    }

    public function checkStatus(int $userId)
    {
        // Find the user by their ID
        $user = User::find($userId);

        if (!$user) {
            // You can return 404 directly, or a structured response
            // return response()->json(['exists' => false, 'active' => false], 404);
            return response()->json([
                'status' => 'error',
                'message' => 'User not found.',
                'exists' => false,
                'active' => false
            ], 404);
        }

        $isActive = (bool) $user->is_active; // Cast to boolean for clarity

        // Return a successful response with the status
        return response()->json([
            'status' => 'success',
            'message' => 'User status retrieved.',
            'exists' => true,
            'active' => $isActive
        ]);

    }
}
