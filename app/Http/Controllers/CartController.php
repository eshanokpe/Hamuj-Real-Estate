<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Property;

class CartController extends Controller
{
    public function index($id){
        $property = Property::where('id', decrypt($id))->first();
        return view('home.pages.cart.index', compact('property')); 
    }
}
 