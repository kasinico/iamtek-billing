<?php

namespace App\Services;

use RouterOS\Client;
use RouterOS\Query;
use App\Models\Voucher;

class MikrotikPushService
{
    /**
     * PUSH VOUCHER TO MIKROTIK
     */
    public function pushVoucher(Voucher $voucher)
    {
        $router = $voucher->router;

        if (!$router) {
            throw new \Exception("Router not assigned");
        }

        $client = new Client([
            'host' => $router->ip_address,
            'user' => $router->username,
            'pass' => $router->password,
            'port' => $router->port ?? 8728,
            'timeout' => 2, 
        ]);

        try {

            // 🔥 Ensure profile exists before creating user
            $this->ensureProfileExists($client, $voucher);

            // 🔥 Remove existing user (avoid duplicate error)
            $remove = new Query('/ip/hotspot/user/remove');
            $remove->where('name', $voucher->username);
            $client->query($remove)->read();

            // 🔥 Create hotspot user
            $query = new Query('/ip/hotspot/user/add');

            $query->equal('name', $voucher->username);
            $query->equal('password', $voucher->password);
            $query->equal('profile', $voucher->package->mikrotik_profile ?? 'default');

            // 🔥 Convert duration properly
            $hours = $this->convertToHours($voucher->package);
            $query->equal('limit-uptime', $hours . 'h');

            $query->equal('comment', 'VOUCHER-' . $voucher->id);

            $response = $client->query($query)->read();

            logger('Voucher pushed: ' . $voucher->username);

            return $response;

        } catch (\Throwable $e) {

            logger('MikroTik ERROR: ' . $e->getMessage());

            throw new \Exception("MikroTik PUSH FAILED: " . $e->getMessage());
        }
    }

    /**
     * CREATE PROFILE IF NOT EXISTS (USED DURING VOUCHER CREATION)
     */
    public function ensureProfileExists($client, $voucher)
    {
        $profileName = $voucher->package->mikrotik_profile ?? 'default';
        $rateLimit   = $voucher->package->bandwidth ?? '2M/2M';

        $check = new Query('/ip/hotspot/user/profile/print');
        $check->where('name', $profileName);

        $result = $client->query($check)->read();

        if (empty($result)) {

            logger("Creating MikroTik profile (voucher): " . $profileName);

            $create = new Query('/ip/hotspot/user/profile/add');
            $create->equal('name', $profileName);
            $create->equal('rate-limit', $rateLimit);

            // 🔥 Apply session timeout
            $hours = $this->convertToHours($voucher->package);
            $create->equal('session-timeout', $hours . 'h');

            $client->query($create)->read();
        }
    }

    /**
     * CREATE PROFILE WHEN PACKAGE IS CREATED
     */
    public function createProfileFromPackage($router, $package)
    {
        $client = new Client([
            'host' => $router->ip_address,
            'user' => $router->username,
            'pass' => $router->password,
            'port' => $router->port ?? 8728,
            'timeout' => 2,
        ]);

        $profileName = $package->mikrotik_profile ?? 'default';
        $rateLimit   = $package->bandwidth ?? '2M/2M';

        $check = new Query('/ip/hotspot/user/profile/print');
        $check->where('name', $profileName);

        $result = $client->query($check)->read();

        if (empty($result)) {

            logger("Creating MikroTik profile (package): " . $profileName);

            $create = new Query('/ip/hotspot/user/profile/add');
            $create->equal('name', $profileName);
            $create->equal('rate-limit', $rateLimit);

            // 🔥 Apply correct session timeout
            $hours = $this->convertToHours($package);
            $create->equal('session-timeout', $hours . 'h');

            $client->query($create)->read();
        }
    }

    /**
     * 🔥 CONVERT ANY DURATION TO HOURS (VERY IMPORTANT)
     */
    public function convertToHours($package)
    {
        return match ($package->duration_unit) {
            'hour'  => $package->duration,
            'day'   => $package->duration * 24,
            'week'  => $package->duration * 24 * 7,
            'month' => $package->duration * 24 * 30,
            default => $package->duration,
        };
    }


    public function updateProfileOnRouter($router, $package)
    {
        $client = new Client([
            'host' => $router->ip_address,
            'user' => $router->username,
            'pass' => $router->password,
            'port' => $router->port ?? 8728,
            'timeout' => 2,
        ]);

        $profileName = $package->mikrotik_profile;

        $print = new Query('/ip/hotspot/user/profile/print');
        $print->where('name', $profileName);

        $result = $client->query($print)->read();

        if (!empty($result)) {

            $id = $result[0]['.id'];

            $update = new Query('/ip/hotspot/user/profile/set');
            $update->equal('.id', $id);

            $update->equal('rate-limit', $package->bandwidth ?? '2M/2M');

            $hours = $this->convertToHours($package);
            $update->equal('session-timeout', $hours . 'h');

            $client->query($update)->read();

            logger("Profile updated: " . $profileName);
        }
    }
}
    // public function ensureProfileExists($client, $voucher)
    // {
    //     $profileName = $voucher->package->mikrotik_profile ?? 'default';
    //     $rateLimit   = $voucher->package->bandwidth ?? '2M/2M';

    //     // 🔍 Check if profile exists
    //     $check = new Query('/ip/hotspot/user/profile/print');
    //     $check->where('name', $profileName);

    //     $result = $client->query($check)->read();

    //     // 🆕 Create if missing
    //     if (empty($result)) {

    //         $create = new Query('/ip/hotspot/user/profile/add');
    //         $create->equal('name', $profileName);
    //         $create->equal('rate-limit', $rateLimit);

    //         $client->query($create)->read();

    //         logger("Created MikroTik profile: " . $profileName);
    //     }
    // }
