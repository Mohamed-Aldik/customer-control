<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Financial extends Model
{
    public function employee(){
        return $this->belongsTo(Employee::class);
    }

    public function payroll(){
        return $this->belongsTo(Payroll::class);
    }
}
