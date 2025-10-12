<?php

namespace App\Http\Controllers\User;

use Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Property;
use Illuminate\Support\Str;

class CartController extends Controller
{
    // public function __construct()
    // { 
    //     $this->middleware('auth');
    // }

    public function index(){
        return view('user.pages.cart.index'); 
    } 

    public function indexx($id){
        $user = Auth::user(); 
        $data['user'] = User::where('id', $user->id)->where('email', $user->email)->first();
        $data['property'] = Property::where('slug', $id)->first();
        return view('user.pages.cart.index', $data); 
    }


    public function buy($slug)
    {
        $user = Auth::user(); 
        $property = Property::where('slug', $slug)->first();

        if (!$property) {
            return response()->json([ 
                'message' => 'Property not found',
            ], 404);
        } 

        return response()->json([
            'user' => $user,
            'property' => $property,
        ]);
    }

    public function buys($id){
        $user = Auth::user(); 
        // $data['user'] = User::where('id', $user->id)->where('email', $user->email)->first();
        // $property = Property::where('slug', $id)->first();
        
        return response()->json([
            // 'data' => $property,
            'data' => $property,
        ]);
    } 

    public function sell($id){ 
        $user = Auth::user(); 
       
        $data['property'] = Property::with(['buys' => function ($query) use ($user) {
            $query->where('user_id', $user->id);
        }])
        ->where('id', decrypt($id))
        ->firstOrFail();

        return view('user.pages.cart.sell_cart', $data); 
    } 

    public function transfer($id){   
        $user = Auth::user();  
       
        $data['property'] = Property::with(['buys' => function ($query) use ($user) {
            $query->where('user_id', $user->id);
        }]) 
        ->where('id', decrypt($id))
        ->firstOrFail();

        return view('user.pages.cart.transfer_cart', $data); 
    }

    
}
 