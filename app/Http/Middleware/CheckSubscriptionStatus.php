<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckSubscriptionStatus

{
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();
        /*
|--------------------------------------------------------------------------
| ADMINS BYPASS SUBSCRIPTIONS
|--------------------------------------------------------------------------
*/

        if ($user->role === 'admin') {

            return $next($request);

        }

        if (!$user) {

            return redirect('/login');

        }

        /*
        |--------------------------------------------------------------------------
        | AUTO EXPIRE TRIAL
        |--------------------------------------------------------------------------
        */

        if (
            $user->subscription_status === 'trial'
            &&
            $user->trial_ends_at
            &&
            now()->greaterThan($user->trial_ends_at)
        ) {

            $user->subscription_status = 'expired';

            $user->save();

        }

        /*
        |--------------------------------------------------------------------------
        | AUTO EXPIRE PAID SUBSCRIPTION
        |--------------------------------------------------------------------------
        */

        if (
            $user->subscription_status === 'active'
            &&
            $user->subscription_ends_at
            &&
            now()->greaterThan($user->subscription_ends_at)
        ) {

            $user->subscription_status = 'suspended';

            $user->save();

        }

        /*
        |--------------------------------------------------------------------------
        | BLOCK EXPIRED/SUSPENDED USERS
        |--------------------------------------------------------------------------
        */

        if (
            in_array($user->subscription_status, [
                'expired',
                'suspended'
            ])
        ) {

            /*
            |--------------------------------------------------------------------------
            | ALLOW ONLY SUBSCRIPTION PAGE
            |--------------------------------------------------------------------------
            */

            if (
                !$request->is('subscription*')
                &&
                !$request->is('logout')
                &&
                !$request->is('profile*')
            ) {

                return redirect()
                    ->route('subscription.index')
                    ->with(
                        'error',
                        'Your subscription is inactive.'
                    );

            }

        }

        return $next($request);
    }
}