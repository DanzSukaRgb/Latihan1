<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureEmailIsVerified
{
    public function handle(Request $request, Closure $next)
    {
        if (! Auth::user()->hasVerifiedEmail()) {
            Auth::logout();
            return redirect('/login')
                ->with('error', 'Anda perlu memverifikasi email terlebih dahulu.');
        }

        return $next($request);
    }
}