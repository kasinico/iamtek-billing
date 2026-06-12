<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Voucher;
use App\Models\VoucherSession;
use App\Models\MikrotikDevice;
use App\Models\Customer;
use App\Models\Package;
use App\Models\Subscription;



use App\Models\RouterStatus;


class ClientController extends Controller
{
    //


public function show(User $user)
{
    /*
    |--------------------------------------------------------------------------
    | REVENUE
    |--------------------------------------------------------------------------
    */

    $revenue = Voucher::where(
            'created_by',
            $user->id
        )
        ->whereIn(
    'status',
    ['active','used', 'expired']
)
        ->sum('price');

    $commission = Voucher::where(
            'created_by',
            $user->id
        )
        ->whereIn(
            'status',
            ['active','used', 'expired']
        )
        ->sum('commission_amount');

    $earnings = Voucher::where(
            'created_by',
            $user->id
        )
        ->whereIn(
        'status',
        ['active','used', 'expired']
    )
        ->sum('shopkeeper_amount');

    /*
    |--------------------------------------------------------------------------
    | COUNTS
    |--------------------------------------------------------------------------
    */

    $totalVouchers = Voucher::where(
        'created_by',
        $user->id
    )->count();

    $usedVouchers = Voucher::where(
        'created_by',
        $user->id
    )->whereIn(
        'status', 
        ['active','used','expired']
    )->count();

    $activeVouchers = Voucher::where(
        'created_by',
        $user->id
    )->where('status', 'active')->count();

    $routers = MikrotikDevice::where(
        'user_id',
        $user->id
    )->get();

    $customers = Customer::where(
        'user_id',
        $user->id
    )->latest()->take(10)->get();

    $vouchers = Voucher::where(
        'created_by',
        $user->id
    )->latest()->take(10)->get();


    // customer Analytics
    $totalCustomers =
    Customer::where(
        'user_id',
        $user->id
    )->count();

    $activeCustomers =
        Customer::where(
            'user_id',
            $user->id
        )
        ->where(
            'status',
            'active'
        )
        ->count();

    $expiredCustomers =
        Customer::where(
            'user_id',
            $user->id
        )
        ->where(
            'status',
            'expired'
        )
        ->count();

    // router status
    $routerStatuses =
        RouterStatus::whereIn(
            'mikrotik_device_id',
            $routers->pluck('id')
    )->get();



    $transactions = Voucher::where(
        'created_by',
        $user->id
    )
    ->whereIn(
        'status',
        ['active', 'expired']
    )
    ->latest()
    ->get();

    $onlineRouters = RouterStatus::whereIn(
            'mikrotik_device_id',
            $routers->pluck('id')
        )
        ->where('is_online', true)
        ->count();

    $offlineRouters = RouterStatus::whereIn(
            'mikrotik_device_id',
            $routers->pluck('id')
        )
        ->where('is_online', false)
        ->count();

    $subscriptionStatus =
        $user->subscription_status ?? 'active';



        // get subscription from its subscription modal and controller

        $subscriptions = Subscription::where(
    'user_id',
            $user->id
        )
        ->latest()
        ->get();


    return view(
        'clients.show',
        compact(
            'user',
            'revenue',
            'commission',
            'earnings',
            'totalVouchers',
            'usedVouchers',
            'activeVouchers',
            'routers',
            'customers',
            'vouchers', 

            'totalCustomers',
            'activeCustomers',
            'expiredCustomers',
            'routerStatuses',

            'transactions',
            'onlineRouters',
            'offlineRouters',
            'subscriptionStatus',

            'subscriptions'
        )
    );
}










}
