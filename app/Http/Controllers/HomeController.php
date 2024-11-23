<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Property;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
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
            return view('home.pages.properties.show', compact('property'));

        } catch (\Exception $e) {
            \Log::error('Error fetching property: ' . $e->getMessage());
            return redirect()->route('home')->with('error', 'An unexpected error occurred.');
        }
    }

    
}
