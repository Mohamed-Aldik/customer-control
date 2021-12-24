<?php

namespace App\Http\Controllers\API;

use App\Attendance;
use App\Http\Controllers\Controller;
use App\Payroll;
use Carbon\Carbon;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function paySlip(Request $request)
    {

        $request->validate([
            'year_month' => 'required|date_format:Y-m'
        ]);

        $payroll = Payroll::where('year_month', $request->year_month)->first();


        if (isset($payroll)){
            $salary = $payroll->salaries->where('employee_id', auth()->user()->id)->first();
            $employee = auth()->user();

            $paySlip = [
                'name' => $employee->name(),
                'job_number' => $employee->job_number,
                'job_title' => $employee->job_title_name,
                'joining_date' => $employee->contract_start_date->format('Y-m-d'),
                'salary' => $employee->salary,
                'additions' => $employee->totalAdditionAllowances(),
                'deductions' => $salary->deductions,
                'net_salary' => $salary->net_salary,
            ];

            return response()->json($paySlip);
        }else{
            return response()->json(['status' => 0, 'message' => 'There is no paySlip for month ' . $request->year_month]);
        }





   }

    public function jobInfo()
    {
        $employee = auth()->user();
        $workingDays = Attendance::where('employee_id', $employee->id)->whereNotNull(['time_in', 'time_out'])->count();
        $officialWorkingDays = $employee->contract_end_date->diffInDays($employee->contract_start_date);
        $availableBalance = $employee->available_balance;

        if($availableBalance > 0){
            $balancePercentage = ($availableBalance/$employee->leave_balance) * 100;
        }else{
            $balancePercentage = 0;
            $availableBalance = 0;
        }

        if($officialWorkingDays > 0){
            $presentPercentage = ($workingDays/$officialWorkingDays) * 100;
        }else{
            $presentPercentage = 0;
        }

        $numberOfDaysFromNow = Carbon::today()->diffInDays($employee->contract_start_date); // 39
        $numberOfWeeks = intval($numberOfDaysFromNow/7);
        $numberOfOfficialAbsent = $numberOfWeeks * $employee->weeklyDaysOff();
        $absentDays = $numberOfDaysFromNow - $numberOfOfficialAbsent;

        $absentPercentage = ($absentDays/30) * 100;

        return response()->json([
            'working_days' => intval($workingDays),
            'working_hours' => 240,
            'available_balance' => intval($availableBalance),
            'number_of_leaves' => \App\Request::where([['employee_id', '=', $employee->id], ['requestable_type', '=', 'App\Vacation']])->count(),
            'balance_percentage' => intval($balancePercentage),
            'present_percentage' => intval($presentPercentage),
            'absent_percentage' => $absentPercentage > 100 ? 100 : intval($absentPercentage),
        ]);


    }
}
