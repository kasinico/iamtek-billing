<?php

namespace App\Console\Commands;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;

#[Signature('app:expire-vouchers')]
#[Description('Command description')]
class ExpireVouchers extends Command
{
    /**
     * Execute the console command.
     */
    public function handle()
    {
        Voucher::where('status','used')
        ->where('expires_at','<',now())
        ->update(['status'=>'expired']);
        //
    }
}
