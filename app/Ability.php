<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class Ability extends Model
{

    use SoftDeletes;
    use LogsActivity;


    protected $guarded = [];
    protected static $logUnguarded = true;
    protected static $logOnlyDirty  = true;

    protected $casts = [
        //        'created_at'  => 'date:Y d M',
        'created_at'  => 'date:D M d Y',
    ];
    public function roles()
    {
        return $this->belongsToMany(Role::class)->withTimestamps();
    }
}
