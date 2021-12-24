<?php

namespace App\Http\Controllers\Dashboard;

use App\Company;
use App\Department;
use App\Employee;
use App\EmployeeViolation;
use App\Http\Controllers\Controller;
use App\Nationality;
use App\Payroll;
use App\Provider;
use App\Request as AppRequest;
use App\Rules\UniqueMonth;
use App\Salary;
use App\Section;
use App\Vacation;
use Box\Spout\Writer\Style\StyleBuilder;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Rap2hpoutre\FastExcel\FastExcel;

class PayrollController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:employee,company,provider');
    }

    public function index()
    {
        $this->authorize('view_payrolls');
        $providers = Provider::get();
        return view('dashboard.payrolls.index', [
            'payrolls' => Payroll::orderBy('year_month', 'asc')->paginate(12),
            'providers' => $providers
        ]);
    }

    public function pending(Request $request)
    {
        $this->authorize('view_payrolls');
        $pending_reports = Payroll::where('status', 0)->get();
        if ($request->ajax()) {
            return response()->json($pending_reports);
        }
        return view('dashboard.payrolls.pending');
    }


    public function create()
    {
        $this->authorize('create_payrolls');
        $providers = Provider::get();
        return view('dashboard.payrolls.create', compact('providers'));
    }


    public function store(Request $request)
    {
        $this->authorize('create_payrolls');
        $request->validate(['year_month' => ['required', new UniqueMonth($request->provider_id)]]);
        $payrollDay = setting('payroll_day') ?? 30;
        $employees = isset($payroll->provider_id) ? Employee::where('provider_id', $payroll->provider_id)->get() : Employee::get();

        $total_deductions = $employees->map(function ($employee) {
            return $employee->deductions() + $employee->gosiDeduction();
        })->sum();


        $payroll = Payroll::create([
            'provider_id'        => $request->provider_id,
            'year_month'         => $request->year_month,
            'date'               => $request->year_month . '-'  . Carbon::now()->format('d'),
            'issue_date'         => Carbon::now()->toDateTimeString(),
            'employees_no'       => $employees->count(),
            'total_deductions'   => $total_deductions,
            'include_attendance' => $request->has('include_attendance'),
        ]);
        $payroll->update([
            'total_net_salary' => $payroll->salaries->pluck('net_salary')->sum(),
        ]);

        return redirect(route('dashboard.payrolls.index'));
    }


    public function show(Payroll $payroll, Request $request)
    {
        $this->authorize('show_payrolls');



        if ($request->ajax()) {

            ////////////////////////////


            $salaries = Salary::where('payroll_id', $payroll->id)->get()->map(function ($salary) use ($payroll) {
                $payroll2 = Payroll::find($salary->payroll_id);
                $date = strtotime($payroll2->year_month);
                $y_m = date('Y-m', $date);
                $y_m = explode('-', $y_m);

                $employee = $salary->employee;

                $extra_hours        = $employee->value_Extra_hours_from_payroll($salary->payroll_id);
                $financial_movement = $employee->value_financial_from_payroll($salary->payroll_id);

                $employee->discount_repair();
                $deductions = $employee->deductions($payroll2->year_month);

                $gosiDeduction = $employee->gosiDeduction();
                $officialWorkingHours = 240;

                $request0 = AppRequest::where([
                    'requestable_type' => 'App\Vacation',
                    'employee_id' => $employee->id,
                    'status' => 1
                ])->get();

                // شسيشسيسشيسشيسشي
                $advance_salary = 0;
                $daysOff = 0;
                foreach ($request0 as $req) {
                    $vacation = Vacation::where('id', $req->requestable_id)->whereYear('start_date', $y_m[0])->whereMonth('start_date', $y_m[1])->whereNotIn('vacation_type_id', [1, 2, 3, 10])->get();
                    foreach ($vacation as $v) {
                        $advance_salary += $v->advance_salary;
                        $daysOff        += $v->total_days;
                    }
                }

                $Vacation_salary_deduction = 0;
                foreach ($request0 as $req) {
                    $vacation = Vacation::where('id', $req->requestable_id)->whereYear('start_date', $y_m[0])->whereMonth('start_date', $y_m[1])->where('vacation_type_id', 10)->get();
                    foreach ($vacation as $v) {
                        $Vacation_salary_deduction += $v->available_after * ($employee->totalPackage() / 30);
                    }
                }
                // complet this
                //$Vacation_salary_deduction = $Vacation_salary_deduction - ($employee->deductions() + $employee->gosiDeduction());



                $percent = 0;
                $sick_leave = 0;
                if ($employee->sick_leave_used() > 30) {

                    $check_sick_used_in_month = 0;
                    foreach ($request0 as $req) {
                        $vacation = Vacation::where('id', $req->requestable_id)->whereYear('start_date', $y_m[0])->whereMonth('start_date', $y_m[1])->whereIn('vacation_type_id', [1, 2, 3])->get();
                        foreach ($vacation as $v) {
                            $check_sick_used_in_month++;
                        }
                    }

                    if ($check_sick_used_in_month >= 1) {

                        if ($employee->sick_leave_used() >= 31) {
                            $percent = 25;
                        }

                        if ($employee->sick_leave_used() >= 91) {
                            $percent = 100;
                        }
                    }
                }
                $sick_leave = (($percent / 100) * $salary->net_salary);


                $hoursbover = ($extra_hours+$financial_movement);

                //$request0 = AppRequest::whereYear('','')->whereMonth('','')->get();
                $total_deduction = ($gosiDeduction + $deductions + $sick_leave + $advance_salary + $employee->totalOtherDeduction());
                if (!$employee->isSalarySuspended($payroll->date)) {
                    return [
                        'id' => $salary->id,
                        'advance_salary' => $advance_salary,
                        'Vacation_salary_deduction' => $Vacation_salary_deduction,
                        'job_number' => $employee->job_number,
                        'employee_name' => $employee->name(),
                        'supervisor' => $employee->supervisor_name,
                        'department' => $employee->department_name,
                        'section' => $employee->section_name,
                        'provider' => $employee->provider_name,
                        'nationality' => $employee->nationality_name,
                        'employee_id' => $employee->id,
                        'salary' => number_format($employee->salary, 2),
                        'officialWorkingHours' => $officialWorkingHours,
                        'hourly_wage' => number_format($employee->totalPackage() / $officialWorkingHours, 2),
                        'hra' => $employee->hra(),
                        'transfer' => $employee->transfer(),
                        'other_allowances' => $employee->otherAllowances(),
                        'total_allowances' => number_format($employee->totalAdditionAllowances(), 2),
                        'total_package' => number_format($employee->totalPackage(), 2),
                        'violations_deduction' => number_format($deductions, 2),
                        'gosi_deduction' => $gosiDeduction,
                        'sick_leave_discount' => number_format($sick_leave, 2),
                        'other_deduction' => number_format($employee->totalOtherDeduction(), 2),
                        'total_deduction' => number_format($total_deduction, 2),
                        'net_pay' => number_format(($employee->totalPackage() - $total_deduction + $hoursbover), 2),
                        'work_days' => ($salary->work_days - $daysOff),
                        'financial_move' => $payroll2->financial_move,
                        'financial_movement' => number_format($financial_movement, 2),
                        'extra_hours' => (object) [
                            'id'=>1,
                            'value'=>number_format($extra_hours, 2)
                          ],
                    ];
                }
            })->filter();
            return response()->json($salaries);


            //////////////////////////

        }
        return view('dashboard.payrolls.show', [
            'payroll' =>  $payroll,
            'supervisors' =>  Company::supervisors(),
            'nationalities' => Nationality::get(),
            'providers' => Provider::get(),
            'departments' => Department::get(),
            'sections' => Section::get(),
        ]);
    }


    public function reissue(Request $request, Payroll $payroll)
    {

        $this->authorize('proceed_payrolls');
        $payroll->salaries()->delete();
        $employees = isset($payroll->provider_id) ? Employee::where('provider_id', $payroll->provider_id)->get() : Employee::get();
        $payrollDay = setting('payroll_day') ?? 30;
        $totalDeductions = $employees->map(function ($employee) {
            return $employee->deductions() + $employee->gosiDeduction();
        })->sum();
        $payroll->update([
            'date'               => $payroll->year_month->format('Y-m') . '-' . Carbon::now()->format('d'),
            'issue_date'         => Carbon::now()->toDateTimeString(),
            'employees_no'       => $employees->count(),
            'total_deductions'   => $totalDeductions,
            'include_attendance' => $request->has('include_attendance'),
        ]);

        foreach ($employees as $employee) {
            $settingWorkDays = Company::settingWorkdays() ?? 30;
            $workDays = $payroll->include_attendance ? $employee->workDays($payroll->date->month) : $settingWorkDays;

            $deductions = $employee->deductions() + $employee->gosiDeduction();
            $netPay = $workDays * ($employee->totalPackage() / 30);
            $netPay = $netPay - $deductions;

            Salary::create([
                'employee_id' => $employee->id,
                'payroll_id' => $payroll->id,
                'salary' => $employee->salary,
                'deductions' => $deductions,
                'net_salary' => $netPay,
                'work_days' => $workDays,
            ]);
        }
        $payroll->update([
            'total_net_salary' => $payroll->salaries->pluck('net_salary')->sum(),
        ]);

        return redirect()->back()->with('reissue', 1);
    }

    public function reject(Payroll $payroll)
    {
        $this->authorize('proceed_payrolls');
        $payroll->update(['status' => 2]);
        return redirect()->back()->with('status', 'reject');
    }

    public function approve(Payroll $payroll)
    {
        $this->authorize('proceed_payrolls');
        $payroll->update(['status' => 1]);
        return redirect()->back()->with('status', 'approve');
    }


    public function destroy(Payroll $payroll)
    {
        //
    }

    public function excel(Payroll $payroll)
    {
        $fileName = 'payroll.xlsx';

        $salaries = Salary::where('payroll_id', $payroll->id)->get()->map(function ($salary) {
            $payroll2 = Payroll::find($salary->payroll_id);
            $employee = $salary->employee;

            $date = strtotime($payroll2->year_month);
            $y_m = date('Y-m', $date);
            $y_m = explode('-', $y_m);

            $employee->discount_repair();
            $deductions = $employee->deductions($payroll2->year_month);

            $gosiDeduction = $employee->gosiDeduction();
            $officialWorkingHours = 240;

            $request0 = AppRequest::where([
                'requestable_type' => 'App\Vacation',
                'employee_id' => $employee->id,
                'status' => 1
            ])->get();

            $request0 = AppRequest::where([
                'requestable_type' => 'App\Vacation',
                'employee_id' => $employee->id,
                'status' => 1
            ])->get();

            $advance_salary = 0;
            $daysOff = 0;
            foreach ($request0 as $req) {
                $vacation = Vacation::where('id', $req->requestable_id)->whereYear('start_date', $y_m[0])->whereMonth('start_date', $y_m[1])->whereNotIn('vacation_type_id', [1, 2, 3, 10])->get();
                foreach ($vacation as $v) {
                    $advance_salary += $v->advance_salary;
                    $daysOff        += $v->total_days;
                }
            }

            $Vacation_salary_deduction = 0;
            foreach ($request0 as $req) {
                $vacation = Vacation::where('id', $req->requestable_id)->whereYear('start_date', $y_m[0])->whereMonth('start_date', $y_m[1])->where('vacation_type_id', 10)->get();
                foreach ($vacation as $v) {
                    $Vacation_salary_deduction += $v->available_after * ($employee->totalPackage() / 30);
                }
            }

            $percent = 0;
            $sick_leave = 0;
            if ($employee->sick_leave_used() > 30) {

                $check_sick_used_in_month = 0;
                foreach ($request0 as $req) {
                    $vacation = Vacation::where('id', $req->requestable_id)->whereYear('start_date', $y_m[0])->whereMonth('start_date', $y_m[1])->whereIn('vacation_type_id', [1, 2, 3])->get();
                    foreach ($vacation as $v) {
                        $check_sick_used_in_month++;
                    }
                }

                if ($check_sick_used_in_month >= 1) {

                    if ($employee->sick_leave_used() >= 31) {
                        $percent = 25;
                    }

                    if ($employee->sick_leave_used() >= 91) {
                        $percent = 100;
                    }
                }
            }

            $sick_leave = (($percent / 100) * $salary->net_salary);
            $total_deduction = ($gosiDeduction + $deductions + $sick_leave + $advance_salary + $employee->totalOtherDeduction());

            return [
                'Job Number' => $employee->job_number,
                'Employee' => $employee->name(),
                'Nationality' => $employee->nationality_name,
                'Salary' => number_format($employee->salary, 2),
                'Official Working Hours' => $officialWorkingHours,
                'Hourly Wage' => number_format($employee->totalPackage() / $officialWorkingHours, 2),
                'Housing' => $employee->hra(),
                'Transfer' => $employee->transfer(),
                'Other Allowances' => $employee->otherAllowances(),
                'Total Allowances' => number_format($employee->totalAdditionAllowances(), 2),
                'Total Package' => number_format($employee->totalPackage(), 2),
                'Violations Deduction' => number_format($deductions, 2),
                'GOSI Deduction' => $gosiDeduction,
                'advance salary' => $advance_salary,
                'Total Deduction' => number_format($total_deduction, 2),
                'Net Pay' => number_format(($employee->totalPackage() - $total_deduction), 2),
                'Work Days' => ($salary->work_days - $daysOff),
            ];
        });

        $header_style = (new StyleBuilder())
            ->setFontSize(8)
            ->setFontBold()
            ->build();



        $rows_style = (new StyleBuilder())
            ->setFontSize(8)
            ->setBackgroundColor("EDEDED")
            ->build();


        return (new FastExcel($salaries))
            ->headerStyle($header_style)
            ->rowsStyle($rows_style)
            ->download($fileName);
    }

    public function deductions($employee, $month)
    {
        return EmployeeViolation::where('employee_id', $employee->id)->whereMonth('date', '=', $month)->get()->map(function ($employee_violations) {
            $deduction =  is_numeric($employee_violations->deduction) ? $employee_violations->deduction : 0;
            $additionTo =  is_numeric($employee_violations->addition_to) ? $employee_violations->addition_to : 0;
            return $deduction + $additionTo;
        })->sum();
    }
}
