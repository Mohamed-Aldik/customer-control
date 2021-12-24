<?php

namespace App\Http\Controllers\Dashboard;

use App\Company;
use App\Http\Controllers\Controller;
use App\Resignation;
use App\SuspendedSalary;
use Illuminate\Http\Request;

class ResignationController extends Controller
{

    public function index()
    {
        //
    }


    public function create()
    {
        $this->authorize('not-company');
        $endServiceController = new EndServiceController();
        $reasons = $endServiceController->reasons;
        return view('dashboard.resignations.create', compact('reasons'));
    }


    public function store(Request $request)
    {
        $this->authorize('not-company');

        Resignation::create($request->validate([
            'reason' => 'required|numeric',
            'termination_date' => 'required|after_or_equal:today'
        ]));


        // last working date 15-5-2021  [suspended_from - suspended-to - employee_id]

        // if the termination date is after more than 35 then suspend salary before the termination date by 35 days
        return response()->json(['status' => 'success']);
    }


    public function show(Resignation $resignation)
    {
        //
    }


    public function edit(Resignation $resignation)
    {
        //
    }


    public function update(Request $request, Resignation $resignation)
    {
        //
    }


    public function destroy(Resignation $resignation)
    {
        //
    }
}
