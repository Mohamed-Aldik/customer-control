<?php

namespace App\Console;

use App\Console\Commands\EndService;
use App\Console\Commands\IncrementVacationBalance;
use App\Console\Commands\LateEmployeesNotification;
use App\Console\Commands\SuspendSalary;
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
        LateEmployeesNotification::class,
        EndService::class,
        IncrementVacationBalance::class,
        SuspendSalary::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();
        $schedule->command('lateEmployees:notify')->dailyAt('20:00')->timezone('Asia/Riyadh');
        $schedule->command('service:check')->dailyAt('23:35')->timezone('Asia/Riyadh');
        $schedule->command('vacation_balance:increment')->daily();
        $schedule->command('salary:suspend')->daily();
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
