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
        // Commands\Inspire::class,
		'App\Console\Commands\scheduleLog',
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
 
        $schedule->call(function () {
             \Log::info('tlog scheduler called at Asia/Kolkata.....');
            app('App\Http\HomeController\sendEmailNotification')->process();
        })->daily()->timezone('America/Denver');

    }
}
