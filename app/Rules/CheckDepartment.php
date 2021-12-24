<?php

namespace App\Rules;

use App\City;
use App\Department;
use App\JobTitle;
use App\Nationality;
use App\Provider;
use App\Role;
use App\Section;
use Illuminate\Contracts\Validation\Rule;

class CheckDepartment implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        if($attribute == "Department"){  return Department::find($value);   }
        if($attribute == "Nationality"){ return Nationality::find($value);  }
        if($attribute == "City"){        return City::find($value);         }
        if($attribute == "Role"){        return Role::find($value);         }
        if($attribute == "Job"){         return JobTitle::find($value);     }
        if($attribute == "Provider"){    return Provider::find($value);     }
        if($attribute == "Section"){     return Section::find($value);     }
        
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return trans('validation.CheckDepartment');
    }
}
