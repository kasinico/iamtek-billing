<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Voucher;
use App\Models\VoucherSession;
use App\Models\Customer;
use App\Models\Package;
use App\Models\MikrotikDevice;

class CustomerController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | CUSTOMERS PAGE
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        /*
        |--------------------------------------------------------------------------
        | ADMIN SEES ALL CUSTOMERS
        |--------------------------------------------------------------------------
        */

        if (auth()->user()->role === 'admin') {

            $customers = Customer::latest()->get();

        }

        /*
        |--------------------------------------------------------------------------
        | SHOPKEEPER SEES OWN CUSTOMERS
        |--------------------------------------------------------------------------
        */

        else {

            $customers = Customer::where(
                'user_id',
                auth()->id()
            )->latest()->get();

        }

        /*
        |--------------------------------------------------------------------------
        | PACKAGES
        |--------------------------------------------------------------------------
        */

        $packages = Package::all();

        /*
        |--------------------------------------------------------------------------
        | ROUTERS
        |--------------------------------------------------------------------------
        */

        $routers = MikrotikDevice::all();

        /*
        |--------------------------------------------------------------------------
        | STATS
        |--------------------------------------------------------------------------
        */

        $totalCustomers =
            $customers->count();

        $activeCustomers =
            $customers->where(
                'status',
                'active'
            )->count();

        $expiredCustomers =
            $customers->where(
                'status',
                'expired'
            )->count();

        /*
        |--------------------------------------------------------------------------
        | VIEW
        |--------------------------------------------------------------------------
        */

        return view(
            'customers.index',
            compact(

                'customers',

                'packages',

                'routers',

                'totalCustomers',

                'activeCustomers',

                'expiredCustomers'

            )
        );
    }

    /*
|--------------------------------------------------------------------------
| CUSTOMER PROFILE
|--------------------------------------------------------------------------
*/

    public function show(Customer $customer)
    {
        /*
        |--------------------------------------------------------------------------
        | SECURITY
        |--------------------------------------------------------------------------
        */

        if (
            auth()->user()->role !== 'admin'
            &&
            $customer->user_id !== auth()->id()
        ) {

            abort(403);

        }

        /*
        |--------------------------------------------------------------------------
        | VOUCHERS
        |--------------------------------------------------------------------------
        */

        $vouchers = Voucher::where(

            'username',

            $customer->username

        )
        ->latest()
        ->get();

        /*
        |--------------------------------------------------------------------------
        | customer SESSIONS
        |--------------------------------------------------------------------------
        */

        // $sessions = VoucherSession::latest()

        //     ->take(20)

        //     ->get();
        $voucherIds = $vouchers->pluck('id');

        $sessions = VoucherSession::whereIn(
                'voucher_id',
                $voucherIds
            )
            ->latest()
            ->take(20)
            ->get();


        /*
|--------------------------------------------------------------------------
| LIVE SESSION
|--------------------------------------------------------------------------
*/

        $liveSession = null;

        /*
        |--------------------------------------------------------------------------
        | CUSTOMER TOTAL SPEND
        |--------------------------------------------------------------------------
        */

        $totalSpend = $vouchers->sum('price');

        /*
        |--------------------------------------------------------------------------
        | VIEW
        |--------------------------------------------------------------------------
        */

        return view(

            'customers.show',

            compact(

                'customer',

                'vouchers',

                'sessions',

                'totalSpend',
                'liveSession'

            )

        );
    }




    /*
    |--------------------------------------------------------------------------
    | UPDATE CUSTOMER
    |--------------------------------------------------------------------------
    */

    public function update(
        Request $request,
        string $id
    ) {

        $customer =
            Customer::findOrFail($id);

        $customer->update([

            'name' =>
                $request->name,

            'phone' =>
                $request->phone,

            'package_id' =>
                $request->package_id,

            'mikrotik_device_id' =>
                $request->mikrotik_device_id,

            'mac_address' =>
                $request->mac_address,

            'expires_at' =>
                $request->expires_at,

        ]);

        return back()->with(

            'success',

            'Customer updated successfully'

        );
    }

    /*
    |--------------------------------------------------------------------------
    | DELETE CUSTOMER
    |--------------------------------------------------------------------------
    */

    public function destroy(string $id)
    {
        $customer =
            Customer::findOrFail($id);

        $customer->delete();

        return back()->with(

            'success',

            'Customer deleted successfully'

        );
    }
}

