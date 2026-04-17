<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MikrotikDevice extends Model
{
    protected $table = 'mikrotik_devices';

    protected $fillable = [
        'name',
        'ip_address',
        'username',
        'password',
        'port'
    ];
}