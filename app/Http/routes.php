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

Route::group(['middleware' => ['auth', 'tenant']], function () {

    Route::get('/', 'DashboardController@index');

    Route::get('profile', 'UserController@profile');

    Route::group(['middleware' => 'api', 'prefix' => 'api', 'namespace' => 'API'], function () {

        Route::group(['prefix' => 'users'], function () {

            Route::post('/', 'UserController@store');

            Route::put('{id}', 'UserController@update');

            Route::delete('/', 'UserController@delete');

        });

        Route::delete('notes/{note}', 'NoteController@delete');

        Route::put('notes/{note}', 'NoteController@update');

        Route::group(['prefix' => 'chat'], function () {

            Route::post('{website}/{conversation}', 'ChatController@send');

            Route::post('{website}/{conversation}/notes', 'ChatController@storeNotes');

        });

        Route::group(['prefix' => 'websites'], function () {

            Route::get('/', 'WebsiteController@index');

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

    Route::group(['prefix' => 'users'], function () {

        Route::get('/', 'UserController@index');

        Route::get('{user}/edit', 'UserController@edit');
    });

    Route::group(['prefix' => 'chat'], function () {

        Route::get('/', 'ChatController@lobby');

        Route::get('{website}/{conversation}', 'ChatController@conversation');

    });

    Route::group(['prefix' => 'websites'], function () {

        Route::get('/', 'WebsiteController@index');

        Route::get('{website}', 'WebsiteController@show');

        Route::get('{website}/users', 'WebsiteController@users');

    });

    Route::get('settings/system', 'SettingsController@system');

});
