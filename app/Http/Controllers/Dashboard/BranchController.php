<?php

namespace App\Http\Controllers\Dashboard;

use App\branch;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BranchController extends Controller
{

    public function index(Request $request)
    {
        if ($request->ajax()){
            $branches = branch::get();
            return response()->json($branches);
        }
        return view('dashboard.settings.branches.index');
    }


    public function create()
    {
        return view('dashboard.settings.branches.create');
    }


    public function store(Request $request)
    {
        Branch::create($request->validate([
            'name_ar' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
            'lat' => 'required',
            'lng' => 'required',
        ]));

        return redirect(route('dashboard.branches.index'));
    }


    public function show(branch $branch)
    {
        //
    }


    public function edit(branch $branch)
    {
        return view('dashboard.settings.branches.edit', compact('branch'));
    }


    public function update(Request $request, branch $branch)
    {
        $branch->update($request->validate([
            'name_ar' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
            'lat' => 'required',
            'lng' => 'required',
        ]));
        return redirect(route('dashboard.branches.index'));
    }


    public function destroy(branch $branch)
    {
        //
    }
}
