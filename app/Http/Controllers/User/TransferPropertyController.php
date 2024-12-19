<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Auth;
use Log;
use App\Models\Transfer;
use App\Models\Sell;
use App\Models\Buy;
use App\Models\User;
use App\Models\Property;
use Illuminate\Support\Str;
use App\Models\VirtualAccount;
use App\Services\PaystackService;
 
class TransferPropertyController extends Controller
{
    
    public function index(){ 
        $user = Auth::user();
       
        $data['sellProperty'] = Buy::select(
            'property_id', 
            DB::raw('SUM(selected_size_land) as total_selected_size_land'),
            DB::raw('MAX(created_at) as latest_created_at') 
        )
        ->with('property')
        ->where('user_id', $user->id)
        ->where('user_email', $user->email)
        ->groupBy('property_id') 
        ->paginate(10);

        return view('user.pages.properties.transfer.index', $data); 
    }
    
    public function transferRecipient(Request $request){
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
        $reference = 'PRO-TRANSFER-REF-' . time() . '-' . strtoupper(Str::random(8));
        $selectedSizeLand  = $request->input('quantity');
        $remainingSize  = $request->input('remaining_size');
        $amount  = $request->input('total_price');
        $propertySlug = $request->input('property_slug');
        $propertyId  = $property->id;
        $propertyName  =  $property->name;
        $propertyData = Property::where('id', $propertyId)->where('name', $propertyName)->first();
        $data = [
            'amount' => $amount * 100, 
            'email' => $user->email,
            'metadata' => [
                'property_id' => $propertyData->id,
                'property_name' => $propertyData->name,
                'property_image' => $propertyData->property_images,
                'remaining_size' => $remainingSize,
                'selected_size_land' => $selectedSizeLand,
                'property_slug' => $propertySlug,
            ],
            'reference' => $reference,
            'property_state' => $property->property_state,
        ];
       

        return view('user.pages.properties.transfer.recipient', compact('data')); 
    }
    
    public function checkRecipientTransfer(Request $request, PaystackService $paystackService)
    {
      try{
        $request->validate([
            'selected_size_land' => 'required',
            'property_slug' => 'required',
            'property_id' => 'required',
            'recipient_id' => 'required',
            'amount' => 'required|numeric|min:1',
        ]);
        $user = Auth::user();
        $amount = $request->input('amount');
        $propertyId  = $request->input('property_id');
        $recipientId = $request->input('recipient_id');
        $propertySlug = $request->input('property_slug');
        $landSize = $request->input('selected_size_land');
        $customerCheck = User::where('recipient_id', $recipientId)->first();
        
        if (!$customerCheck) {
            return back()->with('error', 'This recipient does not exist.');
        } 
       
        // Check if the recipient is the same as the current user
        if ($recipientId === $user->recipient_id) {
            return back()->with('error', 'You cannot transfer the property to yourself.');
        }
        $propertyData = Property::where('id', $propertyId)->where('slug', $propertySlug)->first();
       
        // $reference = null;
        $reference = 'TRANS-' . strtoupper(Str::random(10));
        // Check if there's a Sell model associated with this property
        $buy = Buy::where('property_id', $propertyData->id)
                ->where('user_id', $user->id)->first();
        if (!$buy) {
            return back()->with('error', 'Property not available for sale.');
        }

        if ($buy->selected_size_land < $landSize) {
            return back()->with('error', 'Insufficient land size available for transfer.');
        }
        $transfer = Transfer::create([
            'property_id' => $propertyData->id,
            'property_name' => $propertyData->name,
            'land_size' => $landSize,
            'user_id' => $user->id,
            'user_email' => $user->email,
            'reference' => $reference,
            'recipient_id' => $recipientId,
            'total_price' => $amount,
            'status' => 'pending',
        ]);
        // Update the Sell model, reducing the selected_size_land
        $buy->selected_size_land -= $landSize;
        $buy->save();

        return redirect()->route('user.transfer.history')->with('success', 'We have receive your prompt to transfer the Property to the confirmed User ID, your transfer will be process.');
    } catch (\Exception $e) {
        return back()->with('error', 'Something went wrong:' . $e->getMessage());
    }
    }

    public function transferHistory(){ 
        $user = Auth::user();
       
        $data['transferProperty'] = Transfer::select(
            'property_id', 'status', 'land_size',
            DB::raw('SUM(land_size) as total_land_size'),
            DB::raw('MAX(created_at) as latest_created_at'), 
        )
        ->with('property')
        ->where('user_id', $user->id)
        ->where('user_email', $user->email)
        ->groupBy('property_id','status','land_size') 
        ->paginate(10);

        return view('user.pages.properties.transfer.history', $data); 
    }
   
 
}
 