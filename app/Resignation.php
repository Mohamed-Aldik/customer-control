<?php

namespace App;

use App\Notifications\LateNoticePeriod;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class Resignation extends Model
{
    use SoftDeletes;
    use LogsActivity;


    protected $guarded = [];
    protected static $logUnguarded = true;
    protected static $logOnlyDirty  = true;
    protected $casts = [
        'start_date'  => 'date:Y-m-d',
        'end_date'  => 'date:Y-m-d',
        'created_at'  => 'date:D M d Y',
    ];

    protected static function booted()
    {
        static::created(function ($resignation) {
            $authUser = auth()->user();
            $request = Request::create([
                'employee_id' => $authUser->id,
                'requestable_id' => $resignation->id,
                'requestable_type' => 'App\Resignation',
            ]);

            // if termination date after 35 days or less from now then suspend the salary for the employee
            $terminationDate = $resignation->termination_date;
            $terminationDate = Carbon::parse($terminationDate);

            if ($terminationDate->diffInDays(Carbon::now()) <= 35) {
                SuspendedSalary::create([
                    'employee_id' => $authUser->id,
                    'from' => Carbon::now()->format('Y-m-d'),
                    'to' => $resignation->termination_date,
                ]);
            }
        });
    }

    public function request()
    {
        return $this->morphOne(Request::class, 'requestable');
    }
}
