<?php

namespace App\Http\Controllers\User;

use Auth;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Property;
use App\Models\Transaction;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
 
    public function index(){
        // $query = Transaction::with('user')->latest();
        // $transactions = $query->paginate(10); 
        $user = Auth::user();
        $wallet = Auth::user()->wallet; 
        $balance = $wallet ? $wallet->balance : 0;
        // dd($balance);
        $data['transactions'] = Transaction::where('user_id', $user->id)->where('email', $user->email)->latest()->limit(6)->get();
        $data['totalAmount'] = Transaction::where('user_id', $user->id)
                                            ->where('email', $user->email)
                                            ->where('status', 'success')
                                            ->sum('amount');
        $data['totalTransactions'] = Transaction::where('user_id', $user->id)->where('email', $user->email)->where('status', 'success')->count();
        $data['user'] = User::where('id', $user->id)
                            ->where('email', $user->email)
                            ->first();

        // dd($data);
         // Fetch referral details
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
        $property = Property::findOrFail(decrypt($id));
        $user = User::where('id', $users->id)
                        ->where('email', $users->email)
                        ->first();
        return view('user.pages.properties.show', compact('property','user'));
    }


    
}
