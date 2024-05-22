<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('app:delete-appointment-when-created-at-matches')
            ->everyMinute()
            ->timezone('Africa/Cairo');
        $schedule->command('app:delete-booking-taxi-when-time-match-now')
            ->everyMinute()
            ->timezone('Africa/Cairo');
        $schedule->command('app:delete-booking-restaurant-when-created-at-matches')
            ->everyMinute()
            ->timezone('Africa/Cairo');
        $schedule->command('app:delete-room-bookings-when-minute-matches')
            ->everyMinute()
            ->timezone('Africa/Cairo');
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
