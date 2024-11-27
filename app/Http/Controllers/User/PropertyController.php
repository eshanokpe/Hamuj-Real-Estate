<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Property;

class PropertyController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth'); 
    }
 
    public function index(){
        $data['properties'] = Property::latest()->paginate(10);
        return view('user.pages.properties.buy',$data); 
    }

    public function buy(){
        $data['properties'] = Property::lastest()->paginate(10);
        return view('user.pages.properties.buy', $data); 
    }

    public function sell(){
        return view('user.properties.sell'); 
    }
}
