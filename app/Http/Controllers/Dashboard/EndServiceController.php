<?php

namespace App\Http\Controllers\Dashboard;

use App\Employee;
use App\EndService;
use App\Decision;
use App\Http\Controllers\Controller;
use App\Notifications\EndServiceAlert;
use App\Scopes\ServiceStatusScope;
use Carbon\Carbon;
use Illuminate\Http\Request;

class EndServiceController extends Controller
{
    public $reasons=[
        0 => 'The term of the contract expires, or the parties agree to terminate the contract', // 0 ==> case1
        1 => 'worker resigned',// 1 ==> case2
        2 => 'The contract was terminated by the employer of one of the cases contained in Article (80)', // 2 ==> case3
//        3 => 'Termination of the contract from the employer',// 3 ==> case4
//        4 => 'Leaving work is the result of a force majeure',// 4 ==> case1
//        5 => 'Leaving the worker in a case in article 81',// 5 ==> case1
//        6 => 'Termination of employment within six months of the marriage contract Or within three months of the situation',// 6 ==> case1
        7 => 'According to article (81)',// 7 ==> case3
        8 => 'Request to terminate the contract based on the article (77) - The company is affected',// 8 ==> case3
        9 => 'Request to terminate the contract based on the article (77) - The employee is affected'// 8 ==> case3
    ];

    public function create()
    {
        return view('dashboard.decisions.end_services.create', [
            'reasons' => $this->reasons,
            'employees' => Employee::get()
        ]);
    }


    public function store(Request $request)
    {
        $this->validator($request);
        $result = $this->calculateEndServiceReward($request);
        $endService = EndService::create([
            'termination_date' => $request->termination_date,
            'end_service_reward' => $result['service_reward'],
            'benefit' => $result['benefit'],
            'reason' => $request->reason,
            'compensation' => $result['compensation'],
            'years' => $result['years'],
            'months' => $result['months'],
            'days' => $result['days'],
            'available_balance' => $result['days'],
            'late_notify' => $result['notificationLateDeduction'],
            'total' => $result['total'],
        ]);

        Decision::create([
            'employee_id' => $request->employee_id,
            'decisionable_id' => $endService->id,
            'decisionable_type' => 'App\EndService',
            'notes' => $request->notes,
        ]);

        Employee::find($request->employee_id)->update([
            'contract_end_date' => $request->termination_date,
//            'service_status' => 0
        ]);

        if(in_array($request->reason, [0, 2])) {
            $endService->decision->employee->notify(new EndServiceAlert($request->termination_date));
        }
        return redirect(route('dashboard.decisions.index'));
    }


    public function show(EndService $endService)
    {
        return view('dashboard.decisions.end_services.show', [
            'endService' => $endService,
            'decision' => $endService->decision,
            'employee' => $endService->decision->employee,
        ]);
    }

    public function endServiceReward(Request $request){
        $this->validator($request);
        $results = $this->calculateEndServiceReward($request);
        return response()->json($results);
    }

    public function calculateEndServiceReward(Request $request)
    {
        $reason = $request->reason;
        $terminationDate = $request->termination_date;
        $employee = Employee::withoutGlobalScope(ServiceStatusScope::class)->find($request->employee_id);
        $duration = $employee->duration($terminationDate);
        $salary = $employee->salary;
        $dailyBalance = $employee->leave_balance / 365;
        $dateDifferanceInDays = Carbon::parse($terminationDate)->diffInDays($employee->contract_start_date);
        $available_balance = round($dailyBalance * $dateDifferanceInDays);
        $benefit = $available_balance * $employee->dailySalary();
        $end_of_service = 0;

        $compensation = $this->compensation($employee, $terminationDate ,$reason);
        $notificationLateDeduction = $this->notificationLateDeduction($employee, $request);


        if(in_array($reason, [0,4,5,6,7,8,9])){
            $end_of_service = $this->case1($duration, $salary);
        }elseif ($reason == 1){
            $end_of_service = $this->case2($duration, $salary);
        }
        elseif (in_array($reason, [2])){
            $end_of_service = 0;
        }
        elseif ($reason == 3){
            $end_of_service = $this->case4();
        }

        $total_amount = $end_of_service + $benefit + $compensation + $notificationLateDeduction;

        return [
            "emp_num" => $employee->job_number,
            "emp_name" => $employee->name(),
            "emp_joined_date" => $employee->contract_start_date->format("Y-m-d"),
            "years" => $duration['years'],
            "months" => $duration['months'],
            "days" => $duration['days'],
            "service_reward" => $end_of_service,
            "available_balance" => $available_balance - $employee->usedBalance(),
            "benefit" => doubleval($benefit),
            "compensation" => doubleval($compensation),
            "notificationLateDeduction" => doubleval($notificationLateDeduction),
            "total" => doubleval($total_amount),
        ];
    }

