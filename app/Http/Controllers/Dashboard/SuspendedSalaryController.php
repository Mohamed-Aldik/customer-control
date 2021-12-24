<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\SuspendedSalary;
use Illuminate\Http\Request;

class SuspendedSalaryController extends Controller
{

    public function index(Request $request)
    {
        if ($request->ajax()){
            $suspendedSalaries = SuspendedSalary::with('employee')->get();
            return response()->json($suspendedSalaries);
        }
        return view('dashboard.suspend_salaries.index');
    }


    public function destroy(SuspendedSalary $suspendedSalary, Request $request)
    {
        if ($request->ajax()){
            $suspendedSalary->delete();
        }
    }
}
