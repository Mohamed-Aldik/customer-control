<?php

namespace App;

use App\Scopes\ServiceStatusScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class Salary extends Model
{
    use SoftDeletes;
    use LogsActivity;


    protected $guarded = [];
    protected static $logUnguarded = true;
    protected static $logOnlyDirty  = true;
    protected $dates = ['date', 'issue_date'];

    public function employee()
    {
        return $this->belongsTo(Employee::class)->withoutGlobalScope(ServiceStatusScope::class);
    }

    public function payroll()
    {
        return $this->belongsTo(Payroll::class);
    }
}
