<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\OfficialVacation;
use Illuminate\Http\Request;

class OfficialVacationsController extends Controller
{


    public function index(Request $request)
    {

        if ($request->ajax()){
            $branches = OfficialVacation::get();
            return response()->json($branches);
        }
        return view('dashboard.settings.official_vacations.index');
    }


    public function create()
    {
        return view('dashboard.settings.official_vacations.create');
    }


    public function store(Request $request)
    {

        $request->validate([
            'date_official_vacation' => 'required'
        ]);

        $official_vacation = new OfficialVacation();
        $official_vacation->date_official_vacation = $request->date_official_vacation;
        $official_vacation->save();

        return redirect(route('dashboard.official_vacations.index'));
    }


    public function show(branch $branch)
    {
        //
    }


    public function edit(branch $branch)
    {
        //
    }


    public function update(Request $request, branch $branch)
    {
        //
    }

    public function destroy(OfficialVacation $OfficialVacation)
    {
        $OfficialVacation->delete();
        return response()->json(['message'=>__('Deleted Done')], 200);
    }

}
