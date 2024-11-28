<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Models\Buy;
use App\Models\Property;

class PropertyController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth'); 
    }
 
    public function index(){
        $data['properties'] = Property::latest()->paginate(10);
        return view('user.pages.properties.index',$data); 
    }

    public function buy(){
        $user = Auth::user();
        $data['buyProperty'] = Buy::with('property') 
        ->where('user_id', $user->id)
        ->where('user_email', $user->email)
        ->latest()
        ->paginate(10);
        return view('user.pages.properties.buy', $data); 
    }

    public function sell(){
        return view('user.properties.sell'); 
    }
}
