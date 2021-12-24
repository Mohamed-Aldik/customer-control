<?php

namespace App\Console\Commands;

use App\Employee;
use App\Scopes\ParentScope;
use App\Scopes\ProviderScope;
use App\Scopes\ServiceStatusScope;
use App\Scopes\SupervisorScope;
use Carbon\Carbon;
use Illuminate\Console\Command;

class IncrementVacationBalance extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'vacation_balance:increment';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Increment available vacation balance to all employees';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $employees = Employee::withoutGlobalScopes([
            ParentScope::class,
            ProviderScope::class,
            \App\Scopes\CompletedScope::class])->get();

        foreach ($employees as $employee){
            $dailyBalance = $employee->leave_balance / 365;

            if(\Carbon\Carbon::today()->lt($employee->contract_end_date)){
                $availableBalance = $employee->available_balance + $dailyBalance;
            }

            $employee->update([
                'available_balance' => number_format($availableBalance, 2)
            ]);

        }

        return 0;
    }
}
