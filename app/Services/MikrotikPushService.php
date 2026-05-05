<?php

namespace App\Services;

use RouterOS\Client;
use RouterOS\Query;
use App\Models\Voucher;

class MikrotikPushService
{
    public function pushVoucher(Voucher $voucher)
    {
        $this->ensureProfileExists($voucher);
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
            $query->equal('profile', $voucher->package->mikrotik_profile ?? 'default'); //profile assigned to the package.This controls speed/time policy on MikroTik

            // $query->equal('profile', 'default');
            $query->equal('limit-uptime', $voucher->duration . 'h');
            $query->equal('comment', 'VOUCHER-' . $voucher->id);

            $client->query($query);

            $response = $client->read();

            return $response;

        } catch (\Throwable $e) {
            throw new \Exception("MikroTik PUSH FAILED: " . $e->getMessage());
        }
    }
    public function ensureProfileExists($voucher)
    {
        $profileName = $voucher->package->mikrotik_profile;
        $rateLimit   = $voucher->package->bandwidth ?? '2M/2M';

        $check = new Query('/ip/hotspot/user/profile/print');
        $check->where('name', $profileName);

        $result = $this->client->query($check)->read();

        if (empty($result)) {

            $create = new Query('/ip/hotspot/user/profile/add');
            $create->equal('name', $profileName);
            $create->equal('rate-limit', $rateLimit);

            $this->client->query($create)->read();
        }
    }
}