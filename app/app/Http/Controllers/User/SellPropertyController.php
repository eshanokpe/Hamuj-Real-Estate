<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Notifications\SellPropertyUserNotification;
use App\Notifications\SellPropertyAdminNotification;
use Illuminate\Support\Facades\Notification;
use DB;
use Auth;
use Log;
use App\Models\ContactDetials;
use App\Models\Sell;
use App\Models\Buy;
use App\Models\User;
use App\Models\Property;
use Illuminate\Support\Str;
 
class SellPropertyController extends Controller
{
    
    public function index(){ 
        $user = Auth::user();
       
        $data['sellProperty'] = Buy::select(
            'property_id',  
            DB::raw('SUM(selected_size_land) as total_selected_size_land'),
            DB::raw('MAX(created_at) as latest_created_at') 
        )
        ->with('property') 
        ->with('valuationSummary')
        ->where('user_id', $user->id)
        ->where('user_email', $user->email)
        ->groupBy('property_id') 
        ->paginate(10);

        if (request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'data' =>  $data['sellProperty']
            ]);
        }

        return view('user.pages.properties.sell.index', $data); 
    }

    
    public function sellProperty(Request $request)
    {
        $request->validate([ 
            'remaining_size' => 'required',
            'property_slug' => 'required',
            'quantity' => 'required',
            'total_price' => 'required|numeric|min:1',
        ]);
        $user = Auth::user();
        $propertySlug  = $request->input('property_slug');
        $property = Property::where('slug', $propertySlug)->first();
        // Check if the property exists
        if (!$property) {
            return back()->with('error', 'Property not found.');
        }
       
        // Generate a unique transaction reference
        $reference = 'SELLDOHREF-' . time() . '-' . strtoupper(Str::random(8));

        $selectedSizeLand  = $request->input('quantity');
        $remainingSize  = $request->input('remaining_size');
        $amount  = $request->input('total_price');

        $propertyId  = $property->id;
        $propertyName  =  $property->name;
        $propertyData = Property::where('id', $propertyId)->where('name', $propertyName)->first();
        // Prepare the data to send to Paystack
       
        try {
            $sell = Sell::create([
                'property_id' => $propertyData->id,
                'property_name' => $propertyData->name,
                'selected_size_land' => $selectedSizeLand,
                'remaining_size' => $remainingSize,
                'user_id' => $user->id,
                'user_email' => $user->email,
                'reference' => $reference,
                'total_price' => $amount,
                'status' => 'pending',
            ]); 
            $contactDetials = ContactDetials::first();
            // Notify the user
            $user->notify(new SellPropertyUserNotification($user, $propertyData, $sell, $contactDetials));
            // Notify the admin (support email)
            Notification::route('mail', 'customersupport@dohmayn.com')
                ->notify(new SellPropertyAdminNotification($user, $propertyData, $sell));

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'We have received your request to sell the property.',
                    'data' => $sell
                ], 201);
            }

            return redirect()->route('user.sell.history')->with('success', 'We have receive your prompt to sell the Property, your income will be transfer to your account.');

        } catch (\Exception $e) {
            if ($request->expectsJson()) {
                return response()->json(['error' => 'Something went wrong: ' . $e->getMessage()], 500);
            }
            return back()->with('error', 'Something went wrong:' . $e->getMessage());
        }
    }

    public function sellPropertyHistory(Request $request)
    {
        $user = Auth::user();

        $sellProperties = Sell::select(
            'property_id', 'status',
            DB::raw('SUM(selected_size_land) as total_selected_size_land'),
            DB::raw('MAX(created_at) as latest_created_at') 
        )
        ->with('property')
        ->with('valuationSummary')
        ->where('user_id', $user->id)
        ->where('user_email', $user->email)
        ->groupBy('property_id', 'status') 
        ->paginate(10);

        // Check if request expects JSON (API/mobile)
        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Sell Property History retrieved successfully',
                'data' => $sellProperties,
            ]);
        }

        // Otherwise, return the web view
        return view('user.pages.properties.sell.history', ['sellProperties' => $sellProperties]);
    }

  
}
 