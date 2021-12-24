<?php

namespace App;

use App\Scopes\ParentScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class LeaveBalance extends Model
{
    use SoftDeletes;
    use LogsActivity;


    protected $guarded = [];
    protected static $logUnguarded = true;
    protected static $logOnlyDirty  = true;
    public static $rules = [
        'days_per_year' => 'required|numeric|min:0|max:365'
    ];

    public static function booted()
    {
        static::addGlobalScope(new ParentScope());
        static::creating(function ($model) {
            $model->company_id = Company::companyID();
        });
    }

    public function saveWithoutEvents(array $options = [])
    {
        return static::withoutEvents(function () use ($options) {
            return $this->save($options);
        });
    }

    public static function generateDefaultLeaveBalances($companyID)
    {
        $days21 = new LeaveBalance([
            'days_per_year'  => 21,
            'company_id' => $companyID
        ]);
        $days30 = new LeaveBalance([
            'days_per_year'  => 30,
            'company_id' => $companyID
        ]);

        $days21->saveWithoutEvents(['creating']);
        $days30->saveWithoutEvents(['creating']);
    }
}
