<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;


class SubscriptionController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | CLIENT SUBSCRIPTION PAGE
    |--------------------------------------------------------------------------
    */

public function index(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | ADMIN VIEW
        |--------------------------------------------------------------------------
        */

        if (auth()->user()->role === 'admin') {

    $query = User::where('role', 'shopkeeper');

    /*
    |--------------------------------------------------------------------------
    | SEARCH
    |--------------------------------------------------------------------------
    */

    if ($request->search) {

        $query->where(function ($q) use ($request) {

            $q->where(
                'name',
                'like',
                '%' . $request->search . '%'
            )

            ->orWhere(
                'phone',
                'like',
                '%' . $request->search . '%'
            );

        });

    }

    /*
    |--------------------------------------------------------------------------
    | STATUS FILTER
    |--------------------------------------------------------------------------
    */

    if ($request->status) {

        $query->where(
            'subscription_status',
            $request->status
        );

    }

    /*
    |--------------------------------------------------------------------------
    | COUNTRY FILTER
    |--------------------------------------------------------------------------
    */

    if ($request->country) {

        $query->where(
            'country',
            $request->country
        );

    }

    $users =
        $query->latest()->paginate(10);

    return view('subscription.admin', [

        'users' => $users,

        'expiredAccounts' => User::where(
            'subscription_status',
            'expired'
        )->count(),

        'expiringSoon' => User::whereNotNull(
                'subscription_ends_at'
            )

            ->whereBetween(
                'subscription_ends_at',
                [now(), now()->addDays(3)]
            )

            ->count(),

        'trialAccounts' => User::where(
            'subscription_status',
            'trial'
        )->count(),

        'activeSubscriptions' => User::where(
            'subscription_status',
            'active'
        )->count(),

    ]);

}

        /*
        |--------------------------------------------------------------------------
        | CLIENT VIEW
        |--------------------------------------------------------------------------
        */

        return view('subscription.client', [

    'subscriptions' => \App\Models\Subscription::where(
            'user_id',
            auth()->id()
        )

        ->latest()

        ->get(),

]);
    }

    /*
    |--------------------------------------------------------------------------
    | MANUAL ACTIVATE
    |--------------------------------------------------------------------------
    */

    public function manualActivate(Request $request, $id)
{
    $user = User::findOrFail($id);

    $durationType =
        $request->duration_type;

    $durationValue =
        (int) $request->duration_value;

    /*
    |--------------------------------------------------------------------------
    | CALCULATE END DATE
    |--------------------------------------------------------------------------
    */

    $endDate = now();

    if ($durationType === 'days') {

        $endDate =
            now()->addDays($durationValue);

    }

    if ($durationType === 'months') {

        $endDate =
            now()->addMonths($durationValue);

    }

    if ($durationType === 'years') {

        $endDate =
            now()->addYears($durationValue);

    }

    /*
    |--------------------------------------------------------------------------
    | ACTIVATE
    |--------------------------------------------------------------------------
    */

    $user->subscription_status = 'active';

    $user->subscription_ends_at =
        $endDate;

    $user->save();
    \App\Models\Subscription::create([

    'user_id' => $user->id,

    'amount' => 5000,

    'status' => 'active',

    'starts_at' => now(),

    'ends_at' => $endDate,

    'duration_type' => $durationType,

    'duration_value' => $durationValue,

    'activated_by' => auth()->user()->name,

]);

    return back()->with(
        'success',
        'Subscription activated successfully.'
    );
}

    /*
    |--------------------------------------------------------------------------
    | SUSPEND
    |--------------------------------------------------------------------------
    */

    public function suspend($id)
    {
        $user = User::findOrFail($id);

        $user->subscription_status = 'suspended';

        $user->save();

        return back()->with(
            'success',
            'Subscription suspended.'
        );
    }
}