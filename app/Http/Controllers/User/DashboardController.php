<?php

namespace App\Http\Controllers\User;

use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
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
        $data['transactions'] = Transaction::where('user_id', $user->id)->where('email', $user->email)->latest()->limit(6)->get();
        $data['totalAmount'] = Transaction::where('user_id', $user->id)->where('email', $user->email)->sum('amount');
        $data['totalTransactions'] = Transaction::where('user_id', $user->id)->where('email', $user->email)->count();

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
        $user = Auth::user();
        $transactions = Transaction::where('user_id', $user->id)->where('email', $user->email)->first();
        // Use paginate instead of get()
        $properties = Property::where('id', $transactions->property_id)->latest()->paginate(10); // Adjust '10' as needed

        return view('user.pages.properties.index', compact('properties'));
    }

    public function propertiesShow($id){

        $property = Property::findOrFail(decrypt($id));

        return view('user.pages.properties.show', compact('property'));
    }


    
}
