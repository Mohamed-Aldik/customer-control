<?php

namespace App;

use App\Scopes\ParentScope;
use App\Scopes\ServiceStatusScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class SuspendedSalary extends Model
{

    use SoftDeletes;

    use LogsActivity;


    protected $guarded = [];
    protected static $logUnguarded = true;
    protected static $logOnlyDirty  = true;
    public static function booted()
    {
        static::creating(function ($model) {
            $model->company_id = Company::companyID();
        });

        static::addGlobalScope(new ParentScope());
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class)->withoutGlobalScope(ServiceStatusScope::class);
    }
}
