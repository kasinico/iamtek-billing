<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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

