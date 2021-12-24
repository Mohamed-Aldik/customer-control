<?php

use App\Ability;
use App\Allowance;
use App\Employee;
use App\Scopes\ParentScope;
use App\Scopes\ProviderScope;
use Illuminate\Support\Facades\DB;
use \Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Illuminate\Support\Facades\Route;
use Rap2hpoutre\FastExcel\FastExcel;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('exlsfastexcel', function () {
    /***/

    $users = Employee::where('company_id', 1)->get();
    return (new FastExcel($users))->export('file.xlsx'); 

     /**$collection = (new FastExcel)->import('file.xlsx');
    foreach($collection as $i){
        echo $i['name_ar'].'<br />';
    } */

});

Route::group([
    'prefix' => LaravelLocalization::setLocale(),
//    'domain' => '{company_name}.' . config('app.url'),
    'middleware' => [
        'localeCookieRedirect',
        'localizationRedirect',
        'localeViewPath' ]
], function() {

    Auth::routes([
        'reset' => true, // Password Reset Routes...
        'verify' => true, // Email Verification Routes...
    ]);
    Route::redirect('/', '/login');

    Route::prefix('employee')->group(function() {
        //Employee Password Reset routes
        Route::post('/password/email','Auth\EmployeeForgotPasswordController@sendResetLinkEmail')->name('employee.password.email');
        Route::post('/password/reset', 'Auth\EmployeeResetPasswordController@reset')->name('employee.password.update');
        Route::get('/password/reset', 'Auth\EmployeeForgotPasswordController@showLinkRequestForm')->name('employee.password.request');
        Route::get('/password/reset/{token}', 'Auth\EmployeeResetPasswordController@showResetForm')->name('employee.password.reset');
    });

    Route::prefix('company')->group(function() {
        //Employee Password Reset routes
        Route::post('/password/email','Auth\CompanyForgotPasswordController@sendResetLinkEmail')->name('company.password.email');
        Route::post('/password/reset', 'Auth\CompanyResetPasswordController@reset')->name('company.password.update');
        Route::get('/password/reset', 'Auth\CompanyForgotPasswordController@showLinkRequestForm')->name('company.password.request');
        Route::get('/password/reset/{token}', 'Auth\CompanyResetPasswordController@showResetForm')->name('company.password.reset');
    });

    Route::prefix('provider')->group(function() {
        //Employee Password Reset routes
        Route::post('/password/email','Auth\ProviderForgotPasswordController@sendResetLinkEmail')->name('provider.password.email');
        Route::post('/password/reset', 'Auth\ProviderResetPasswordController@reset')->name('provider.password.update');
        Route::get('/password/reset', 'Auth\ProviderForgotPasswordController@showLinkRequestForm')->name('provider.password.request');
        Route::get('/password/reset/{token}', 'Auth\ProviderResetPasswordController@showResetForm')->name('provider.password.reset');
    });


//    Route::get('login/company', 'Auth\LoginController@loginCompanyForm')->name('login.company');
//    Route::get('login/employee', 'Auth\LoginController@loginEmployeeForm')->name('login.employee');
//    Route::get('login/provider', 'Auth\LoginController@loginProviderForm')->name('login.provider');
//
//    Route::post('login/company', 'Auth\LoginController@loginCompany')->name('login.company');
//    Route::post('login/employee', 'Auth\LoginController@loginEmployee')->name('login.employee');
//    Route::post('login/provider', 'Auth\LoginController@loginProvider')->name('login.provider');

});

Route::get('attendances_sheet/excel', 'Dashboard\AttendanceController@extractExcel');

Route::view('/domain', 'auth.domain_page');

//Route::domain('www.cashuce.com')->group(function () {
//
//    Route::redirect('/', 'https://cashuce.com');
//});


//

//
//Route::group([
//    'prefix' => LaravelLocalization::setLocale(),
//    'domain' =>  'signin.' . config('app.url'),
//    'middleware' => [
//        'localeCookieRedirect',
//        'localizationRedirect',
//        'localeViewPath' ]
//], function() {
//
//    Route::get('/login', function(){
//        return view('auth.domain_page');
//    });
//});

//
//Route::redirect('/',  'http://signup.localhost:8000/');
//
//Route::group([
//    'prefix' => LaravelLocalization::setLocale(),
//    'domain' =>  'signup.' . config('app.url'),
//    'middleware' => [
//        'localeCookieRedirect',
//        'localizationRedirect',
//        'localeViewPath' ]
//], function() {
//
//    Auth::routes([
//        'login' => false, // Registration Routes...
//        'reset' => false, // Password Reset Routes...
//        'verify' => true, // Email Verification Routes...
//        'logout' => false, // Email Verification Routes...
//        'password.*' => false, // Email Verification Routes...
//        'verifications' => false, // Email Verification Routes...
//    ]);
//});

Route::get('/setEndDate', function(){


    $employees = Employee::withoutGlobalScopes([ParentScope::class, \App\Scopes\SupervisorScope::class, \App\Scopes\ServiceStatusScope::class, ProviderScope::class, \App\Scopes\SupervisorScope::class, \App\Scopes\CompletedScope::class])->get();


    foreach ($employees as $employee){
        $contractStartDate = $employee->contract_start_date ?? \Carbon\Carbon::today();
        $contractPeriod = $employee->contract_period ?? 12;
        $employee->contract_end_date = $contractStartDate->addMonths($contractPeriod)->format('Y-m-d');
        $employee->save();

    }
    dd($employees->count());
});
Route::get('/setbalance', function(){

    $employees = Employee::withoutGlobalScopes([
        ParentScope::class,
        ProviderScope::class,
        \App\Scopes\CompletedScope::class])->get();

    foreach ($employees as $employee){
        $dailyBalance = $employee->leave_balance / 365;

        if(\Carbon\Carbon::today()->lt($employee->contract_end_date)){
            $availableBalance = $employee->available_balance + $dailyBalance;
        }

        $employee->update([
            'available_balance' => number_format($availableBalance, 2)
        ]);

    }


});

use App\Company;
Route::get('abdoforda', function () {
    
    $activeEmployees = Company::find(Company::companyID())->employees;
    foreach($activeEmployees as $em){
        echo $em->id.',';
    }

    return;
})->middleware('auth:employee,company,provider');