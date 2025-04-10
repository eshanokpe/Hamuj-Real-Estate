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
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index($id){
        $user = Auth::user(); 
        $data['user'] = User::where('id', $user->id)->where('email', $user->email)->first();
        $data['property'] = Property::where('id', decrypt($id))->first();
        return view('user.pages.cart.index', $data); 
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
 