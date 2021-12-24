<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class Excuse extends Model
{
    //
    use SoftDeletes;
    use LogsActivity;


    protected $guarded = [];
    protected static $logUnguarded = true;
    protected static $logOnlyDirty  = true;
}
