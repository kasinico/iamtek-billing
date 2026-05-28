<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = [

        'user_id',

        'name',

        'phone',

        'email',

        'username',

        'connection_type',

        'mikrotik_device_id',

        'package_id',

        'status',

        'mac_address',

        'expires_at'

    ];

    /*
    |--------------------------------------------------------------------------
    | CASTS
    |--------------------------------------------------------------------------
    */

    protected $casts = [

        'expires_at' => 'datetime'

    ];

    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIPS
    |--------------------------------------------------------------------------
    */

    public function router()
    {
        return $this->belongsTo(
            MikrotikDevice::class,
            'mikrotik_device_id'
        );
    }

    public function package()
    {
        return $this->belongsTo(
            Package::class
        );
    }

    public function owner()
    {
        return $this->belongsTo(
            User::class,
            'user_id'
        );
    }
}
