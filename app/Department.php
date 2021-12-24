<?php

namespace App;

use App\Scopes\ParentScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class Department extends Model
{

    use SoftDeletes;
    use LogsActivity;


    protected $guarded = [];
    protected static $logUnguarded = true;
    protected static $logOnlyDirty  = true;
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
        static::addGlobalScope(new ParentScope());
        static::creating(function ($model) {
            $model->company_id = Company::companyID();
        });

        static::updated(function ($department) {
            foreach ($department->employees as $employee) {
                $employee->supervisor_id = $department->supervisor_id;
                $employee->save();
            }
        });
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function sections()
    {
        return $this->hasMany(Section::class);
    }

    public function name()
    {
        return $this->{'name_' . app()->getLocale()};
    }

    public function employees()
    {
        return $this->hasMany(Employee::class);
    }

    public function supervisor()
    {
        return $this->belongsTo(Employee::class, 'supervisor_id');
    }
}
