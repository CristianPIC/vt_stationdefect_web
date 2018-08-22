<?php

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

Route::get('/', function () {
    return view('welcome');
});
Route::post('/resources/checkversion','MainController@postCheckversion');
Route::post('/resources/data_static','MainController@postDataStatic');
Route::post('/resources/data','MainController@postData');
Route::post('/resources/reportproblem','MainController@postReportProblem');

