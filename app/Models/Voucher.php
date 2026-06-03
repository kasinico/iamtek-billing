<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    protected $fillable = [
        'code',//Printed voucher code
        'username',
        'password',
        'package_id',
        'user_id',
        'router_id',
        'status',
        'duration',
        'bandwidth',
        'used_at',
        'activated_at',
        'expires_at',
        'is_pushed',
        'router_response',
        'sync_error',
        'batch_id',
        'created_by',
        'price',

        'commission_percentage',
        'commission_amount',
        'shopkeeper_amount',


    ];


/*
|--------------------------------------------------------------------------
| CASTS
|--------------------------------------------------------------------------
*/

protected $casts = [

    'expires_at' => 'datetime',

    'activated_at' => 'datetime',

    'used_at' => 'datetime',
    
     'price' => 'decimal:2',

    'commission_amount' => 'decimal:2',

    'shopkeeper_amount' => 'decimal:2',

];



    /**
     * Router relationship
     */
     /**
     * Package relationship
     */
    public function package()
    {
        return $this->belongsTo(Package::class);
    }

    public function router()
    {
        return $this->belongsTo(MikrotikDevice::class, 'router_id');
    }

   
    /**
     * User who generated voucher
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

     public function scopeVisibleToUser($query)
    {
        if (auth()->check() && auth()->user()->role === 'admin') {
            return $query;
        }

        return $query->where('user_id', auth()->id());
    }

/*
|--------------------------------------------------------------------------
| VOUCHER OWNER
|--------------------------------------------------------------------------
*/

    public function creator()
    {
        return $this->belongsTo(
            \App\Models\User::class,
            'created_by'
        );
    }

    // reusable scope in Voucher model

    public function scopeRevenueEligible($query)
{
    return $query->whereIn(
        'status',
        ['active', 'expired']
    );
}


}
