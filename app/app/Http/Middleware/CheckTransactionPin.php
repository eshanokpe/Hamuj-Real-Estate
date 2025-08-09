<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckTransactionPin
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();
        
        // Skip if PIN is not enabled in config
        if (!config('app.enable_transaction_pin', true)) {
            return $next($request);
        }

        // Check if PIN is set
        if (empty($user->transaction_pin)) {
            if ($request->expectsJson()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Transaction PIN not set',
                    'redirect_url' => route('user.settings.security'),
                    'requires_pin_setup' => true
                ], 403);
            }
            return redirect()->route('user.settings.security')
                   ->with('error', 'Please set your transaction PIN first');
        }

        return $next($request);
    }
}