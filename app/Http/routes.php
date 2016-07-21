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

    Route::get('users/{user}/edit', 'UserController@edit');

    Route::get('websites/{website}', 'WebsiteController@show');

    Route::get('profile', 'UserController@profile');

    Route::get('external/users', 'UserController@getExternalUsers');

    Route::get('messages', 'MessageController@index');

    Route::group(['middleware' => 'admin'], function () {

        Route::get('users', 'UserController@index');

        Route::get('websites', 'WebsiteController@index');

        Route::get('websites/{website}/users', 'WebsiteController@users');

        Route::group(['middleware' => 'api', 'prefix' => 'api', 'namespace' => 'API'], function () {

            Route::get('users', 'UserController@index');

            Route::delete('users', 'UserController@delete');

            Route::post('websites', 'WebsiteController@store');

            Route::put('websites/{website}', 'WebsiteController@update');

            Route::put('websites/{website}/change-photo', 'WebsiteController@changePhoto');

            Route::delete('websites/{website}', 'WebsiteController@delete');

            Route::get('websites/{website}/users', 'WebsiteController@users');

            Route::get('websites/{website}/managed-users', 'WebsiteController@managedUsers');

            Route::get('websites/{website}/users/{search}', 'WebsiteController@searchUsers');

            Route::post('websites/{website}/managed-users', 'WebsiteController@storeManagedUsers');

            Route::delete('websites/{website}/unmanage-users', 'WebsiteController@unmanageUsers');

            Route::put('websites/{website}/managed-users/{id}', 'WebsiteController@updateManagedUser');
        });

    });

    Route::group(['middleware' => 'api', 'prefix' => 'api', 'namespace' => 'API'], function () {

        Route::post('users', 'UserController@store');

        Route::put('users/{id}', 'UserController@update');

        Route::get('websites', 'WebsiteController@index');

    });

});
