<?php

namespace App\Services;

use RouterOS\Client;
use RouterOS\Query;
use App\Models\Voucher;

class MikrotikPushService
{
    public function pushVoucher(Voucher $voucher)
    {
        $router = $voucher->router;

        if (!$router) {
            throw new \Exception("Router not assigned");
        }

        // DEBUG (safe place)
        // dd($router->ip_address, $router->username);

        $client = new Client([
            'host' => $router->ip_address,
            'user' => $router->username,
            'pass' => $router->password,
            'port' => $router->port ?? 8728,
        ]);

        try {
            $client->connect();

            $query = new Query('/ip/hotspot/user/add');

            $query->equal('name', $voucher->username);
            $query->equal('password', $voucher->password);
            $query->equal('profile', 'default');
            $query->equal('comment', 'VOUCHER-' . $voucher->id);

            $client->query($query);

            $response = $client->read();

            return $response;

        } catch (\Throwable $e) {
            throw new \Exception("MikroTik PUSH FAILED: " . $e->getMessage());
        }
    }
}