<?php

namespace App\Console\Commands;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;


use App\Models\MikrotikDevice;
use App\Models\Voucher;
use RouterOS\Client;
use RouterOS\Query;

class SyncHotspotUsers extends Command
{
    protected $signature = 'hotspot:sync';
    protected $description = 'Sync MikroTik hotspot users with Laravel vouchers';

    public function handle()
    {
        $routers = MikrotikDevice::where('is_active', 1)->get();

        foreach ($routers as $router) {

            try {

                $client = new Client([
                    'host' => $router->ip_address,
                    'user' => $router->username,
                    'pass' => $router->password,
                    'port' => $router->port ?? 8728,
                ]);

                $query = new Query('/ip/hotspot/active/print');
                $activeUsers = $client->query($query)->read();

                $activeUsernames = collect($activeUsers)->pluck('user')->toArray();

                // DEBUG
                $this->info('Active users: ' . json_encode($activeUsernames));

                // ACTIVE
                Voucher::whereIn('username', $activeUsernames)
                    ->update(['status' => 'active']);

                // USED
                Voucher::whereNotIn('username', $activeUsernames)
                    ->where('status', 'active')
                    ->update(['status' => 'used']);

            } catch (\Throwable $e) {

                $this->error("Router {$router->name}: " . $e->getMessage());

            }
        }

        $this->info('Sync complete');
    }
}