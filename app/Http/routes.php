<?php

use App\DomainUser;

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

//Route::get('/', 'SmsHomeController@index');

//mobile url setting
Route::get('/mobile','MobileController@mobileSendSms');
Route::get('/mobilejson','MobileController@mobileGetJson');


//Test sms api Rout Control
Route::post('/setting/smssend','SmsSettingController@sendlumensms');
Route::post('/student/{student}/smssend','SmsStudentController@sendsms');

//Test Email Control
Route::post('/setting/emailsend','SmsSettingController@sendemail');

//Excel Route Control
Route::post('/student/uploadexcel','SmsStudentController@uploadExcel');
Route::get('/student/downloadexcel','SmsStudentController@downloadExcel');

//Patch students into a Course Route Control
Route::post('/course/{course}/patchstudent','SmsCourseController@patchstudent');

//All default Route Please Check in command [ $ php artisan route:list ]  in smslaravel root path
$router->resource('home','SmsHomeController');
$router->resource('course','SmsCourseController');
$router->resource('student','SmsStudentController');
$router->resource('messagestate','SmsMessageController');
$router->resource('setting','SmsSettingController');


Route::group(['domain' => '{account}.send2me.cc'], function()
{

    Route::get('/', function($account)
    {
    	Session::set('subdomain',$account);
    	//DB::setDefaultConnection('mysql_subdomainusers');
    	//$users=DomainUser::get()->where('domain',$account);
	    	//dd($users);
	    	$dbname=$account;
	    	Config::set('database.connections.mysql_subdomain.database',$dbname);
	    	DB::setDefaultConnection('mysql_subdomain');

			return Redirect::to('/home');
        //
    });

});


//laravel default login route control
Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);
