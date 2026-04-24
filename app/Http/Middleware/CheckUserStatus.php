<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckUserStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle($request, Closure $next)
    {
        $user = auth()->user();

        if (!$user) {
            return redirect('/login');
        }

        // allow admin always
        if ($user->role === 'admin') {
            return $next($request);
        }

        // pending users
        if ($user->status === 'pending') {

            // allow ONLY these routes
            if (
                !$request->is('pending') &&
                !$request->is('logout') &&
                !$request->is('profile')
            ) {
                return redirect('/pending');
            }
        }

        return $next($request);
    }
}
