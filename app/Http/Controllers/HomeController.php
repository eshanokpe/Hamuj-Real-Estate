<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Property;
use App\Models\Neighborhood;
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
       
        return view('home',compact('properties')); 
    } 

    public function showProperties($slug)
    {
        try {   
            $data['property'] = Property::with('priceUpdates')->where('slug', $slug)->first();
            if (!$data['property']) {
                return redirect()->route('home')->with('error', 'Property not found.');
            }
            
            $neighborhoods = Neighborhood::with(['property', 'category'])->get();

            $data['neighborhoods'] = $neighborhoods->groupBy(function ($item) {
                return $item->category->name ?? 'Uncategorized';
            });
            

            return view('home.pages.properties.show', $data);

        } catch (\Exception $e) {
            \Log::error('Error fetching property: ' . $e->getMessage());
            return redirect()->route('home')->with('error', 'An unexpected error occurred.'.$e->getMessage());
        }
    }

    
}
