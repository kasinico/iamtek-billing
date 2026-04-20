<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class EnsureUserApproved
{
    public function handle($request, Closure $next)
    {
        $user = auth()->user();

        if (!$user) {
            return redirect('/login');
        }

        // ADMIN ALWAYS SKIP
        if ($user->role === 'admin') {
            return $next($request);
        }

        // SHOPKEEPER CHECK
        if ($user->role === 'shopkeeper') {

            if ($user->status !== 'active') {
                return redirect('/pending');
            }

        }

        return $next($request);
    }
    // public function handle(Request $request, Closure $next)
    // {
    //     if (Auth::check()) {

    //         $user = Auth::user();

    //         // ADMIN ALWAYS ALLOWED
    //         if ($user->role === 'admin') {
    //             return $next($request);
    //         }

    //         // SHOPKEEPER MUST BE ACTIVE
    //         if ($user->status !== 'active') {
    //             return redirect('/pending');
    //         }
    //     }

    //     return $next($request);
    // }
}