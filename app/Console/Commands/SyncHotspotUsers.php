<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\VoucherSession;
use App\Models\MikrotikDevice;
use App\Models\Voucher;
use App\Models\Customer;

use RouterOS\Client;
use RouterOS\Query;

class SyncHotspotUsers extends Command
{
    protected $signature = 'hotspot:sync';

    protected $description =
        'Sync MikroTik hotspot users with Laravel vouchers';

    public function handle()
    {
        /*
        |--------------------------------------------------------------------------
        | ACTIVE ROUTERS
        |--------------------------------------------------------------------------
        */

        $routers =
            MikrotikDevice::where(
                'is_active',
                1
            )->get();

        /*
        |--------------------------------------------------------------------------
        | LOOP ROUTERS
        |--------------------------------------------------------------------------
        */

        foreach ($routers as $router) {

            try {

                /*
                |--------------------------------------------------------------------------
                | CONNECT TO MIKROTIK
                |--------------------------------------------------------------------------
                */

                $client = new Client([

                    'host' => $router->ip_address,
                    'user' => $router->username,
                    'pass' => $router->password,
                    'port' => $router->port ?? 8728,

                ]);

                /*
                |--------------------------------------------------------------------------
                | GET ACTIVE HOTSPOT USERS
                |--------------------------------------------------------------------------
                */

                $query =
                    new Query('/ip/hotspot/active/print');

                $activeUsers =
                    $client->query($query)->read();

                /*
                |--------------------------------------------------------------------------
                | USERNAMES
                |--------------------------------------------------------------------------
                */

                $activeUsernames =
                    collect($activeUsers)
                        ->pluck('user')
                        ->toArray();

                $this->info(

                    "Router {$router->name} Active Users: "

                    .

                    json_encode($activeUsernames)

                );

                /*
                |--------------------------------------------------------------------------
                | PROCESS ACTIVE USERS
                |--------------------------------------------------------------------------
                */

                foreach ($activeUsers as $activeUser) {

                    $username =
                        $activeUser['user'] ?? null;

                    if (!$username) {

                        continue;

                    }

                    /*
                    |--------------------------------------------------------------------------
                    | FIND VOUCHER
                    |--------------------------------------------------------------------------
                    */

                    $voucher =
                        Voucher::where(
                            'username',
                            $username
                        )->first();

                    if (!$voucher) {

                        continue;

                    }

                    /*
                    |--------------------------------------------------------------------------
                    | FIRST ACTIVATION
                    |--------------------------------------------------------------------------
                    */

                    if (!$voucher->activated_at) {
                        $voucher->activated_at = now();

                        /*
                        |--------------------------------------------------------------------------
                        | SET EXPIRY
                        |--------------------------------------------------------------------------
                        */

                        if (

                            $voucher->package
                            &&
                            $voucher->package->duration_in_hours

                        ) {

                            $voucher->expires_at =

                                now()->addHours(
                                    $voucher
                                        ->package
                                        ->duration_in_hours

                                );

                        }

                    }

                    /*
                    |--------------------------------------------------------------------------
                    | ACTIVE STATUS
                    |--------------------------------------------------------------------------
                    */

                    $voucher->status = 'active';
                    $voucher->save();

                                /*
            |--------------------------------------------------------------------------
            | CREATE SESSION RECORD
            |--------------------------------------------------------------------------
            */

            VoucherSession::firstOrCreate(

                [

                    'voucher_id' => $voucher->id,

                    'status' => 'active'

                ],

                [

                    'voucher_code' => $voucher->code,

                    'ip_address' =>
                        $activeUser['address']
                        ?? null,

                    'mac_address' =>
                        $activeUser['mac-address']
                        ?? null,

                    'router_id' =>
                        $router->id,

                    'login_at' => now(),

                    'data_used' => 0

                ]

            );


                    /*
                    |--------------------------------------------------------------------------
                    | AUTO CREATE / UPDATE CUSTOMER
                    |--------------------------------------------------------------------------
                    */

                    Customer::updateOrCreate(

                        [

                            'username' =>
                                $voucher->username

                        ],

                        [

                            'user_id' =>
                                $voucher->created_by
                                ?? auth()->id()
                                ?? 1,


                            'name' =>
                                $voucher->username,

                            'phone' =>
                                null,
                            'email' =>
                            null,

                            'connection_type' =>
                                'hotspot',

                            'mikrotik_device_id' =>
                                $router->id,

                            'package_id' =>
                                $voucher->package_id,

                            'status' =>
                                'active',

                            'mac_address' =>
                                $activeUser['mac-address']
                                ?? null,

                            'expires_at' =>
                                $voucher->expires_at

                        ]

                    );

                }

                /*
                |--------------------------------------------------------------------------
                | HANDLE EXPIRED VOUCHERS
                |--------------------------------------------------------------------------
                */

                $expiredVouchers =

                    Voucher::where(
                        'status',
                        'active'
                    )

                    ->whereNotNull(
                        'expires_at'
                    )

                    ->where(
                        'expires_at',
                        '<',
                        now()
                    )

                    ->get();

                foreach ($expiredVouchers as $voucher) 
                    {

                    /*
                    |--------------------------------------------------------------------------
                    | MARK USED
                    |--------------------------------------------------------------------------
                    */

                    $voucher->status = 'used';
                    $voucher->used_at = now();
                    $voucher->save();

                    /*
                    |--------------------------------------------------------------------------
                    | UPDATE CUSTOMER
                    |--------------------------------------------------------------------------
                    */

                    Customer::where(
                        'username',
                        $voucher->username
                    )->update([
                        'status' => 'expired'
                    ]);
                    $voucher->save();

                    VoucherSession::where(
                        'voucher_id',
                        $voucher->id
                    )
                    ->where(
                        'status',
                        'active'
                    )
                    ->update([

                        'status' => 'completed',

                        'logout_at' => now()

                    ]);

                    /*
|--------------------------------------------------------------------------
| UPDATE CUSTOMER
|--------------------------------------------------------------------------
*/

// Customer::where(
//     'username',
//     $voucher->username
// )->update([
//     'status' => 'expired'
// ]);

                    /*
                    |--------------------------------------------------------------------------
                    | OPTIONAL HOTSPOT DISCONNECT
                    |--------------------------------------------------------------------------
                    */

                    try {

                        $removeQuery =
                            new Query(
                                '/ip/hotspot/active/remove'
                            );

                        /*
                        |--------------------------------------------------------------------------
                        | FIND ACTIVE SESSION
                        |--------------------------------------------------------------------------
                        */

                        foreach (

                            $activeUsers

                            as

                            $activeUser

                        ) {

                            if (

                                ($activeUser['user'] ?? null)

                                ===

                                $voucher->username

                            ) {

                                $removeQuery->equal(

                                    '.id',

                                    $activeUser['.id']

                                );

                                $client
                                    ->query($removeQuery)
                                    ->read();

                            }

                        }

                    } catch (\Throwable $e) {

                        // ignore disconnect errors

                    }

                }

            } catch (\Throwable $e) {

                $this->error(

                    "Router {$router->name} Error: "

                    .

                    $e->getMessage()

                );

            }

        }

        $this->info('Hotspot sync complete');
    }
}

