<?php

namespace App\Http\Controllers\Dashboard;

use App\Employee;
use App\Http\Controllers\Controller;
use App\OfficialVacation;
use App\Request as AppRequest;
use App\Vacation;
use App\VacationType;
use Illuminate\Http\Request;


class VacationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:employee,company,provider');
    }



    public function create()
    {

        $user = auth()->user();

        $sick_leave_used = $user->sick_leave_used();
        $available_balance = $user->available_balance();

        $this->authorize('create_vacation_request');
        $this->authorize('not-company');
        $vacationTypes = VacationType::all();

        return view('dashboard.vacations.create', compact('vacationTypes', 'sick_leave_used', 'available_balance'));
    }

    public function edit(AppRequest $vacation)
    {

        $appRequest = $vacation;

        if ($vacation->employee_id != auth()->user()->id or $vacation->requestable_type != 'App\Vacation') {
            return redirect('/');
        }

        $vacation = Vacation::find($vacation->requestable_id);

        $timeDay = strtotime(date('Y-m-d'));

        $user = auth()->user();

        $sick_leave_used = $user->sick_leave_used();
        $available_balance = $user->available_balance();

        $this->authorize('create_vacation_request');
        $this->authorize('not-company');
        $vacationTypes = VacationType::all();

        return view('dashboard.vacations.edit', compact('appRequest', 'vacation', 'vacationTypes', 'sick_leave_used', 'available_balance'));
    }

    public function update(Request $request, AppRequest $vacation)
    {


        if ($vacation->employee_id != auth()->user()->id or $vacation->requestable_type != 'App\Vacation') {
            return redirect('/');
        }

        $vacation = Vacation::find($vacation->requestable_id);

        if (strtotime($vacation->end_date) <= strtotime($request->end_date)) {
            return response()->json([
                'status' => true,
                'message' => __('It is not allowed to increase the number of days')
            ], 403);
        }

        $timeDay = strtotime(date('Y-m-d'));

        $allowed_days = '';
        if ($timeDay <= strtotime($request->end_date)) {

            $now = $timeDay; // or your date as well
            $your_date = strtotime($request->end_date);
            $datediff = $your_date - $now;

            $vacation->end_date = $request->end_date;
            $vacation->total_days = $request->vacation_days;
            $vacation->save();
            return response()->json(['status' => 'success']);

            $allowed_days = round($datediff / (60 * 60 * 24));
        } else {
            return response()->json([
                'status' => true,
                'message' => __('I used some days')
            ], 403);
        }



        return $allowed_days;
        return $request->toArray();
        return "edit";
    }


    public function assignVacation()
    {
        $this->authorize('create_vacation_request');
        $this->authorize('not-company');
        $vacationTypes = VacationType::all();
        $employees = Employee::all();
        return view('dashboard.vacations.assign_vacation', compact('vacationTypes', 'employees'));
    }

    public function storeAssignedVacation(Request $request)
    {

        $this->authorize('not-company');
        $request->validate(['employee_id' => 'required|numeric|exists:employees,id']);

        $vacation = new Vacation($this->validator($request));
        $vacation->total_days = ($vacation->start_date->diffInDays($vacation->end_date)) + 1;
        $vacation->saveWithoutEvents(['created']);

        \App\Request::create([
            'employee_id' => $request->employee_id,
            'requestable_id' => $vacation->id,
            'requestable_type' => 'App\Vacation',
        ]);
        return response()->json(['status' => 'success']);
    }

    public function store(Request $request)
    {
        //return $request->toArray();
        $official_days = $this->check_current_date_between_two_dates($request->start_date, $request->end_date);

        $this->authorize('create_vacation_request');
        $this->authorize('not-company');


        $from = $request->start_date;
        $to = $request->end_date;

        $checkdayVacation = Vacation::whereBetween('start_date', [$from, $to])->get();
        $checkdayVacation2 = Vacation::whereBetween('end_date', [$from, $to])->get();

        foreach ($checkdayVacation as $va) {
            $req = AppRequest::where([['employee_id', auth()->user()->id], ['requestable_id', $va->id]])->first();
            if ($req) {
                return response()->json(['status' => 0, 'message' => __('error003')]);
            }
        }

        foreach ($checkdayVacation2 as $va) {
            $req = AppRequest::where([['employee_id', auth()->user()->id], ['requestable_id', $va->id]])->first();
            if ($req) {
                return response()->json(['status' => 0, 'message' => __('error003')]);
            }
        }


        auth()->user()->available_balance();
        auth()->user()->available_balance += ($this->dateDifference($request->start_date)) * (auth()->user()->leave_balance / 365);

        if (auth()->user()->available_balance >= $request->vacation_days or in_array($request->vacation_type_id, [1, 2, 3, 10])  or setting('vacation_exceeded') == 1) {

            if ($request->vacation_type_id == 10 and $request->vacation_days > 20) {
                return response()->json(['status' => 0, 'message' => "الحد الأقصي للأجازة بدون أجر هي 20 يوم"]);
            }

            $vacation = new Vacation($this->validator($request));

            $available_after = 0;
            if ($request->vacation_type_id == 10) {
                $available_after = 20 - auth()->user()->available_balance;
            }

            $vacation->available_after = $available_after;
            $vacation->total_days = (($vacation->start_date->diffInDays($vacation->end_date)) + 1) - $official_days;
            $vacation->advance_salary = auth()->user()->advanceSalary($vacation->total_days);
            $vacation->save();


            return response()->json(['status' => 'success']);
        }

        return response()->json(['status' => 0, 'message' => 'You do not have enough balance']);
    }

    public function check_current_date_between_two_dates($stratDate, $endDate)
    {

        $off = OfficialVacation::all();
        $days = 0;
        foreach ($off as $item) {
            $today = date('Y-m-d', strtotime($item->date_official_vacation));

            $stratDate = date('Y-m-d', strtotime($stratDate));
            $endDate = date('Y-m-d', strtotime($endDate));
            if (($today >= $stratDate) && ($today <= $endDate)) {
                $days++;
            }
        }

        return $days;
    }

    public function validator(Request $request)
    {
        $request['paid_in_advance'] = $request->has('paid_in_advance');
        $request['ticket_request'] = $request->has('ticket_request');
        $request['visa_request'] = $request->has('visa_request');
        $request['advance_salary'] = $request->has('advance_salary');
        $request['vacation_type_id'] = $request->vacation_type_id;

        return $request->validate([
            'vacation_type_id' => 'exclude_if:vacation_type_id,0|numeric|exists:vacation_types,id',
            'paid_in_advance' => 'required|boolean',
            'ticket_request' => 'required|boolean',
            'visa_request' => 'required|boolean',
            'start_date' => 'required',
            'end_date' => 'required',
            'advance_salary' => ''
        ]);
    }

    public function dateDifference($date_1)
    {
        $now = time(); // or your date as well
        $your_date = strtotime($date_1);
        $datediff = $your_date - $now;

        return round($datediff / (60 * 60 * 24));
    }
}
