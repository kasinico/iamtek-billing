<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckUserStatus
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();

        // =========================================
        // NOT LOGGED IN
        // =========================================

        if (!$user) {

            return redirect('/login');

        }

        // =========================================
        // PENDING USERS
        // =========================================

        if ($user->status === 'pending') {

            // Allow only pending/profile/logout pages
            if (
                !$request->is('pending') &&
                !$request->is('logout') &&
                !$request->is('profile')
            ) {

                return redirect('/pending');

            }

        }

        // =========================================
        // SHOPKEEPER RESTRICTIONS
        // =========================================

        if ($user->role === 'shopkeeper') {

            // Block admin pages
            if (

                $request->is('admin/*') ||

                $request->is('users*')

            ) {

                return redirect()->route('dashboard')
                    ->with('error', 'Unauthorized access.');

            }

        }

        // =========================================
        // OPTIONAL:
        // BLOCK ADMIN FROM SHOPKEEPER AREA
        // =========================================

        /*
        if ($user->role === 'admin') {

            if ($request->is('shopkeeper/*')) {

                return redirect()->route('dashboard');

            }

        }
        */

        // =========================================
        // ALLOW ACCESS
        // =========================================

        return $next($request);
    }
}