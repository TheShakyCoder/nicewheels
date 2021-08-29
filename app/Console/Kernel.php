<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('ebay:poll')->everyThirtyMinutes();
        $schedule->command('ebay:get')->everyThirtyMinutes();
        $schedule->command('ebay:finish')->everyFifteenMinutes();
        $schedule->command('fig:update')->cron('40 23 * * *');
        $schedule->command('static:compile')->cron('50 23 * * *');
        $schedule->command('static:filter')->daily();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
