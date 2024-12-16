<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Log;
use App\Models\Buy;
use App\Models\User;
use App\Models\Property;
use App\Models\Offerprice;

 
class PropertyController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth'); 
    }
 
    public function index(){
        $user = Auth::user();
        $data['user'] = User::where('id', $user->id)->first();
        $data['properties'] = Property::latest()->paginate(10);
        return view('user.pages.properties.index',$data); 
    }

    public function buy(){
        $user = Auth::user();
        $data['user'] = User::where('id', $user->id)->first();
        $data['buyProperty'] = Buy::with('property') 
                                ->where('user_id', $user->id)
                                ->where('user_email', $user->email)
                                // ->latest()
                                ->paginate(10);

        return view('user.pages.properties.buy', $data); 
    } 

    public function offerPrice($id){
        $user = Auth::user();
        $data['user'] = User::where('id', $user->id)->first();
        $data['buy'] = Buy::with('property')->where('property_id', decrypt($id))->first();
        return view('user.pages.properties.offer_price', $data); 
    }

    public function offerPricePost(Request $request)
    {
       $validated = $request->validate([
            'buy_id' => 'required|exists:buys,id',
            'property_id' => 'required|exists:properties,id',
            'offer_price' => 'required|min:1',
        ]);

        $buyId = $request->input('buy_id');
        $propertyId = $request->input('property_id');
        $offerPrice = str_replace(',', '', $request->input('offer_price'));
        try{
            $property = Property::find($propertyId);
            if (!$property) {
                return redirect()->back()->with('error', 'Property not found.');
            }

            if ($offerPrice < $property->price) {
                return redirect()->back()->with('error', 'Your offer price must not be less than the property price.');
            }

            Offerprice::create([
                'property_id' => $propertyId,
                'buy_id' => $buyId,
                'amount' => $offerPrice,
            ]);

            // Redirect with a success message
            return redirect()->route('user.buy')->with('success', 'Your offer price has been submitted successfully.');
        }catch(Exception $e){
            return redirect()->route('user.buy')->with('error', 'Error'.$e->getMessage());
        }
    }


    

    public function transfer(){
        $user = Auth::user();
        $data['buyProperty'] = Buy::with('property') 
        ->where('user_id', $user->id)
        ->where('user_email', $user->email)
        ->where('user_email', 'buy')
        ->latest()
        ->paginate(10);
        $data['user'] = User::where('id', $user->id)->first();

        return view('user.pages.properties.transfer.index',  $data); 
    }

    public function add(){
        $user = Auth::user();
        $data['buyProperty'] = Buy::with('property') 
        ->where('user_id', $user->id)
        ->where('user_email', $user->email)
        ->where('user_email', 'buy')
        ->latest()
        ->paginate(10);
        $data['user'] = User::where('id', $user->id)->first();

        return view('user.pages.properties.transfer.add',  $data); 
    }
}
