<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class EndService extends Model
{

    use SoftDeletes;

    use LogsActivity;


    protected $guarded = [];
    protected static $logUnguarded = true;
    protected static $logOnlyDirty  = true;

    protected $casts = [
        'termination_date' => 'date: Y-m-d',
    ];

    protected static function booted()
    {
        static::created(function ($endService) {
            // سيتم انهاء خدمتك بتاريخ 10 / 10 / 2020

        });
    }

    public function decision(): \Illuminate\Database\Eloquent\Relations\MorphOne
    {
        return $this->morphOne(Decision::class, 'decisionable');
    }
}
