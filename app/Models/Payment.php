<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    //
    protected $fillable = [
    'tx_ref',
    'phone',
    'network',
    'amount',
    'status',
    'package_id'
];
}
