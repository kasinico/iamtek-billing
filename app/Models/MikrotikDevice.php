<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MikrotikDevice extends Model
{
    protected $table = 'mikrotik_devices';

    protected $fillable = [
        'user_id',
        'name',
        'ip_address',
        'username',
        'password',
        'port',
        'is_active',
    ];

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
