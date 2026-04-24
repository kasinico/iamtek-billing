<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    protected $fillable = [
        'name',
        'price',
        'duration',
        'bandwidth',
        'type' // hr, day, week, month
    ];
}