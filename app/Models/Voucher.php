<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    //
    protected $fillable = [
        'code',
        'package_id',
        'user_id',
        'status',
        'used_at'
    ];
}
