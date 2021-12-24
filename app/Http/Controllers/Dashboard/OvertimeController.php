<?php

namespace App\Http\Controllers\Dashboard;

use App\Employee;
use App\Overtime;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OvertimeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $request->validate([
            'job_number' => ["required"],
            'hours' => ["required", "numeric"],
            'payroll_id' => ["required", "numeric"],
        ]);

        $em = Employee::searchFromJobNumberController($request->job_number);
        if(!$em){
            return response()->json(['message'=>'login field','errors'=>[
                'job_number' => [__('You must select an employee')]
            ]], 422);
        }

        $overtime = new Overtime();
        $overtime->employee_id = $em->id;
        $overtime->payroll_id = $request->payroll_id;
        $overtime->hours = $request->hours;
        $overtime->total_salary = $em->totalPackage();
        $overtime->basic_salary = $em->salary;
        $overtime->save();

        return $overtime;
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Overtime  $overtime
     * @return \Illuminate\Http\Response
     */
    public function show(Overtime $overtime)
    {
        $Employee = Employee::find(2);
        $overs = $Employee->overtimes(1);
        $value = 0;
        $monthly_hour = 240;
        foreach($overs as $over){
            if(setting('overtime') == "basic"){
                $value += ($over->basic_salary/$monthly_hour*$over->hours*1.5);
            }elseif(setting('overtime') == "total"){
                $value += ($over->total_salary/$monthly_hour*$over->hours*1.5);
            }else{
                $value += ($over->basic_salary/$monthly_hour*$over->hours*0.5);
                $value += ($over->total_salary/$monthly_hour*$over->hours*0.5);
            }
        }
        $value = number_format($value, 2);
        return $value;

        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Overtime  $overtime
     * @return \Illuminate\Http\Response
     */
    public function edit(Overtime $overtime)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Overtime  $overtime
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Overtime $overtime)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Overtime  $overtime
     * @return \Illuminate\Http\Response
     */
    public function destroy(Overtime $overtime)
    {
        //
    }
}
