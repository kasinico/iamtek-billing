<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VoucherSession extends Model
{
    protected $fillable = [
        'voucher_id',
        'voucher_code',
        'ip_address',
        'mac_address',
        'router_id',
        'login_at',
        'logout_at',
        'status',
        'data_used'
    ];
}