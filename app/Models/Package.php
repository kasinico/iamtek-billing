<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    /**
     * Mass assignable fields
     */
    protected $fillable = [
        'user_id',            // who owns the package (admin or shopkeeper)

        'name',               // e.g "1 Hour Unlimited"
        'price',              // UGX price

        'duration',           // numeric value (e.g 1, 24, 7)
        'duration_unit',               // hr, day, week, month

        'bandwidth',          // e.g "2M/2M" (UI display + optional use)

        'mikrotik_profile',   // VERY IMPORTANT → links to router speed control

        'active',          // enable/disable package
    ];

    /**
     * Convert duration + type into hours
     * Used when calculating expiry
     */
    public function getDurationInHoursAttribute()
    {
        return match ($this->duration_unit) {
            'hour' => $this->duration,
            'day' => $this->duration * 24,
            'week' => $this->duration * 24 * 7,
            'month' => $this->duration * 24 * 30,
            default => $this->duration,
        };
    }


/*
|--------------------------------------------------------------------------
| OWNER
|--------------------------------------------------------------------------
*/

 // linking user to routers table
    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }


    // linking user to routers table
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function metrics()
    {
        return $this->hasOne(RouterMetric::class);
    }

    
    public function status()
    {
        return $this->hasOne(RouterStatus::class);
    }



}