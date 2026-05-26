<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    //
    protected $fillable = [

    'user_id',

    'amount',

    'status',

    'starts_at',

    'ends_at',

    'duration_type',

    'duration_value',

    'activated_by',

];
}
