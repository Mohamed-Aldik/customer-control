<?php

namespace App\Console\Commands;

use App\Resignation;
use App\SuspendedSalary;
use Carbon\Carbon;
use Illuminate\Console\Command;

class SuspendSalary extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'salary:suspend';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Suspend salary for employees';

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
        $resignations = Resignation::get();

        $today = Carbon::today();
        foreach ($resignations as $resignation){
            // if termination date after 35 days or less from now then suspend the salary for the employee
            $terminationDate = $resignation->termination_date;
            $terminationDate = Carbon::parse($terminationDate);
            $employeeID = $resignation->request->employee_id;

            if ($terminationDate->diffInDays(Carbon::now()) <= 35){
                if(SuspendedSalary::where([['employee_id', $employeeID],['to', $resignation->termination_date]])->doesntExist()){
                    SuspendedSalary::create([
                        'employee_id' => $resignation->request->employee_id,
                        'from' => Carbon::now()->format('Y-m-d'),
                        'to' => $resignation->termination_date,
                    ]);
                }
            }
        }
        return 0;
    }
}
