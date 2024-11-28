<?php

namespace App\Http\Controllers\User;

use Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Property;

class CartController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index($id){
        $property = Property::where('id', decrypt($id))->first();
        return view('user.pages.cart.index', compact('property')); 
    }
}
 