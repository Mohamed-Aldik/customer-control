<?php

namespace App\Http\Controllers\API;

use App\AttendanceForgotten;
use App\Http\Controllers\Controller;
use App\Rules\CheckAttendanceForgotten;
use Illuminate\Http\Request;

class AttendanceForgottenController extends Controller
{

    public function index()
    {
        $missed_punches = \App\Request::where('employee_id', auth()->user()->id)
            ->where("requestable_type", "App\AttendanceForgotten")
            ->get()
            ->map(function ($missed_punch){
                $requestable = $missed_punch->requestable;
                return [
                    "forgotten_date" => $requestable->forgotten_date->format('Y-m-d'),
                    "status" => $missed_punch->status,
                ];
            });

        return response()->json($missed_punches);
    }


    public function store(Request $request)
    {
        AttendanceForgotten::create($request->validate([
                'forgotten_date' => ['required', 'before_or_equal:today' , new CheckAttendanceForgotten(auth()->user()->id)]
        ]));
        return response()->json(['status' => 1,'message' => 'Missing punch request has been created']);
    }
}
