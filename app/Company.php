<?php

namespace App;


use App\Notifications\CompanyResetPasswordNotification;
use App\Scopes\ParentScope;
use App\Scopes\ServiceStatusScope;
use App\Scopes\SupervisorScope;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Laravel\Passport\HasApiTokens;
use Spatie\Activitylog\Traits\CausesActivity;
use Spatie\Activitylog\Traits\LogsActivity;

class Company extends Authenticatable
{
    use Notifiable, HasApiTokens, LogsActivity, CausesActivity;
    use SoftDeletes;



    protected $guarded = [];
    protected static $logOnlyDirty  = true;

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'created_at' => 'datetime',
    ];

    public static $rules = [
        'name_ar' => ['required', 'string'],
        'name_en' => ['required', 'string'],
        'ceo_id'  => 'nullable|max:255|exists:employees,id',
        'hr_id'   => 'nullable|max:255|exists:employees,id',
        'county_ar' => 'nullable|string|max:255',
        'county_en' => 'nullable|string|max:255',
        'city_ar' => 'nullable|string|max:255',
        'city_en' => 'nullable|string|max:255',
        'address_ar' => 'nullable|string|max:255',
        'address_en' => 'nullable|string|max:255',
        'phone' => 'nullable|max:255',
        'postal_code' => 'nullable|max:255',
        'cr_number' => 'nullable|max:255',
        'logo' => 'nullable|image|mimes:jpeg,png,jpg',
        'email' => 'required|string|email|max:255|unique:companies',
        'domain' => 'nullable|regex:/^[a-z]+$/|max:20|unique:companies',
        'password' => ['required', 'string', 'min:8', 'confirmed'],
    ];

    protected static $logUnguarded = true;


    public function sendPasswordResetNotification($token)
    {
        $this->notify(new CompanyResetPasswordNotification($token));
    }

    public function getDescriptionForEvent(string $eventName): string
    {
        $baseName = class_basename(__CLASS__);
        return "$baseName has been {$eventName}";
    }

    public function saveWithoutEvents(array $options = [])
    {
        return static::withoutEvents(function () use ($options) {
            return $this->save($options);
        });
    }

    public static function booted()
    {
        static::creating(function ($model) {
            $role = Role::where('label', 'Company')->firstOrFail();
            $model->role_id = $role->id;
        });

        static::created(function ($model) {
            Role::generateDefaultRoles($model->id);
            Allowance::generateDefaultAllowances($model->id);
            LeaveBalance::generateDefaultLeaveBalances($model->id);
        });
    }

    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = Hash::make($password);
    }

    public static function instance()
    {
        return auth()->guard('company')->check() ? auth()->user() : Company::find(auth()->user()->company_id);
    }

    public static function companyID()
    {
        return auth()->guard('company')->check() ? auth()->user()->id : auth()->user()->company_id;
    }

    public function name()
    {
        return $this->{'name_' . app()->getLocale()};
    }

    public function role()
    {
        return $this->belongsTo(Role::class)->withoutGlobalScope(new ParentScope());
    }

    public function abilities()
    {
        return $this->role->abilities->flatten()->pluck('name')->unique();
    }


    public function employees()
    {
        return $this->hasMany(Employee::class)->withoutGlobalScope(ParentScope::class);
    }

    public function vacationer()
    {

        $ems = $this->employees;

        $datestart = [];
        $dateend = [];
        foreach ($ems as $em) {
            foreach ($em->requests() as $req) {
                $vacation = Vacation::find($req->requestable_id);
                if ($vacation) {
                    array_push($datestart, $vacation->start_date);
                    array_push($dateend, $vacation->end_date);
                }
            }
        }

        $dates = [$datestart, $dateend];

        $vacations = 0;
        foreach ($dates[0] as $index => $asdasd) {

            $paymentDate = date('Y-m-d');
            $paymentDate = date('Y-m-d', strtotime($paymentDate));
            //echo $paymentDate; // echos today! 
            $contractDateBegin = date('Y-m-d', strtotime($dates[0][$index]));
            $contractDateEnd = date('Y-m-d', strtotime($dates[1][$index]));

            if (($paymentDate >= $contractDateBegin) && ($paymentDate <= $contractDateEnd)) {
                $vacations++;
            }
        }

        return $vacations;
    }

    public static function supervisors()
    {
        return Department::get()->map(function ($department) {
            return $department->supervisor;
        })->filter()->unique();
    }


    public function documents()
    {
        return $this->morphMany(Document::class, 'documentable');
    }

    public static function settingWorkdays()
    {
        $settingWorkDays = DB::table('settings')->where([['key', '=', 'work_days'], ['company_id', '=', Company::companyID()]])->first();
        return isset($settingWorkDays) ? $settingWorkDays->value : null;
    }

    public function HR()
    {
        return Employee::withoutGlobalScope(SupervisorScope::class, ServiceStatusScope::class)->find($this->hr_id);
    }

    public static function getHR()
    {
        $company = Company::find(Company::companyID());
        return Employee::withoutGlobalScope(SupervisorScope::class, ServiceStatusScope::class)->find($company->hr_id);
    }
    //
}
