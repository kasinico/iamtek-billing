<?php

namespace App\Console\Commands;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;


use App\Models\MikrotikDevice;
use App\Models\RouterStatus;

use RouterOS\Client;
use RouterOS\Query;




class PollRouters extends Command
{
    
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'routers:poll';

    /**
     * The console command description.
     */
    protected $description =
        'Poll MikroTik routers for monitoring';


    
public function handle()
{
    $routers = MikrotikDevice::where(
        'is_active',
        1
    )->get();

    foreach ($routers as $router) {

        try {

            $client = new Client([

                'host' => $router->ip_address,
                'user' => $router->username,
                'pass' => $router->password,
                'port' => $router->port,
                'legacy' => false

                

            ]);

            /*
            |--------------------------------------------------------------------------
            | SYSTEM RESOURCE
            |--------------------------------------------------------------------------
            */

            $resourceQuery =
                new Query('/system/resource/print');

            $resource =
                $client->query($resourceQuery)->read();

            /*
            |--------------------------------------------------------------------------
            | HOTSPOT USERS
            |--------------------------------------------------------------------------
            */

            $hotspotQuery =
                new Query('/ip/hotspot/active/print');

            $hotspotUsers =
                $client->query($hotspotQuery)->read();

            /*
            |--------------------------------------------------------------------------
            | ROUTER IDENTITY
            |--------------------------------------------------------------------------
            */

            $identityQuery =
                new Query('/system/identity/print');

            $identity =
                $client->query($identityQuery)->read();

            /*
            |--------------------------------------------------------------------------
            | SAVE STATUS
            |--------------------------------------------------------------------------
            */

            RouterStatus::updateOrCreate(

                [

                    'mikrotik_device_id' => $router->id

                ],

                [

                    'is_online' => true,

                    'identity' =>
                        $identity[0]['name'] ?? null,

                    'cpu_load' =>
                        $resource[0]['cpu-load'] ?? 0,

                    'free_memory' =>
                        $resource[0]['free-memory'] ?? 0,

                    'total_memory' =>
                        $resource[0]['total-memory'] ?? 0,

                    'uptime' =>
                        $resource[0]['uptime'] ?? null,

                    'active_hotspot_users' =>
                        count($hotspotUsers),

                    'last_seen_at' => now()

                ]

            );

            $this->info(
                "Router {$router->name} online"
            );

        } catch (\Exception $e) {

            RouterStatus::updateOrCreate(

                [

                    'mikrotik_device_id' => $router->id

                ],

                [

                    'is_online' => false

                ]

            );

            $this->error(
                "Router {$router->name} offline: " . 
                $e->getMessage()
            );
        }
    }

    $this->info('Router polling complete.');
}


}
