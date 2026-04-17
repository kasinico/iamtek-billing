<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VoucherBatch extends Model
{
    protected $fillable = [
        'batch_name',
        'quantity',
        'total_value'
    ];

    public function vouchers()
    {
        return $this->hasMany(Voucher::class,'batch_id');
    }
}