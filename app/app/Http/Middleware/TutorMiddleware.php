<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TutorMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        if (Auth::user()->role !== 'tutor') {
            return redirect()->route('learner.dashboard')
                ->with('error', 'Access denied. Tutor access only.');
        }

        return $next($request);
    }
}