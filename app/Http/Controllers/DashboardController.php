<?php

namespace App\Http\Controllers;

use App\Models\Voucher;
use App\Models\VoucherSession;
use App\Models\MikrotikDevice;

class DashboardController extends Controller
{
    // public function index()
    // {
    //     return view('dashboard', [
    //         'totalVouchers' => Voucher::count(),
    //         'usedVouchers' => Voucher::where('status', 'used')->count(),
    //         'activeSessions' => VoucherSession::where('status', 'active')->count(),
    //         'routers' => MikrotikDevice::count(),
    //     ]);
    // }

    // public function admin()
    // {
    //     return view('admin.dashboard', [
    //         'totalVouchers' => Voucher::count(),
    //         'usedVouchers' => Voucher::where('status', 'used')->count(),
    //         'activeSessions' => VoucherSession::where('status', 'active')->count(),
    //         'routers' => MikrotikDevice::count(),
    //         'myVouchers' => Voucher::where('created_by', auth()->id())->count(),
    //     ]);
    // }


public function index()
{
    $role = auth()->user()->role;

    $data = [

        'totalVouchers' => Voucher::count(),

        'activeSessions' => VoucherSession::where('status', 'active')->count(),

        'totalRouters' => MikrotikDevice::count(),

        'totalRevenue' => Voucher::sum('price'),

    ];

    if ($role === 'admin') {

        return view('dashboards.admin', $data);

    }

    return view('dashboards.shopkeeper', $data);
}


    public function admin()
{
    return view('dashboards.admin', [

        // TOTAL
        'totalVouchers' => \App\Models\Voucher::count(),
         'myVouchers' => Voucher::where('created_by', auth()->id())->count(),
         'activeSessions' => VoucherSession::where('status', 'active')->count(),

        // USED
        'usedVouchers' => \App\Models\Voucher::where('status', 'used')->count(),

        // ACTIVE (from sync system)
        'activeVouchers' => \App\Models\Voucher::where('status', 'active')->count(),

        // UNUSED
        'unusedVouchers' => \App\Models\Voucher::where('status', 'unused')->count(),

        // myV
        // 'myVouchers' => \App\Models\Voucher::where('created_by', auth()->id())->count(),

        // ROUTERS
        'routers' => MikrotikDevice::count(),
        'myRouters' => MikrotikDevice::where('user_id', auth()->id())->count(),


    
        

        // 🔥 RECENT VOUCHERS (IMPORTANT)
        // 'recentVouchers' => \App\Models\Voucher::latest()->take(10)->get(),
        'recentVouchers' => Voucher::where('created_by', auth()->id())
                            ->latest()
                            ->take(10)
                            ->get(),
    ]);
}

    public function shopkeeper()
    {
        $user = auth()->user();

        return view('dashboards.shopkeeper', [
            //real data
            'total' => Voucher::where('created_by', $user->id)->count(),
            'active' => Voucher::where('created_by', $user->id)
                    ->where('status', 'active')->count(),
            'used' => Voucher::where('created_by', $user->id)
                    ->where('status', 'used')->count(),

            'unused' => Voucher::where('created_by', $user->id)
                    ->where('status', 'unused')->count(),

            // -----------------------------------
            'myVouchers' => Voucher::where('created_by', auth()->id())->count(),
            
            'activeVouchers' => Voucher::where('created_by','status', 'active')->count(),

            'usedVouchers' => Voucher::where('created_by', auth()->id()) //will merge with used up
                                    ->where('status','used')
                                    ->count(),
            // 'activeSessions' => VoucherSession::where('status', 'active')->count(),
            // 'routers' => MikrotikDevice::count(),
            'routers' => MikrotikDevice::where('user_id', auth()->id())->count(),
                    // 'recentVouchers' => \App\Models\Voucher::latest()->take(10)->get(),

        ]);
    }


}