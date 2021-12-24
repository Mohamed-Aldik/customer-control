<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class Comblaint extends Model
{
    use SoftDeletes;
    use LogsActivity;


    protected $guarded = [];
    protected static $logUnguarded = true;
    protected static $logOnlyDirty  = true;

    protected $fillable = ['name', 'phone', 'email', 'message'];
}
