<?php

namespace App;

use App\Scopes\LeaveTypeScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class VacationType extends Model
{
    use LogsActivity;
    use SoftDeletes;



    protected $guarded = [];

    protected static $logOnlyDirty  = true;
    public static $rules = [
        'name_ar' => ['required', 'string', 'max:25'],
        'name_en' => ['required', 'string', 'max:25'],
        'min_num' => ['required', 'numeric', 'min:0'],
        'max_num' => ['required', 'numeric', 'min:0'],
        'type' => ['nullable'],
    ];

    protected static $logUnguarded = true;

    public function getDescriptionForEvent(string $eventName): string
    {
        $baseName = class_basename(__CLASS__);
        return "$baseName has been {$eventName}";
    }

    public static function booted()
    {
        static::addGlobalScope(new LeaveTypeScope());
        static::creating(function ($model) {
            $model->company_id = Company::companyID();
        });
    }

    public function name()
    {
        return $this->{'name_' . app()->getLocale()};
    }
}
