<?php

namespace App\Http\Controllers;

use App\Company;
use App\Employee;
use Illuminate\Http\Request;

class CheckDomainController extends Controller
{
    public function isDomainNameExist(Request $request)
    {
        $request->validate([
            'domain_name' => 'required'
        ]);
        if(Company::where('domain', $request->domain_name)->exists()){
            return response()->json(['status' => 1, 'message', 'This Domain already exist']);
        }else{
            return response()->json(['status' => 0, 'message', 'This Domain does not exist']);
        }
    }

    public function forgetDomainName(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:employees,email'
        ]);
        $company = Employee::whereEmail($request->email)->first()->company;

        if(isset($company->domain) && $company->domain != ""){
            return response()->json(['status' => 1, 'domain' => $company->domain]);
        }else{
            return response()->json(['status' => 0, 'message', 'The Company ' . $company->name() . ' doesnt has a domain attached to it']);
        }
    }
}
