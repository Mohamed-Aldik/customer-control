<?php

namespace App;

use App\Scopes\ParentScope;
use App\Scopes\ServiceStatusScope;
use App\Scopes\SupervisorScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class Report extends Model
{
    use SoftDeletes;
    use LogsActivity;


    protected $guarded = [];
    protected static $logUnguarded = true;
    protected static $logOnlyDirty  = true;

    protected $casts = [
        'created_at'  => 'date:D M d Y',
    ];
    public static $rules = [
        'employee_id' => 'required|numeric|exists:employees,id',
        'violation_date' => 'required|date',
        'description' => ['required', 'string'],
    ];


    public function getDescriptionForEvent(string $eventName): string
    {
        $baseName = class_basename(__CLASS__);
        return "$baseName has been {$eventName}";
    }

    public static function booted()
    {
        static::creating(function ($model) {
            $model->company_id = Company::companyID();
            $model->supervisor_id = auth()->user()->id; // for director
        });

        static::addGlobalScope(new ParentScope());
    }


    public function employee()
    {
        return $this->belongsTo(Employee::class)->withoutGlobalScope(ServiceStatusScope::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function supervisor()
    {
        return $this->belongsTo(Employee::class, 'supervisor_id')->withoutGlobalScopes([ParentScope::class, SupervisorScope::class]);
    }
}
