<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Resignation;
use Illuminate\Http\Request;

class ResignationController extends Controller
{

    public function index()
    {
        $resignationsRequests = \App\Request::where('employee_id', auth()->user()->id)
            ->where("requestable_type", "App\Resignation")
            ->get()
            ->map(function ($resignationsRequest){
                $requestable = $resignationsRequest->requestable;
                return [
                    "reason" => $requestable->reason,
                    "status" => $resignationsRequest->status,
                ];
            });
    }


    public function store(Request $request)
    {
        Resignation::create($request->validate([
            'reason' => 'required|string|max:191'
        ]));

        return response()->json(['status' => 1,'message' => 'Resignation request has been created']);
    }
}
