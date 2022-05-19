<?php

namespace App\Console;

use App\Console\Commands\ClientCron;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{

    protected $commands = [
        ClientCron::class
    ];


    protected function schedule(Schedule $schedule)
    {
        $schedule->command('client:cron')
            ->daily();
    }

    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
