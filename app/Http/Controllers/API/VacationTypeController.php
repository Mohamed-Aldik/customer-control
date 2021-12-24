<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Request;
use App\VacationType;

class VacationTypeController extends Controller
{

    public function index()
    {
        $vacations_types = VacationType::get(['id', 'name_ar', 'name_en', 'num_of_days']);
        return response()->json($vacations_types);
    }

    

}
