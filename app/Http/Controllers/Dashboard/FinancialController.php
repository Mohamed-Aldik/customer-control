<?php

namespace App\Http\Controllers\Dashboard;

use App\Employee;
use App\Financial;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FinancialController extends Controller
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
            'value' => ["required", "numeric"],
            'description' => ["required"],
            'payroll_id' => ["required", "numeric"],
        ]);

        $em = Employee::searchFromJobNumberController($request->job_number);
        if(!$em){
            return response()->json(['message'=>'login field','errors'=>[
                'job_number' => [__('You must select an employee')]
            ]], 422);
        }

        $financial = new Financial();
        $financial->employee_id = $em->id;
        $financial->payroll_id = $request->payroll_id;
        $financial->value = $request->value;
        $financial->desc = $request->description;
        $financial->save();

        return $financial;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Financial  $financial
     * @return \Illuminate\Http\Response
     */
    public function show(Financial $financial)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Financial  $financial
     * @return \Illuminate\Http\Response
     */
    public function edit(Financial $financial)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Financial  $financial
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Financial $financial)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Financial  $financial
     * @return \Illuminate\Http\Response
     */
    public function destroy(Financial $financial)
    {
        //
    }
}
