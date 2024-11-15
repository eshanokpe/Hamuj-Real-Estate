<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\MenuItem;
use App\Models\DropdownItem;
use App\Models\Slider;
 
class AdminController extends Controller
{
   
    // public function __construct()
    // {
    //     $this->middleware('auth.admin');
    // } 

    public function index()
    { 
        return view('admin.home.index');
    }

}
