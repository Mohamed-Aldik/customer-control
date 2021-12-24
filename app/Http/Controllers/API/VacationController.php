<?php

namespace App\Http\Controllers\API;

use App\Employee;
use App\Http\Controllers\Controller;
use App\Vacation;
use Illuminate\Http\Request;

class VacationController extends Controller
{

    public function leaveRequests()
    {
        $vacations = \App\Request::where('employee_id', auth()->user()->id)
            ->where("requestable_type", "App\Vacation")
            ->get()
            ->map(function ($vacation) {
                $requestable = $vacation->requestable;

                return [
                    "reason_ar" => $requestable->vacation_type->name_ar,
                    "reason_en" => $requestable->vacation_type->name_en,
                    "start_date" => $requestable->start_date->format('Y-m-d'),
                    "end_date" => $requestable->end_date->format('Y-m-d'),
                    "status" => $vacation->status,
                    "total_days" => $requestable->total_days,
                ];
            });

        return response()->json($vacations);
    }

    public function store(Request $request)
    {

        $user = auth()->user();
        $leave_balance =  $user->leave_balance;
        $contract_start_date =  date("Y-m-d", strtotime($user->contract_start_date));
        $today = date("Y-m-d");

        $interval = date_diff(date_create($today), date_create($contract_start_date));

        $dayes = $interval->format("%a");


        $availabel_balance = ($leave_balance / 365 * $dayes) - $user->usedBalance();

        $available_balance = number_format($availabel_balance, 2, '.', '');
        $user->available_balance = $available_balance;
        $user->save();



        $end_date = strtotime("+" . ($request->days - 1) . " day " . $request->start_date);
        $end_date = date('Y-m-d', $end_date);
        $request->end_date = $end_date;

        $datetime1 = date_create($request->start_date);
        $datetime2 = date_create($end_date);

        $interval = date_diff($datetime1, $datetime2);
        $total_days = $interval->format("%a");

        if ($available_balance < $total_days) {
            return response()->json(['status' => 0, 'message' => 'You do not have enough balance']);
        }

        $vacation = new Vacation($this->validator($request));

        $vacation->total_days = $total_days + 1;
        $vacation->advance_salary = auth()->user()->advanceSalary($vacation->total_days);
        $vacation->end_date = $end_date;
        $vacation->save();
        return response()->json(['status' => 1, 'message' => 'Vacation request has been created']);
    }

    public function validator(Request $request)
    {
        $request['paid_in_advance'] = $request->has('paid_in_advance');
        $request['ticket_request'] = $request->has('ticket_request');
        $request['visa_request'] = $request->has('visa_request');
        $request['advance_salary'] = $request->has('advance_salary');

        return $request->validate([
            'vacation_type_id' => 'exclude_if:vacation_type_id,0|numeric|exists:vacation_types,id',
            'paid_in_advance' => 'required|boolean',
            'ticket_request' => 'required|boolean',
            'visa_request' => 'required|boolean',
            'start_date' => 'required',
            'advance_salary' => ''
        ]);
    }
}
