<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Log;
use App\Models\Sell;
use App\Models\Buy;
use App\Models\User;
use App\Models\Property;
use Illuminate\Support\Str;
 
class SellPropertyController extends Controller
{
    
    public function index(){ 
        $user = Auth::user();
        $data['user'] = User::where('id', $user->id)->where('email', $user->email)->first();

        $data['buyProperty'] = Buy::with('property') 
        ->where('user_id', $user->id)
        ->where('user_email', $user->email)
        // ->where('user_email', 'buy')
        ->latest()
        ->paginate(10);
        return view('user.pages.properties.sell', $data); 
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
        $reference = 'SELLPROREF-' . time() . '-' . strtoupper(Str::random(8));

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

            return redirect()->route('user.dashboard')->with('success', 'We have receive your prompt to sell the Property, your income will be transfer to your account.');

        } catch (\Exception $e) {
            return back()->with('error', 'Something went wrong:' . $e->getMessage());
        }
    }
}
