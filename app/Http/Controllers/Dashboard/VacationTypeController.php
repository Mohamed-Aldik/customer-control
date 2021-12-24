<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Rules\UniqueItem;
use App\VacationType;
use Illuminate\Http\Request;
use anlutro\LaravelSettings\Facade as Setting;
use App\Company;


class VacationTypeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:employee,company,provider');
    }

    public function index(Request $request)
    {
        $this->authorize('view_settings');
        if ($request->ajax()) {
            $vacation_types = VacationType::get();
            return response()->json($vacation_types);
        }
        return view('dashboard.settings.vacation_types.index');
    }

    public function create()
    {
        $this->authorize('view_settings');
        return view('dashboard.settings.vacation_types.create');
    }

    public function store(Request $request)
    {
        $this->authorize('view_settings');
        VacationType::create($this->validator($request));
        return redirect(route('dashboard.vacation_types.index'));
    }

    public function edit(VacationType $vacationType)
    {
        $this->authorize('must_be_admin', $vacationType);
        $this->authorize('view_settings');
        return view('dashboard.settings.vacation_types.edit', compact('vacationType'));
    }

    public function update(VacationType $vacationType, Request $request)
    {
        $this->authorize('must_be_admin', $vacationType);
        $this->authorize('view_settings');
        $vacationType->update($this->validator($request, $vacationType->id));
        return redirect(route('dashboard.vacation_types.index'));
    }

    public function destroy(Request $request, VacationType $vacationType)
    {
        $this->authorize('view_settings');
        if ($request->ajax()) {
            $vacationType->delete();
            return response()->json([
                'status' => true,
                'message' => 'Item Deleted Successfully'
            ]);
        }
    }

    public function validator(Request $request, $id = null)
    {

        $rules = VacationType::$rules;
        array_push($rules['name_ar'], new UniqueItem(new VacationType(), $id));
        $data = $request->validate($rules);
        if (!$request->has('type')) {
            $data['type'] = 'custom';
        }
        return $data;
    }

    public function vacationDays(VacationType $vacationType)
    {
        return response()->json([
            'vacation_days' => $vacationType->num_of_days
        ]);
    }

    public function setManagerID()
    {
        Setting::setExtraColumns(array(
            'company_id' => Company::companyID()
        ));
    }

    public function check_vaction(Request $request)
    {

        $vacation_type = VacationType::find($request->chosse);
        $vacation_type_check = VacationType::where([
            ['id', $request->chosse],
            ['min_num', "<=", $request->days],
            ['max_num', ">=", $request->days]
        ])->get();

        if (count($vacation_type_check) == 0) {
            return response()->json(['error' => __('Vacation Days') . " " . __('must be between') . $vacation_type->min_num . __('and') . $vacation_type->max_num], 200);
        }


        $totalPackagePaid_in_advance = auth()->user()->advanceSalary($request->days);

        $check_paid_in_advance = (auth()->user()->leave_balance / 12);
        $check_paid_in_advance = ($check_paid_in_advance * setting('paid_in_advance'));
        $paid_in_advance = 0;
        if ($request->days >= $check_paid_in_advance) {
            $paid_in_advance = 1;
        }

        $startDate = strtotime("-1 day", strtotime($request->startDate));
        $request->startDate = date('Y-m-d', $startDate);

        auth()->user()->available_balance();

        auth()->user()->available_balance += ($this->dateDifference($request->startDate)) * (auth()->user()->leave_balance / 365);
        $available_from_start_date = auth()->user()->available_balance;

        if (auth()->user()->available_balance >= $request->days or in_array($request->chosse, [1, 2, 3, 10]) or setting('vacation_exceeded') == 1) {

            if ($request->chosse == 10 and $request->days > 20) {
                return response()->json(['error' => "الحد الأقصي للأجازة بدون أجر هي 20 يوم"], 200);
            }

            $new_availabel_balance = (auth()->user()->available_balance - $request->days);
            $date = strtotime($request->startDate);


            $date_end = strtotime("+" . $request->days . " day", $date);
            $date_blus1 = strtotime("+1 day", $date_end);

            $date_end = date('Y-m-d', $date_end);
            $date_blus1 = date('Y-m-d', $date_blus1);



            return response()->json([

                "massage" => "success",
                "date_blus1" => $date_blus1,
                "date_end" => $date_end,
                "new_availabel_balance" => $new_availabel_balance,
                "paid_in_advance" => $paid_in_advance,
                "available_from_start_date" => number_format($available_from_start_date, 2),
                'salary_Paid_in_advance' => number_format($totalPackagePaid_in_advance, 2),



            ], 200);
        }
        return response()->json(['error' => "You do not have enough balance"], 200);
    }


    public function check_vaction2(Request $request)
    {


        $vacation_type = VacationType::find($request->chosse);
        $vacation_type_check = VacationType::where([
            ['id', $request->chosse],
            ['min_num', "<=", $request->days],
            ['max_num', ">=", $request->days]
        ])->get();

        if (count($vacation_type_check) == 0) {
            return response()->json(['error' => __('Vacation Days') . " " . __('must be between') . $vacation_type->min_num . __('and') . $vacation_type->max_num], 200);
        }


        $totalPackagePaid_in_advance = auth()->user()->advanceSalary($request->days);

        $check_paid_in_advance = (auth()->user()->leave_balance / 12);
        $check_paid_in_advance = ($check_paid_in_advance * setting('paid_in_advance'));


        $startDate = strtotime("-1 day", strtotime($request->startDate));
        $request->startDate = date('Y-m-d', $startDate);

        auth()->user()->available_balance += ($this->dateDifference($request->startDate)) * (auth()->user()->leave_balance / 365);
        $available_from_start_date = auth()->user()->available_balance;

        $new_availabel_balance = (auth()->user()->available_balance - $request->days);
        $date = strtotime($request->startDate);


        $date_end = strtotime("+" . $request->days . " day", $date);
        $date_blus1 = strtotime("+1 day", $date_end);

        $date_end = date('Y-m-d', $date_end);
        $date_blus1 = date('Y-m-d', $date_blus1);



        $paid_in_advance = 0;

        return response()->json([

            "massage" => "success",
            "date_blus1" => $date_blus1,
            "date_end" => $date_end,
            "new_availabel_balance" => $new_availabel_balance,
            "paid_in_advance" => $paid_in_advance,
            "available_from_start_date" => number_format($available_from_start_date, 2),
            'salary_Paid_in_advance' => number_format($totalPackagePaid_in_advance, 2),

        ], 200);
    }

    public function dateDifference($date_1)
    {
        $now = time(); // or your date as well
        $your_date = strtotime($date_1);
        $datediff = $your_date - $now;

        return round($datediff / (60 * 60 * 24));
    }
}
