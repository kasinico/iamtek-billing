<?php

namespace App\Console\Commands;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;

use App\Models\Voucher;
use App\Services\MikrotikPushService;
use RouterOS\Client;
use RouterOS\Query;

use App\Models\MikrotikDevice;
use App\Models\Package;


class ExpireVouchers extends Command
{
    protected $signature = 'vouchers:expire';
    protected $description = 'Expire used vouchers and remove from MikroTik';

    public function handle()
    {
        $expired = Voucher::where('status', 'active')
            ->whereNotNull('expires_at')
            ->where('expires_at', '<=', now())
            ->get();

        foreach ($expired as $voucher) {

            try {

                $router = $voucher->router;

                $client = new Client([
                    'host' => $router->ip_address,
                    'user' => $router->username,
                    'pass' => $router->password,
                    'port' => $router->port ?? 8728,
                ]);

                // 🔥 REMOVE USER FROM ROUTER
                $remove = new Query('/ip/hotspot/user/remove');
                $remove->where('name', $voucher->username);
                $client->query($remove)->read();

                // 🔥 UPDATE STATUS
                $voucher->status = 'expired';
                $voucher->save();

                $this->info("Expired: {$voucher->username}");

            } catch (\Throwable $e) {
                $this->error($e->getMessage());
            }
        }

        return 0;
    }
}