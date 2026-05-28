<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RouterStatus extends Model
{
    //
    protected $fillable = [ 
        'mikrotik_device_id', 
        'is_online', 
        'identity', 
        'wan_ip', 
        'cpu_load', 
        'free_memory', 
        'total_memory', 
        'uptime', 
        'active_hotspot_users', 
        'last_seen_at' 

        ]; 
    public function router() 
    { 
        return $this->belongsTo(MikrotikDevice::class); 
        }
}
