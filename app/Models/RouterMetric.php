<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RouterMetric extends Model
{
    protected $fillable = [

        'mikrotik_device_id',
        'is_online',
        'wan_ip',
        'uptime',
        'cpu_usage',
        'ram_usage',
        'active_users',
        'rx_bytes',
        'tx_bytes',
        'last_seen_at',

    ];

    public function router()
    {
        return $this->belongsTo(MikrotikDevice::class);
    }
}