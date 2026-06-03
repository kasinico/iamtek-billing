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
        // Admin report
        if(auth()->user()->role === 'admin'){

        
        $totalRevenue =
            Voucher::whereIn(
                'status', 
                ['active','expired']
                )
                ->sum('price');

        $voucherSales =
            Voucher::whereIn('status', ['active','expired'])
                ->count();

        $customerGrowth =
            User::where('role', 'shopkeeper')
                ->count();

        $activeRouters =
            MikrotikDevice::where('is_active', 1)
                ->count();

        $customerStats = [

    'active' => User::where(
        'subscription_status',
        'active'
    )->count(),

    'trial' => User::where(
        'subscription_status',
        'trial'
    )->count(),

    'suspended' => User::whereIn(
        'subscription_status',
        ['expired', 'suspended']
    )->count(),

];



        
        }
        // client reports
        else{
             $totalRevenue =
                Voucher::where('user_id', auth()->id())
                    ->where('status', 'used')
                    ->sum('price');

            $voucherSales =
                Voucher::where('user_id', auth()->id())
                    ->count();

            $customerGrowth = 1;

            $activeRouters =
                MikrotikDevice::where(
                    'user_id',
                    auth()->id()
                )->count();

        }
        // chart analytics || Monthly revenue
        $monthlyRevenue = [];

        for ($month = 1; $month <= 12; $month++) {

            if(auth()->user()->role === 'admin') {

                $total = \App\Models\Voucher::whereMonth(
                        'created_at',
                        $month
                    )
                    ->where('status', 'used')
                    ->sum('price');

            } else {

                $total = \App\Models\Voucher::where(
                        'user_id',
                        auth()->id()
                    )
                    ->whereMonth(
                        'created_at',
                        $month
                    )
                    ->where('status', 'used')
                    ->sum('price');

            }

            $monthlyRevenue[] = $total;
        }

        // customer status stats
        if(auth()->user()->role === 'admin') {

            $activeCustomers =
                \App\Models\User::where(
                    'subscription_status',
                    'active'
                )->count();

            $trialCustomers =
                \App\Models\User::where(
                    'subscription_status',
                    'trial'
                )->count();

            $suspendedCustomers =
                \App\Models\User::whereIn(
                    'subscription_status',
                    ['expired', 'suspended']
                )->count();

        } else {

            /*
            |--------------------------------------------------------------------------
            | CLIENT SIDE
            |--------------------------------------------------------------------------
            */

            $activeCustomers = 1;

            $trialCustomers =
                auth()->user()->subscription_status === 'trial'
                ? 1 : 0;

            $suspendedCustomers =
                in_array(
                    auth()->user()->subscription_status,
                    ['expired', 'suspended']
                )
                ? 1 : 0;
        }

        if(auth()->user()->role === 'admin') {

            return view('reports.admin', compact(

                'totalRevenue',
                'voucherSales',
                'customerGrowth',
                'activeRouters',
                'monthlyRevenue',
                'customerStats' 

            ));

        }

        return view('reports.clients', compact(

            'totalRevenue',
            'voucherSales',
            'activeRouters',
            'monthlyRevenue'

        ));

        //  return view('reports.clients');


       
    }

    /*
    |--------------------------------------------------------------------------
    | SHOPKEEPER SALES PERFORMANCE
    |--------------------------------------------------------------------------
    |
    | Admin can see:
    | - Revenue generated
    | - Commission earned by platform
    | - Earnings due to shopkeeper
    | - Number of vouchers sold
    |
    */

    public function commissions()
    {
        $sales = Voucher::selectRaw('

            created_by,

            COUNT(*) as vouchers_sold,

            SUM(price) as revenue,

            SUM(commission_amount) as commission,

            SUM(shopkeeper_amount) as earnings

        ')
        ->whereIn(
            'status',
            ['active', 'expired']
        )
        ->groupBy('created_by')
        ->with('creator')
        ->get();

        return view(
            'reports.commissions',
            compact('sales')
        );
    }



}