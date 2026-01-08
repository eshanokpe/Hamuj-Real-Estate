<?php

namespace App\Http\Controllers\Tutor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        return view('tutor.dashboard');
    }

    public function profile()
    {
        return view('tutor.profile');
    }

    public function sessions()
    {
        return view('tutor.sessions');
    }

    public function students()
    {
        return view('tutor.students');
    }

    public function earnings()
    {
        return view('tutor.earnings');
    }

    public function settings()
    {
        return view('tutor.settings');
    }
}