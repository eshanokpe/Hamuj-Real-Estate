<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LearnerMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        if (Auth::user()->role !== 'learner') {
            return redirect()->route('tutor.dashboard')
                ->with('error', 'Access denied. Learner access only.');
        }

        return $next($request);
    }
}