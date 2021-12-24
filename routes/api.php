<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware(['cors', 'json.response', 'auth:employee-api'])->get('/user', function (Request $request) {
    return $request->user();
});


Route::group(['middleware' => ['cors']], function () {

    Route::post('/login', 'API\Auth\ApiAuthController@login')->name('login.api');
    Route::middleware(['cors', 'json.response', 'auth:company-api,employee-api,provider-api'])->post('/logout', 'API\Auth\ApiAuthController@logout')->name('logout.api');

});

Route::middleware(['cors', 'json.response', 'auth:employee-api'])->group(function () {
    Route::get('/pay_slip', 'API\EmployeeController@paySlip');
    Route::get('/job_info', 'API\EmployeeController@jobInfo');
    Route::post('/punch', 'API\AttendanceController@store');

    Route::get('/vacation_requests', 'API\VacationController@leaveRequests');
    Route::post('/vacations', 'API\VacationController@store');
    Route::get('/vacation_types', 'API\VacationTypeController@index');

    Route::get('/resignations', 'API\ResignationController@index');
    Route::post('/resignations', 'API\ResignationController@store');

    Route::get('/missed_punch_requests', 'API\AttendanceForgottenController@index');
    Route::post('/missing_punches', 'API\AttendanceForgottenController@store');

});

Route::get('/check_domain_name', 'CheckDomainController@isDomainNameExist');
Route::get('/forget_domain_name', 'CheckDomainController@forgetDomainName');
Route::post('/forgot-password', 'API\Auth\ApiAuthController@forgot_password');



