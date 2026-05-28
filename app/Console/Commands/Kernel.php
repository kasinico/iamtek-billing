<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Register the commands for the application.
     */
    protected $commands = [
        \App\Console\Commands\MikrotikTest::class,
        \App\Console\Commands\SyncHotspotUsers::class,
        \App\Console\Commands\ExpireVouchers::class, // 🔥 ADD THIS
        \App\Console\Commands\PollRouters::class,

    ];

    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        $schedule->command('hotspot:sync')->everyMinute();

        $schedule->command('vouchers:expire')->everyMinute();
        $schedule->command('routers:poll')
            ->everyFiveMinutes();
        //
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
    
}