    public function case1($duration, $salary)
    {
        $end_of_service = 0;
        if($duration['years'] > 5 ){
            $yearsAfter5 = $duration['years'] - 5;
            $end_of_service += ($salary / 2) * 5;   // نصف الراتب في حالة الخمس سنوات
            $end_of_service += ($salary) * $yearsAfter5; //  المرتب كامل في حالة اكثر من خمس سنوات
        }else{
            $salary/=2;
            $end_of_service = $salary * $duration['years'];
        }
        $monthsReward = ($salary / 12) * $duration['months'];
        $daysReward = ($salary / (12 * 30)) * $duration['days'];
        $end_of_service += ($monthsReward + $daysReward);
        return $end_of_service;
    }

    public function case2($duration, $salary)
    {
        $end_of_service = 0;
        if($duration['years'] < 2){ // لا يستحق مكافاة
            return $end_of_service; //0
        }
        $end_of_service = $this->case1($duration, $salary);
        if($duration['years'] >= 2 &&  $duration['years'] <=5){ //  يستحق ثلث المكافاة
            $end_of_service = $end_of_service/3;
        }elseif($duration['years'] >= 6 &&  $duration['years'] <10){//  يستحق ثلثين المكافاة
            $end_of_service = ($end_of_service/3) * 2;
        }   // المكافاة كاملة من 10 سنوات الي اكثر

        return $end_of_service;
    }


    public function case4()
    {
        $end_of_service = 0;

        return $end_of_service;
    }

    public function validator(Request $request)
    {
        $request->validate([
            'employee_id' => 'required|numeric',
            'termination_date' => 'required|date',
            'reason' => 'required|numeric'
        ]);
    }

    public function compensation($employee, $terminationDate ,$reason)
    {

        $compensation = 0;
        $terminationDate = Carbon::parse($terminationDate);
        if(in_array($reason, [0, 1, 2, 7, 9, 8])){
            if($employee->hasCompensation()){

                $compensation = $employee->compensation;

            }else if($employee->isFixedTermContract()){
                $remainingDays = 0;
                if($employee->contract_end_date->gt($terminationDate)){
                    $remainingDays = $employee->contract_end_date->diffInDays($terminationDate);
                }

                $compensation = $employee->dailySalary() * $remainingDays;

            }else{

                $compensation = $employee->salary * 2;

            }
        }

        if ($reason == 8){ // company affected
            $compensation *= -1;
        }

        return $compensation;
    }

    public function notificationLateDeduction($employee, $request)
    {

        if($request->notification_period == 'false'){
            return 0;
        }

        $mustDemandDate = $employee->contract_end_date->subDays($employee->notification_period);
        $terminationDate = Carbon::parse($request->termination_date);
        $lateDays = 0;

        if(!$employee->isFixedTermContract() && $terminationDate->gt(Carbon::today())){
            $mustDemandDate = $terminationDate->subDays($employee->notification_period);
            $lateDays = $mustDemandDate->diffInDays(Carbon::today());

            return $lateDays * $employee->dailySalary();

        }elseif (in_array($request->reason, [1, 8])){ // done

            $resignation = \App\Request::where('employee_id', $employee->id)->orderBy('created_at', 'desc')->get()->filter(function ($request){
                return $request->requestable_type == 'App\\Resignation';
            })->first();


            if(isset($resignation)){
                if($resignation->created_at->gt($mustDemandDate)){
                    $lateDays = $resignation->created_at->diffInDays($mustDemandDate);
                };
            }

            return $lateDays * $employee->dailySalary() * -1;
        }elseif(in_array($request->reason, [0, 2, 9])){

            if($terminationDate->gt($mustDemandDate)){
                $lateDays = $terminationDate->diffInDays($mustDemandDate);
            };

            return $lateDays * $employee->dailySalary();
        }


    }

}
