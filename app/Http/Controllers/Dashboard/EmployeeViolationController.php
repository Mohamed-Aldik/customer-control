<?php

namespace App\Http\Controllers\Dashboard;

use App\Employee;
use App\EmployeeViolation;
use App\Http\Controllers\Controller;
use App\Rules\NotRepeated;
use App\Violation;
use App\ViolationDeduction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Rap2hpoutre\FastExcel\FastExcel;

class EmployeeViolationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:employee,company,provider');
    }

    public function index(Request $request)
    {
        $this->authorize('view_employees_violations');

        //$employees_violations = EmployeeViolation::with(['employee', 'violation'])->get();
        //return response()->json($employees_violations);
        if ($request->ajax()) {
            $employees_violations = EmployeeViolation::with(['employee', 'violation'])->get();
            $arr = [];
            foreach ($employees_violations as $ev) {
                $time = strtotime($ev['date']);
                $final = date("Y-m-d", strtotime("+1 day", $time));

                if ($ev->delivered != '') {
                    $delivered = [
                        'Saudi Post' => __('Saudi Post'),
                        'Email' => __('Email'),
                        'Hand' => __('Hand')
                    ];
                    $ev['delivered'] = $delivered[$ev->delivered];
                }

                if ($ev->discount_status != '') {
                    $discount_status = [
                        'Discounted' => __('Discounted'),
                        'I have an acceptable excuse' => __('I have an acceptable excuse'),
                        'pardon from the director' => __('pardon from the director')
                    ];
                    $ev['discount_status'] = $discount_status[$ev->discount_status];
                }

                $ev['date'] = $final;
                array_push($arr, $ev);
            }
            return response()->json($arr);
        }
        return view('dashboard.employees_violations.index');
    }

    public function excel_index(Request $request)
    {


        $fileName = 'employees violations.xlsx';

        $employeeViolation = EmployeeViolation::with(['employee', 'violation'])->get()->map(function ($ev) {

            $employee = $ev->employee;
            $violation = $ev->violation;



            $y_m = explode('-', $ev->date);
            $violation_deductions = ViolationDeduction::where('employee_id', $employee->id)
                ->whereYear('date', '=', $y_m[0])
                ->whereMonth('date', '=', $y_m[1])
                ->first();



            $addition_to = 0;
            if ($violation_deductions) {
                $addition_to = $violation_deductions->amount;
            }

            $time = strtotime($ev->date);
            $date2 = date("Y-m", strtotime("+1 month", $time));

            $y_m = explode('-', $date2);
            $violation_deductions = ViolationDeduction::where('employee_id', $employee->id)
                ->whereYear('date', '=', $y_m[0])
                ->whereMonth('date', '=', $y_m[1])
                ->first();
            $addition_to2 = 0;
            if ($violation_deductions) {
                $addition_to2 = $violation_deductions->amount;
            }


            return [
                'الرقم الوظيفي' => $employee->job_number,
                'الأسم' => $employee->name_ar . " " . $employee->name_en,
                'نوع المخالفة' => $violation->reason_in_arabic,
                'تاريخ إرتكاب المخالفة' => $ev->date,
                'عدد مرات تكرار المخالفة' => $ev->repeats,
                'الحسم الاساسي' => $ev->addition_to,
                'الجزاء الإضافي' => $addition_to,
                'إجمالي الحسم' => ($addition_to + $ev->addition_to),
                'شهر الحسم' => date('Y-m', strtotime($ev->date)),
                'المؤجل من الحسم للشهر التالي' => $addition_to2,
                'حالة الحسم' => "wait"
            ];
        });


        //return $employeeViolation;


        return (new FastExcel($employeeViolation))
            ->download($fileName);
    }


    public function create()
    {
        $this->authorize('create_employees_violations');
        $employees = Employee::get();
        $violations = Violation::get();
        return view('dashboard.employees_violations.create', compact('employees', 'violations'));
    }


    public function store(Request $request)
    {

        //return $request->toArray();
        $employeeViolation = EmployeeViolation::where([
            ['employee_id', $request->employee_id],
            ['date', $request->date]
        ])->first();

        if ($employeeViolation) {
            return Redirect::back()->withErrors(['تم إدخال مخالفة اليوم لهذا الموظف']);
        }

        $this->authorize('create_employees_violations');
        $data = $this->validator($request);
        unset($data['salary_type']);
        $employeeViolation = new EmployeeViolation($data);
        $this->calculateViolation($employeeViolation, $request->salary_type)->save();
        return redirect(route('dashboard.employees_violations.show', $employeeViolation));
    }


    public function show($id)
    {


        $employeeViolation = EmployeeViolation::find($id);

        $to = $employeeViolation->date;
        $from = date("Y-m-d", strtotime("-180 month " . $to));

        $repeat_violation = EmployeeViolation::where([
            ['employee_id', $employeeViolation->employee_id],
            ['violation_id', $employeeViolation->violation_id],
        ])
            ->whereBetween('date', [$from, $to])->count();

        $deduction = is_numeric($employeeViolation->deduction) ? $employeeViolation->deduction . __(" S.R") : $employeeViolation->deduction;
        //return $deduction;


        if (is_numeric($employeeViolation->deduction)) {
            $total_penalties = ($employeeViolation->deduction + $employeeViolation->addition_to);
        } else {
            $total_penalties = $employeeViolation->addition_to;
        }


        $violation_type_message = __($employeeViolation->violation->reason());

        if ($employeeViolation->violation_id == 22) {
            $violation_type_message = __('Being late for work') . " " . $employeeViolation->minutes_late . " " . __('Minutes Without permission, or an acceptable excuse: If it results in the disruption of other workers');
        }
        if ($employeeViolation->violation_id == 23) {
            $violation_type_message = __('violation_message23', ['m' => $employeeViolation->minutes_late]);
        }
        if ($employeeViolation->violation_id == 24) {
            $violation_type_message = __('violation_message24', ['m' => $employeeViolation->minutes_late]);
        }
        if ($employeeViolation->violation_id == 25) {
            $violation_type_message = __('violation_message24', ['m' => $employeeViolation->minutes_late]);
        }
        if ($employeeViolation->violation_id == 28) {
            $violation_type_message = __('violation_message28', ['m' => $employeeViolation->absence_days]);
            if ($employeeViolation->absence_days == 2) {
                $violation_type_message = __('violation_message28_num2');
            }
        }
        if ($employeeViolation->violation_id == 29 or $employeeViolation->violation_id == 30) {
            $violation_type_message = __('violation_message29', ['m' => $employeeViolation->absence_days]);
        }

        if ($employeeViolation->violation_id == 31) {
            $violation_type_message = __('violation_message31', ['m' => $employeeViolation->absence_days]);
        }

        return view('dashboard.employees_violations.show', compact('employeeViolation', 'deduction', 'total_penalties', 'repeat_violation', 'violation_type_message'));
    }


    public function edit($id)
    {
        $this->authorize('update_employees_violations');
        $employeeViolation = EmployeeViolation::find($id);
        $employees = Employee::get();
        $violations = Violation::get();
        return view('dashboard.employees_violations.edit', compact('employees', 'violations', 'employeeViolation'));
    }

    public function repeat($id)
    {
        $this->authorize('update_employees_violations');
        $employeeViolation = EmployeeViolation::find($id);
        $employees = Employee::get();
        $violations = Violation::get();
        return view('dashboard.employees_violations.repeat', compact('employees', 'violations', 'employeeViolation'));
    }


    public function update(Request $request, $id)
    {
        $this->authorize('update_employees_violations');
        $employeeViolation = EmployeeViolation::find($id);
        $employeeViolation->update($this->validator($request, $employeeViolation));
        $this->calculateViolation($employeeViolation, $request->salary_type)->save();
        return redirect(route('dashboard.employees_violations.index'));
    }


    public function destroy(Request $request, $id)
    {
        $this->authorize('delete_employees_violations');
        if ($request->ajax()) {
            EmployeeViolation::find($id)->delete();
            return response()->json([
                'status' => true,
                'message' => 'Item Deleted Successfully'
            ]);
        }
        return redirect(route('dashboard.employees_violations.index'));
    }
    public function calculateDeduction($dailySalary, $panelValue)
    {
        if (@number_format($panelValue) != null)
            return $dailySalary * ($panelValue / 100);
        //return number_format($dailySalary * ($panelValue/100), 2);
        return $panelValue;
    }

    public function calculateViolation(EmployeeViolation $employeeViolation, $salaryType)
    {
        $employee = $employeeViolation->employee;
        $violation = $employeeViolation->violation;
        $repeats = EmployeeViolation::where('employee_id', $employee->id)
            ->where('violation_id', $violation->id)
            ->count() + 1;

        if ($repeats > 4) {
            $repeats = $violation->panel5;
        }

        $employeeViolation->repeats = $repeats;
        $panels = Violation::find($violation->id, ['panel1', 'panel2', 'panel3', 'panel4'])->toArray();
        $lastPanelExist = array_key_last(array_filter($panels));

        if ($salaryType == 'basic_salary') {
            $dailySalary = $employee->dailySalary();
        } else {
            $dailySalary = $employee->dailySalaryBasedOnTotalPackage();
        }


        if ($repeats < 4 && isset($violation->{'panel' . $repeats})) {
            $employeeViolation->deduction = $this->calculateDeduction($dailySalary, $violation->{'panel' . $repeats});
        } else {
            $employeeViolation->deduction = $this->calculateDeduction($dailySalary, $violation->{$lastPanelExist});
        }

        if ($violation->addition_to == "minutes_deduc") // minutes late deduction
            $employeeViolation->addition_to = $employeeViolation->minutes_late * ($dailySalary / (8 * 60));
        else // absence days deductions
            $employeeViolation->addition_to = $employeeViolation->absence_days * $dailySalary;

        return $employeeViolation;
    }

    public function validator(Request $request, EmployeeViolation $employeeViolation = null)
    {

        $rules = EmployeeViolation::$rules;
        array_push($rules['employee_id'], new NotRepeated($request->violation_id, $request->date));
        return $request->validate($rules);
    }


    public function employees_violations_delivery($id, $value)
    {
        $em = EmployeeViolation::find($id);
        $em->delivered = $value;
        $em->save();
        return $em;
    }

    public function employees_violations_discount_status($id, $value)
    {
        $em = EmployeeViolation::find($id);
        $em->discount_status = $value;
        $em->save();
        return $em;
    }
}
