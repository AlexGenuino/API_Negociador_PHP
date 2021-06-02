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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/test', function(Request $request){

	//dd($request->headers->all());
	//dd($request->headers->get('Authorization'));

	$response = new \Illuminate\Http\Response(json_encode(['msg' => 'funfou']));
	$response->header('Content-Type', 'application/json');

	return $response;
});

Route::prefix('v1')->namespace('Api')->group(function(){

    Route::name('student.')->group(function(){

        Route::resource('student', 'StudentController');

    });

    Route::name('course.')->group(function(){

        Route::resource('course', 'CourseController');

    });
});


