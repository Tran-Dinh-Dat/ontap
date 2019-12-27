<?php

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

Route::get('/', function () {
    return view('welcome');
});
// create short link
Route::get('/short', function(){
    return view('url.short');
});
Route::post('/short', 'Url\UrlController@short');
Route::get('/short/{link}', 'Url\UrlController@shortLink');

Route::post('/logout', 'Security\LoginControler@logout');

Route::group(['middleware' => 'visitors'], function () {
    Route::get('/register', 'Security\RegisterControler@register');
    Route::post('/register', 'Security\RegisterControler@registerUser');

    Route::get('/login', 'Security\LoginControler@login');
    Route::post('/login', 'Security\LoginControler@postLogin');
    
    Route::get('/activate/{email}/{code}', 'Security\ActivationControler@activate');
    Route::get('/reset_password/{email}/{code}', 'Security\ForgotPasswordControler@reset');
    Route::post('/reset_password/{email}/{code}', 'Security\ForgotPasswordControler@resetPassword');

    Route::get('/forgot_password', 'Security\ForgotPasswordControler@forgotPasswordForm');
    Route::post('/forgot_password', 'Security\ForgotPasswordControler@forgotPassword');
});

Route::group(['middleware' => 'admin'], function () {
    Route::get('/report', 'Reports\ReportController@report');
});

Route::get('/form', 'Form\FormController@view');
Route::get('/permission', 'Security\PermissionController@assign');
Route::post('/permission', 'Security\PermissionController@assignPermission');

// Test
// Laravel Accessors and Mutators
Route::get('/accessors', 'Test\TestController@accessors');
Route::get('/mutators', 'Test\TestController@mutators');
// Laravel Query Scope 
Route::get('/qscope', 'Test\TestController@qscope');
// Laravel Session 
Route::get('/session', 'Test\TestController@session');
// Laravel Import Excel File to Database
Route::get('/import', 'Test\TestController@import');
Route::post('/import', 'Test\TestController@importExcel');

Route::get('/export', 'Test\TestController@export');
Route::post('/export', 'Test\TestController@exportExcel');

Route::get('/profile', 'User\UserController@profile');
Route::post('/profile', 'User\UserController@profileImage');


