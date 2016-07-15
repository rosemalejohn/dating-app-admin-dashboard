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

Route::auth();

Route::group(['middleware' => 'auth'], function () {

    Route::get('/', 'DashboardController@index');

    Route::group(['middleware' => 'admin'], function () {

        Route::get('users', 'UserController@index');

        Route::get('users/{user}/edit', 'UserController@edit');

        Route::get('websites', 'WebsiteController@index');

        Route::group(['prefix' => 'api', 'namespace' => 'API'], function () {

            Route::get('users', 'UserController@index');

            Route::post('users', 'UserController@store');

            Route::delete('users', 'UserController@delete');

        });

    });

});
