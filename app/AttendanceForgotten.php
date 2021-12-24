<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class AttendanceForgotten extends Model
{

    use SoftDeletes;
    use LogsActivity;


    protected $guarded = [];
    protected static $logUnguarded = true;
    protected static $logOnlyDirty  = true;
    protected $casts = [
        'forgotten_date' => 'date:Y-m-d'
    ];

    protected static function booted()
    {
        static::created(function ($attendanceForgotten) {
            Request::create([
                'employee_id' => auth()->user()->id,
                'requestable_id' => $attendanceForgotten->id,
                'requestable_type' => 'App\AttendanceForgotten',
            ]);
        });
    }

    public function request()
    {
        return $this->morphOne(Request::class, 'requestable');
    }
}
