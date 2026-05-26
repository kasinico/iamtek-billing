<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Voucher;
use App\Models\MikrotikDevice;

class ReportController extends Controller
{
    public function index()
    {
        $totalRevenue =
            Voucher::where('status', 'used')
                ->sum('price');

        $voucherSales =
            Voucher::where('status', 'used')
                ->count();

        $customerGrowth =
            User::where('role', 'shopkeeper')
                ->count();

        $activeRouters =
            MikrotikDevice::where('is_active', 1)
                ->count();

        return view('reports.index', [

            'totalRevenue' => $totalRevenue,

            'voucherSales' => $voucherSales,

            'customerGrowth' => $customerGrowth,

            'activeRouters' => $activeRouters,

        ]);
    }
}