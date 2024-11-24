<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Property;
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
        return view('home'); 
    } 

    public function showProperties($slug)
    {
        try {   
            $property = Property::firstWhere('slug', $slug);
            if (!$property) {
                return redirect()->route('home')->with('error', 'Property not found.');
            }
            // Get the transaction for a specific property and user
            $transaction = $property->transaction()->where('user_id', Auth::id())->first();
        
            return view('home.pages.properties.show', compact('property','transaction'));

        } catch (\Exception $e) {
            \Log::error('Error fetching property: ' . $e->getMessage());
            return redirect()->route('home')->with('error', 'An unexpected error occurred.');
        }
    }

    
}
