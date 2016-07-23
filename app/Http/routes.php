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

    Route::get('conversations', 'ConversationController@index');

    Route::group(['middleware' => 'admin'], function () {

        Route::get('users', 'UserController@index');

        Route::group(['middleware' => 'tenant', 'prefix' => 'websites'], function () {

            Route::get('/', 'WebsiteController@index');

            Route::get('{website}/users', 'WebsiteController@users');

            Route::get('{website}/conversations', 'ConversationController@index');

        });

        Route::group(['middleware' => 'api', 'prefix' => 'api', 'namespace' => 'API'], function () {

            Route::get('users', 'UserController@index');

            Route::delete('users', 'UserController@delete');

            Route::group(['middleware' => 'tenant', 'prefix' => 'websites'], function () {

                Route::post('/', 'WebsiteController@store');

                Route::put('{website}', 'WebsiteController@update');

                Route::put('{website}/change-photo', 'WebsiteController@changePhoto');

                Route::delete('{website}', 'WebsiteController@delete');

                Route::get('{website}/users', 'WebsiteController@users');

                Route::get('{website}/managed-users', 'WebsiteController@managedUsers');

                Route::get('{website}/users/{search}', 'WebsiteController@searchUsers');

                Route::post('{website}/managed-users', 'WebsiteController@storeManagedUsers');

                Route::delete('{website}/unmanage-users', 'WebsiteController@unmanageUsers');

                Route::put('{website}/managed-users/{id}', 'WebsiteController@updateManagedUser');

            });

        });

    });

    Route::group(['middleware' => 'api', 'prefix' => 'api', 'namespace' => 'API'], function () {

        Route::post('users', 'UserController@store');

        Route::put('users/{id}', 'UserController@update');

    });

});
