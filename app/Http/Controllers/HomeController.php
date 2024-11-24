<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Property;
use App\Models\Transaction;
use Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    { 
        $properties = Property::inRandomOrder()->take(6)->get();
        if ($properties->isEmpty()) {
            return redirect()->route('home')->with('error', 'Property not found.');
        }

        foreach ($properties as $property) {
            $transaction = $property->transaction()->where('user_id', Auth::id())->first();

            $property->transaction = $transaction;
        }
        return view('home',compact('properties')); 
    } 

    public function showProperties($slug)
    {
        try {   
            $property = Property::where('slug', $slug)->first();
            if (!$property) {
                return redirect()->route('home')->with('error', 'Property not found.');
            }

            $transaction = null;
            if (Auth::check()) {
                $transaction = $property->transaction()->where('user_id', Auth::id())->first();
            }

            // Attach transaction to the property instance for use in the view
            $property->transaction = $transaction;

            return view('home.pages.properties.show', compact('property'));

        } catch (\Exception $e) {
            \Log::error('Error fetching property: ' . $e->getMessage());
            return redirect()->route('home')->with('error', 'An unexpected error occurred.'.$e->getMessage());
        }
    }

    
}
