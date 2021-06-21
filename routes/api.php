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



Route::prefix('v1')->namespace('Api')->group(function(){

     //ROTA PARA CONFIRMAR O LOGIN DO USUARIO, RETORNA UM TOKEN
     Route::post('/login', 'Auth\\LoginJwtController@login')->name('login');
     //ROTA PARA LOGOUT DO USUARIO TOKEN É INVALIDADO NA BLACKLISTED
     Route::get('/logout', 'Auth\\LoginJwtController@logout')->name('logout');
     //ROTA PARA RENOVAR O TOKEN DO USUARIO ENVIAR O ANTIGO TOKEN
     Route::get('/refresh', 'Auth\\LoginJwtController@refresh')->name('refresh');



     Route::group(['middleware' => ['jwt.auth']], function(){

        Route::name('student.')->group(function(){

            Route::get('student/{id}/debt', 'StudentController@debt');
            Route::resource('student', 'StudentController');

        });

        Route::name('course.')->group(function(){

            Route::resource('course', 'CourseController');

        });

    });
});


