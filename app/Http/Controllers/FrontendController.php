<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Property;
use App\Models\Transaction;
use Auth;

class FrontendController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $properties = Property::inRandomOrder()->take(6)->get();
        // if ($properties->isEmpty()) {
        //     return redirect()->route('home')->with('error', 'Property not found.');
        // }

        // foreach ($properties as $property) {
        //     $transaction = null;
        //     if (Auth::check()) {
        //         $transaction = $property->transaction()->where('user_id', $user->id)->first();
        //     }
        //     // dd( $transaction);

        //     $property->transaction = $transaction;
        // }  

        return view('home.index', compact('properties'));
    }

    

    public function contact(){
        return view('home.pages.contact'); 
    }

    public function download(){
        return view('home.pages.download'); 
    }
}
