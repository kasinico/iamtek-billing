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

    public function admin()
    {
        return view('admin.dashboard', [
            'totalVouchers' => Voucher::count(),
            'usedVouchers' => Voucher::where('status', 'used')->count(),
            'activeSessions' => VoucherSession::where('status', 'active')->count(),
            'routers' => MikrotikDevice::count(),
            'myVouchers' => Voucher::where('created_by', auth()->id())->count(),
        ]);
    }

    public function shopkeeper()
    {
        return view('shopkeeper.dashboard', [
            'myVouchers' => Voucher::where('created_by', auth()->id())->count(),
            'usedVouchers' => Voucher::where('created_by', auth()->id())
                                    ->where('status','used')
                                    ->count(),
            'activeSessions' => VoucherSession::where('status', 'active')->count(),
            'routers' => MikrotikDevice::count(),
        ]);
    }


}