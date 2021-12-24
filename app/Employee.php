<?php

namespace App;

use App\Notifications\EmployeeResetPasswordNotification;
use App\Scopes\CompletedScope;
use App\Scopes\ParentScope;
use App\Scopes\ProviderScope;
use App\Scopes\ServiceStatusScope;
use App\Scopes\SupervisorScope;
use Carbon\Carbon;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Passport\HasApiTokens;
use Spatie\Activitylog\Traits\CausesActivity;
use Spatie\Activitylog\Traits\LogsActivity;
use App\Request as appRequest;
use anlutro\LaravelSettings\Facade as Setting;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Authenticatable implements MustVerifyEmail
{
    use Notifiable, HasApiTokens, LogsActivity, CausesActivity;
    use SoftDeletes;
    protected $table = 'employees';

    protected $guarded = [];
    protected static $logUnguarded = true;
    protected static $logOnlyDirty  = true;


    protected $hidden = [
        'password', 'remember_token',
    ];


    public static $rules = [
        'name_ar' => ['required', 'string'],
        'name_en' => ['required', 'string'],
        'email' => 'sometimes|required|email|unique:employees',
        'provider_id' => 'nullable|numeric|exists:providers,id',
        'department_id' => 'required|numeric|exists:departments,id',
        'section_id' => 'nullable|numeric|exists:sections,id',
        'role_id' => 'required|numeric|exists:roles,id',
        'birthdate' => ['required', 'date'],
        'nationality_id' => 'required|numeric|exists:nationalities,id',
        'job_title_id' => 'required|numeric|exists:job_titles,id',
        'marital_status' => ['required'],
        'gender' => ['required'],
        'test_period' => ['required'],
        'city_id' => 'required|numeric|exists:cities,id',
        'id_num' => ['required'],
        'id_expire_date' => ['nullable'],
        'passport_num' => ['nullable'],
        'passport_issue_date' => ['nullable'],
        'passport_expire_date' => ['nullable'],
        'issue_place' => ['nullable'],
        'job_number' => ['required', 'numeric'],
        'work_shift_id' => ['required', 'exists:work_shifts,id'],
        'contract_type' => ['required'],
        'contract_start_date' => ['required'],
        'contract_end_date' => ['nullable'],
        'contract_period' => 'nullable',
        'hra_allowance_value' => 'nullable',
        'hra_allowance_percentage' => 'nullable',
        'notification_period' => 'required|numeric',
        'compensation_type' => 'required|numeric', //khaled
        'compensation' => 'required_if:compensation_type,1|min:0',
        'salary' => ['required', 'numeric'],
        'phone' => ['required'],
        'leave_balance' => 'required|numeric|min:0|max:365|exists:leave_balances,days_per_year',
        'password' => ['required', 'string', 'min:8', 'confirmed'],

    ];

    public static $fordealRules = [
        'name_en' => ['required', 'string'],
        'email' => 'sometimes|required|email|unique:employees',
        'provider_id' => 'nullable|numeric|exists:providers,id',
        'department_id' => 'required|numeric|exists:departments,id',
        'section_id' => 'nullable|numeric|exists:sections,id',
        'role_id' => 'required|numeric|exists:roles,id',
        'birthdate' => ['required', 'date'],
        'nationality_id' => 'required|numeric|exists:nationalities,id',
        'job_title_id' => 'required|numeric|exists:job_titles,id',
        'marital_status' => ['required'],
        'gender' => ['required'],
        'city_id' => 'required|numeric|exists:cities,id',
        'id_num' => ['required'],
        'id_issue_date' => ['nullable'],
        'id_expire_date' => ['nullable'],
        'job_number' => ['required', 'numeric'],
        'work_shift_id' => ['required', 'exists:work_shifts,id'],
        'contract_type' => ['required'],
        'contract_start_date' => ['required'],
        'salary' => ['required', 'numeric'],
        'phone' => ['required'],
        'password' => ['required', 'string', 'min:8', 'confirmed'],

    ];


    public static $saveRules = [
        'name_ar' => ['nullable', 'string'],
        'name_en' => ['nullable', 'string'],
        'email' => 'sometimes|nullable|email|unique:employees',
        'provider_id' => 'nullable|numeric|exists:providers,id',
        'department_id' => 'nullable|numeric|exists:departments,id',
        'section_id' => 'nullable|numeric|exists:sections,id',
        'role_id' => 'nullable|numeric|exists:roles,id',
        'birthdate' => ['nullable', 'date'],
        'nationality_id' => 'nullable|numeric|exists:nationalities,id',
        'job_title_id' => 'nullable|numeric|exists:job_titles,id',
        'marital_status' => ['nullable'],
        'gender' => ['nullable'],
        'test_period' => ['nullable'],
        'city_id' => 'nullable|numeric|exists:cities,id',
        'id_num' => ['nullable'],
        'id_expire_date' => ['nullable'],
        'passport_num' => ['nullable'],
        'passport_issue_date' => ['nullable'],
        'passport_expire_date' => ['nullable'],
        'issue_place' => ['nullable'],
        'job_number' => ['nullable', 'numeric'],
        'work_shift_id' => ['nullable', 'exists:work_shifts,id'],
        'contract_type' => ['nullable'],
        'contract_start_date' => ['nullable'],
        'contract_end_date' => ['nullable'],
        'contract_period' => 'nullable',
        'salary' => ['nullable', 'numeric'],
        'phone' => ['nullable'],
        'leave_balance' => 'nullable|numeric|min:0|max:365|exists:leave_balances,days_per_year',
        'password' => ['nullable', 'string', 'min:8', 'confirmed'],

    ];


    protected $casts = [
        'email_verified_at' => 'datetime',
        'contract_start_date' => 'date',
        'contract_end_date' => 'date',
        'created_at'  => 'date:D M d Y',
    ];


    public function sendPasswordResetNotification($token)
    {
        $this->notify(new EmployeeResetPasswordNotification($token));
    }

    public function getDescriptionForEvent(string $eventName): string
    {
        $baseName = class_basename(__CLASS__);
        return "$baseName has been {$eventName}";
    }

    public static function booted()
    {
        static::addGlobalScope(new CompletedScope());
        static::addGlobalScope(new ParentScope());
        static::addGlobalScope(new SupervisorScope());
        static::addGlobalScope(new ServiceStatusScope());
        static::addGlobalScope(new ProviderScope());

        static::creating(function ($model) {
            if (auth()->check()) {

                $barcode = rand(0, 99999999);
                $barcode = str_pad($barcode, 8, "0", STR_PAD_LEFT);
                while (Employee::pluck('job_number')->contains($barcode)) {
                    $barcode = rand(0, 99999999);
                    $barcode = str_pad($barcode, 12, "0", STR_PAD_LEFT);
                }

                $model->company_id = Company::companyID();
                $model->barcode = $barcode;
            }
        });

        static::saving(function ($employee) {
            if ($employee->is_compleated) {
                $supervisorID = $employee->department->supervisor_id;
                if ($supervisorID != 0) {
                    $employee->supervisor_id = $supervisorID;
                    $employee->save();
                }
            }
        });
    }

    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = Hash::make($password);
    }

    public function getNationalityNameAttribute()
    {
        $nationality = Nationality::find($this->nationality_id);
        return $nationality ? $nationality->name() : '';
    }

    public function getRoleNameAttribute()
    {
        return $this->role->name();
    }

    public function getJobTitleNameAttribute()
    {
        $job_title = JobTitle::find($this->job_title_id);
        return $job_title ? $job_title->name() : '';
    }

    public function getSupervisorNameAttribute()
    {
        $supervisor = $this->supervisor;
        return $supervisor ? $supervisor->name() : '';
    }

    public function getSectionNameAttribute()
    {
        $section = $this->section;
        return $section ? $section->name() : '';
    }

    public function getDepartmentNameAttribute()
    {
        $department = $this->department;
        return $department ? $department->name() : '';
    }

    public function getProviderNameAttribute()
    {
        $proider = $this->provider;
        return $proider ? $proider->name() : '';
    }

    public function name()
    {
        return $this->{'name_' . app()->getLocale()};
    }

    public function provider()
    {
        return $this->belongsTo(Provider::class);
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function abilities()
    {
        return $this->role->abilities->flatten()->pluck('name')->unique();
    }

    public function documents()
    {
        return $this->morphMany(Document::class, 'documentable');
    }


    public function allowances()
    {
        return $this->belongsToMany(Allowance::class);
    }

    public function hra()
    {
        $add = 0;
        $hra = $this->allowances()->where('label', 'hra')->first();
        if (!isset($hra))
            return 0;
        if ($hra->type == 1) { // addition
            if($hra->name_en == "Housing" && $this->hra_allowance_value != null){
                $add += $this->hra_allowance_value;
            }
            elseif (isset($hra->percentage)) {
                $add = $this->salary * ($hra->percentage / 100);
            } else {
                $add = $hra->value;
            }
        }
        return number_format($add, 2);
    }
    public function transfer()
    {
        $add = 0;
        $transfer = $this->allowances()->where('label', 'transfer')->first();
        if (!isset($transfer))
            return 0;
        if ($transfer->type == 1) { // addition
            if (isset($transfer->percentage)) {
                $add = $this->salary * ($transfer->percentage / 100);
            } else {
                $add = $transfer->value;
            }
        }
        return number_format($add, 2);
    }

    public function otherAllowances()
    {
        return $this->allowances()->whereNotIn('label', ['transfer', 'hra'])
            ->get()
            ->map(function ($allowance) {
                if ($allowance->type == 1) { // addition
                    if (isset($allowance->percentage)) {
                        return $this->salary * ($allowance->percentage / 100);
                    } else {
                        return $allowance->value;
                    }
                }
            })->sum();
    }

    public function workShift()
    {
        return $this->belongsTo(WorkShift::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    public function dailySalary()
    {
        return $this->salary / 30;
    }

    public function dailySalaryBasedOnTotalPackage()
    {
        return $this->totalPackage() / 30;
    }

    public function employee_violations()
    {
        return $this->hasMany(EmployeeViolation::class, 'employee_id');
    }


    public function CheckViolationInYear()
    {
        $EmployeeViolation = EmployeeViolation::where([
            ['employee_id', $this->id],
            ['repeats', '>=', 4]
        ])->whereYear('date', '=', date('Y'))->get();
        $array = [];
        foreach ($EmployeeViolation as $ev) {
            array_push($array, $ev->violation_id);
        }
        return json_encode($array);
    }

    public function supervisedEmployees()
    {
        return $this->hasMany(Employee::class, 'supervisor_id');
    }

    public function supervisor()
    {
        return $this->belongsTo(Employee::class, 'supervisor_id')->withoutGlobalScope(SupervisorScope::class);
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    public function nationality()
    {
        $nationality = Nationality::find($this->nationality_id);
        return $nationality ? $nationality->name() : '';
    }



    public function job_title()
    {
        $job_title = JobTitle::find($this->job_title_id);
        return $job_title ? $job_title->name() : '';
    }

    public function deductions($date = null)
    {

        $time = strtotime($date);
        $y_m = date('Y-m', $time);
        $y_m = explode('-', $y_m);

        $employeeViolation2 = EmployeeViolation::where('employee_id', $this->id)
            ->whereYear('date', $y_m[0])
            ->whereMonth('date', $y_m[1])
            ->get();

        $addition_to = 0;

        foreach ($employeeViolation2 as $ev2) {
            $addition_to += $ev2->addition_to;
        }

        $employeeViolation2 = ViolationDeduction::where('employee_id', $this->id)
            ->whereYear('date', $y_m[0])
            ->whereMonth('date', $y_m[1])
            ->first();

        if ($employeeViolation2) {
            return $addition_to + $employeeViolation2->amount;
        }
        return $addition_to;
    }

    public function discount_repair()
    {

        foreach ($this->violationDeductions as $idelete) {
            $idelete->delete();
        }

        $employeeViolation = EmployeeViolation::where('employee_id', $this->id)->orderBy('date', 'ASC')->get();
        $dates = [];
        foreach ($employeeViolation as $ev) {
            if (!in_array(date('Y-m', strtotime($ev->date)), $dates)) {
                array_push($dates, date('Y-m', strtotime($ev->date)));
            }
        }

        foreach ($dates as $date) {
            $y_m = explode('-', $date);
            $employeeViolation2 = EmployeeViolation::where('employee_id', $this->id)
                ->whereYear('date', $y_m[0])
                ->whereMonth('date', $y_m[1])
                ->get();
            $deduction   = 0;
            $addition_to = 0;

            foreach ($employeeViolation2 as $ev2) {
                if (is_numeric($ev2->deduction)) {
                    $deduction += $ev2->deduction;
                }
                $addition_to += $ev2->addition_to;
            }

            $this->insert_v_d($deduction, $date . "-01");
        }


        return $dates;
    }


    public function insert_v_d($amount, $date)
    {

        $checkViDe = ViolationDeduction::where('employee_id', $this->id)
            ->where('date', $date)
            ->first();

        if ($checkViDe) {
            $date3 = date('Y-m', strtotime("+1 month " . $date));
            $amount2 = $amount + $checkViDe->amount;
            $checkViDe->delete();
            $this->insert_v_d($amount2, $date);
        } else {


            $day_fiv_from_total_package = ($this->totalPackage() / 30) * 5;

            if ($amount > $day_fiv_from_total_package) {

                $violation_deductions = new ViolationDeduction();
                $violation_deductions->amount = $day_fiv_from_total_package;
                $violation_deductions->date = $date;
                $violation_deductions->employee_id = $this->id;
                $violation_deductions->save();
                $amount = $amount - $day_fiv_from_total_package;
                $date3 = date('Y-m-d', strtotime("+1 month " . $date));
                $this->insert_v_d($amount, $date3);
            } else {
                $violation_deductions = new ViolationDeduction();
                $violation_deductions->amount = $amount;
                $violation_deductions->date = $date;
                $violation_deductions->employee_id = $this->id;
                $violation_deductions->save();
            }
        }
    }

    public function workDays($month)
    {
        $work_days = Attendance::where('employee_id', $this->id)->whereNotNull(['time_in', 'time_out'])->whereMonth('date', $month)->count();
        return $work_days;
    }

    public function daysOff()
    {
        $daysOff = isset($this->workShift) ? 7 - count(unserialize($this->workShift->work_days)) : 0;
        return $daysOff * 4;
    }

    public function weeklyDaysOff()
    {
        $daysOff = isset($this->workShift) ? 7 - count(unserialize($this->workShift->work_days)) : 0;
        return $daysOff;
    }

    public function salary()
    {
        return $this->totalPackage() - $this->gosiDeduction();
    }

    public function totalPackage()
    {
        $add = 0;
        foreach ($this->allowances as $allowance) {
            if ($allowance->type == 1) { // addition
                if($allowance->name_en == "Housing" && $this->hra_allowance_value != null){
                    $add += $this->hra_allowance_value;
                }
                elseif (isset($allowance->percentage)) {
                    $add += $this->salary * ($allowance->percentage / 100);
                } else {
                    $add += $allowance->value;
                }
            }
        }
        return $this->salary + $add;
    }

    public function totalPackageActiveAllowance()
    {
        
        $add = 0;
        foreach ($this->allowances as $allowance) {
            if ($allowance->type == 1 and $allowance->active_in_advance_salary) { // addition
                if (isset($allowance->percentage)) {
                    $add += $this->salary * ($allowance->percentage / 100);
                } else {
                    $add += $allowance->value;
                }
            }
        }
        return $this->salary + $add;
    }
    public function totalAdditionAllowances()
    {
        $add = 0;
        foreach ($this->allowances as $allowance) {
            if ($allowance->type == 1) { // addition

                if($allowance->name_en == "Housing" && $this->hra_allowance_value != null){
                    $add += $this->hra_allowance_value;
                }
                elseif (isset($allowance->percentage)) {
                    $add += $this->salary * ($allowance->percentage / 100);
                } else {
                    $add += $allowance->value;
                }
            }
        }
        return intval($add);
    }

    public function totalOtherDeduction()
    {
        $add = 0;
        $allowances = $this->allowances()->where('label', null)->get();
        foreach ($allowances as $allowance) {
            if ($allowance->type == 0) { // addition
                if (isset($allowance->percentage)) {
                    $add += $this->salary * ($allowance->percentage / 100);
                } else {
                    $add += $allowance->value;
                }
            }
        }
        return $add;
    }


    public function gosiDeduction()
    {
        $gosi = $this->allowances()->where('label', 'gosi')->first();
        $hra = $this->allowances()->where('label', 'hra')->first();




        if (isset($gosi) && isset($hra) && $this->nationality_id == 3) {
            $hraAddition = 0;

            if (isset($hra->percentage)) {
                $hraAddition = $this->salary * ($hra->percentage / 100);
            } else {
                $hraAddition = $hra->value;
            }

            if($this->hra_allowance_value != null){
                $hraAddition = $this->hra_allowance_value;
            }

            if (isset($gosi->percentage)) {
                $gosiDeduction = ($this->salary + $hraAddition) * ($gosi->percentage / 100);
            } else {
                $gosiDeduction = $gosi->value;
            }

            if($gosiDeduction >= 4500){
                $gosiDeduction = 4500;
            }

            return $gosiDeduction;
        }

        return 0;
    }

    public function isSupervisor()
    {

        return !auth()->guard('company')->check() && Department::where('supervisor_id', $this->id)->exists();
    }

    public  function isHR()
    {
        $hr = $this->company->HR();

        if (isset($hr)) {

            return $this->id == $this->company->HR()->id;
        } else {

            return false;
        }
    }

    public static function supervisorID()
    {
        return auth()->user()->id;
    }

    public function duration($termination_date)
    {
        $termination_date = Carbon::parse($termination_date);
        $dateDiff = $termination_date->diff($this->contract_start_date);

        return [
            'months' => $dateDiff->format('%m'),
            'days'   => $dateDiff->format('%d'),
            'years'  => $dateDiff->format('%y')
        ];
    }

    // edit by abdo


    public function vacationsId()
    {
        $r = appRequest::where([
            'requestable_type' => 'App\Vacation',
            'status' => 1,
            'employee_id' => auth()->user()->id
        ])->get();

        $arra_id = [];
        foreach ($r as $i) {
            array_push($arra_id, $i->requestable_id);
        }
        return $arra_id;
    }

    public function sick_leave_used()
    {

        if (!$this->beginning_end_working_year()) {
            return 0;
        }
        $choose = Vacation::whereIn('id', $this->vacationsId())->whereBetween('start_date', [$this->beginning_end_working_year()['start_date'], $this->beginning_end_working_year()['end_date']])->whereIn('vacation_type_id', [1, 2, 3])->get();

        $num = 0;
        foreach ($choose as $as) {
            $num += $as->total_days;
        }
        return $num;
    }

    public function available_balance($id_user = null)
    {

        if ($id_user == null) {
            $user = $this;
        } else {
            $user = Employee::find($id_user);
        }
        $leave_balance =  $user->leave_balance;
        $contract_start_date =  date("Y-m-d", strtotime($user->contract_start_date));
        $today = date("Y-m-d");

        $interval = date_diff(date_create($today), date_create($contract_start_date));

        $dayes = $interval->format("%a");

        $availabel_balance = ($leave_balance / 365 * $dayes) - $user->usedBalance();
        $availabel_balance = number_format($availabel_balance, 2, '.', '');
        $user->available_balance = $availabel_balance;
        //$user->save();
        return $availabel_balance;
    }

    public function all_balance($id_user)
    {

        $user = Employee::find($id_user);
        $leave_balance =  $user->leave_balance;
        $contract_start_date =  date("Y-m-d", strtotime($user->contract_start_date));
        $today = date("Y-m-d");

        $interval = date_diff(date_create($today), date_create($contract_start_date));

        $dayes = $interval->format("%a");

        $availabel_balance = ($leave_balance / 365 * $dayes);
        $availabel_balance = number_format($availabel_balance, 2, '.', '');
        $user->available_balance = $availabel_balance;
        $user->save();
        return $availabel_balance;
    }

    public function EndVacationInYear()
    {

        return  Vacation::whereIn('id', $this->vacationsId())->whereBetween('start_date', [$this->startSickLeave()['start_date'], $this->startSickLeave()['end_date']])->whereIn('vacation_type_id', [1, 2, 3])->get()->first();
    }

    public function startSickLeave()
    {


        $paymentDate = date('Y-m-d');
        $paymentDate = date('Y-m-d', strtotime($paymentDate));
        //echo $paymentDate; // echos today!
        $x = 1;
        $year0 = 0;
        $year1 = 1;
        while (true) {
            $contractDateBegin = date('Y-m-d', strtotime("+" . $year0 . " year", strtotime(auth()->user()->contract_start_date)));
            $contractDateEnd = date('Y-m-d', strtotime("+" . $year1 . " year -1 day", strtotime(auth()->user()->contract_start_date)));

            if (($paymentDate >= $contractDateBegin) && ($paymentDate <= $contractDateEnd)) {
                break;
            } else {
                $year0++;
                $year1++;
            }
        }

        return [
            'start_date' => $contractDateBegin,
            'end_date' => $contractDateEnd
        ];
    }

    public function beginning_end_working_year()
    {

        if ($this->EndVacationInYear()) {
            return [
                'start_date' => date('Y-m-d', strtotime($this->EndVacationInYear()->start_date)),
                'end_date' => date('Y-m-d', strtotime("+1 year -1 day", strtotime($this->EndVacationInYear()->start_date)))
            ];
        }
        return [
            'start_date' => '',
            'end_date' => ''
        ];
    }

    public function usedBalance()
    {

        $requ = appRequest::where([
            'requestable_type' => 'App\Vacation',
            'status' => 1,
            'employee_id' => $this->id
        ])->get();
        $usedBalance = 0;
        foreach ($requ as $vacation_id) {
            $vacation = Vacation::where('id', $vacation_id->requestable_id)->whereNotIn('vacation_type_id', [1, 2, 3])->get()->first();
            if ($vacation) {
                $usedBalance += $vacation->total_days;
            }
        }
        return $usedBalance;
    }

    public function requests()
    {

        $requ = appRequest::where([
            'requestable_type' => 'App\Vacation',
            'status' => 1,
            'employee_id' => $this->id
        ])->get();

        return $requ;
    }

    public function setManagerID()
    {
        Setting::setExtraColumns(array(
            'company_id' => Company::companyID()
        ));
    }

    public function advanceSalary($day)
    {
        $this->setManagerID();
        $totalPackagePaid_in_advance = ($this->totalPackage() / 30) * $day;
        if (setting('salary_paid_in_advance') == 0) {
            $totalPackagePaid_in_advance = ($this->salary / 30) * $day;
        }
        return $totalPackagePaid_in_advance;
    }

    public function hasCompensation()
    {
        return $this->compensation_type == 1;
    }


    public function isFixedTermContract()
    {
        return $this->contract_type == 0;
    }


    public function isSalarySuspended($date)
    {
        $suspendedDecisions = SuspendedSalary::where('employee_id', $this->id)->get()->filter(function ($suspendedSalary) use ($date) {
            return $date->between($suspendedSalary->from, $suspendedSalary->to);
        });

        return $suspendedDecisions->contains(true);
    }

    public function violationDeductions()
    {
        return $this->hasMany(ViolationDeduction::class);
    }

    public function financial(){
        return $this->hasMany(Financial::class);
    }

    public function show_advance_payment(){
        
        return setting('advance_payment');
        if(setting('advance_payment') == "all"){
            return true;
        }

        if(setting('advance_payment') == "saudi" and $this->nationality_id == 3){
            return true;
        }

        if(setting('advance_payment') == "nonsaudi" and $this->nationality_id != 3){
            return true;
        }

        return false;
    }

    public static function searchFromJobNumberController($search){

        if($search == ''){
            return;
        }
        $employee = Employee::where('job_number', $search)
        ->orWhere('name_ar', 'LIKE', "%{$search}%")
        ->orWhere('name_en', 'LIKE', "%{$search}%")
        ->first();
        return $employee;
    }

    public function value_Extra_hours_from_payroll($payroll_id){

        $overs = Overtime::where([
            ['payroll_id', $payroll_id],
            ['employee_id', $this->id],
        ])->get();

        $value = 0;
        $monthly_hour = 240;
        foreach($overs as $over){
            if(setting('overtime') == "basic"){
                $value += ($over->basic_salary/$monthly_hour*$over->hours*1.5);
            }elseif(setting('overtime') == "total"){
                $value += ($over->total_salary/$monthly_hour*$over->hours*1.5);
            }else{
                $value += ($over->basic_salary/$monthly_hour*$over->hours*0.5);
                $value += ($over->total_salary/$monthly_hour*$over->hours);
            }
        }


        return $value;

        $value = number_format($value, 2);

        
    }


    public function value_financial_from_payroll($payroll_id){

        $financials = Financial::where([
            ['payroll_id', $payroll_id],
            ['employee_id', $this->id],
        ])->get();

        $value = 0;
        foreach($financials as $financial){
            $value += $financial->value;
        }

        return $value;
        $value = number_format($value, 2);

        
    }



}
