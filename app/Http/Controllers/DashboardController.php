<?php

namespace App\Http\Controllers;

use App\Models\Voucher;
use App\Models\VoucherSession;
use App\Models\MikrotikDevice;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard', [
            'totalVouchers' => Voucher::count(),
            'usedVouchers' => Voucher::where('status', 'used')->count(),
            'activeSessions' => VoucherSession::where('status', 'active')->count(),
            'routers' => MikrotikDevice::count(),
        ]);
    }
}