<?php

namespace App\Http\Controllers\Auth;

use App\Company;
use App\Employee;
use App\Http\Controllers\Controller;
use App\Message;
use App\Provider;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Response;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    public function sendResetLinkEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        $guard = null;

        if(Company::whereEmail($request->email)->exists()){
            $response = Password::broker('companies')->sendResetLink($request->only('email'), function (Message $message) {
                $message->subject($this->getEmailSubject());
            });
            return redirect()->back()->with('status', true);
        }elseif (Employee::whereEmail($request->email)->exists()){
            $response = Password::broker('employees')->sendResetLink($request->only('email'), function (Message $message) {
                $message->subject($this->getEmailSubject());
            });
            return redirect()->back()->with('status', true);
        }elseif (Provider::whereEmail($request->email)->exists()){
            $response = Password::broker('providers')->sendResetLink($request->only('email'), function (Message $message) {
                $message->subject($this->getEmailSubject());
            });
            return redirect()->back()->with('status', true);
        }else{
            return redirect()->back()->withErrors(['email' => 'This email does not exist']);
        }

    }

}
