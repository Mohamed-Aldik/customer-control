<?php

namespace App;

use App\Scopes\ParentScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\App;
use Spatie\Activitylog\Traits\LogsActivity;

class Role extends Model
{
    use LogsActivity;
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $guarded = [];
    protected static $logUnguarded = true;
    protected static $logOnlyDirty  = true;
    protected $casts = [
        'created_at'  => 'date:D M d Y',
    ];


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
            $model->company_id = Company::companyID();
        });
        static::addGlobalScope(new ParentScope());
    }
    public function abilities()
    {
        return $this->belongsToMany(Ability::class)->withTimestamps();
    }

    public function allowTo($ability)
    {
        if (is_string($ability)) {
            $ability = Ability::whereName($ability)->firstOrFail();
        }
        $this->abilities()->sync($ability, false);
    }

    public function disallowTo($ability)
    {
        return $this->abilities()->detach($ability);
    }

    public function Name()
    {
        return (App::isLocale('ar')) ? $this->name_arabic : $this->name_english;
    }

    public static function generateDefaultRoles($companyID)
    {
        $categories = [
            'roles',
            'users',
            'violations',
            'employees',
            'employees_violations',
            'reports',
            'conversations',
        ];
        $abilities = Ability::get();

        $Hr = new Role([
            'name_english'  => 'HR',
            'name_arabic'  => '???????? ?????????????? ??????????????',
            'label' => 'HR',
            'type' => 'System Role',
            'company_id' => $companyID
        ]);
        $supervisor = new Role([
            'name_english'  => 'Supervisor',
            'name_arabic'  => '???????????? ??????????????',
            'label' => 'Supervisor',
            'type' => 'System Role',
            'company_id' => $companyID
        ]);
        $employee = new Role([
            'name_english'  => 'Employee',
            'name_arabic'  => '????????',
            'label' => 'Employee',
            'type' => 'System Role',
            'company_id' => $companyID
        ]);


        $supervisor->saveWithoutEvents(['creating']);
        $Hr->saveWithoutEvents(['creating']);
        $employee->saveWithoutEvents(['creating']);

        foreach ($abilities->whereIn('category', ['employees', 'employees_violations', 'reports', 'conversations']) as $ability) {
            $Hr->allowTo($ability);
        }

        foreach ($abilities->whereIn('category', ['reports']) as $ability) {
            $supervisor->allowTo($ability);
        }

        foreach ($abilities->whereIn('category', ['conversations']) as $ability) {
            $employee->allowTo($ability);
        }
    }
}
