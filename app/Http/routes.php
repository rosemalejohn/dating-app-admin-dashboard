<?php

Route::auth();

Route::group(['prefix' => 'affiliate-user'], function () {
    Route::get('login', 'AffiliatesAuth\AuthController@showLoginForm');
    Route::post('login', 'AffiliatesAuth\AuthController@login');
    Route::get('logout', 'AffiliatesAuth\AuthController@logout');
    Route::get('home', 'AffiliateController@index');
});

Route::get('/', 'DashboardController@index');

Route::group(['middleware' => ['auth', 'tenant']], function () {

    Route::get('profile', 'UserController@profile');

    Route::group(['prefix' => 'users'], function () {

        Route::get('/', 'UserController@index');

        Route::get('{user}/edit', 'UserController@edit');

        Route::get('{user}/account', 'UserController@getAccount');

    });

    Route::group(['prefix' => 'chat'], function () {

        Route::get('/', 'ChatController@lobby');

        Route::get('next', 'ChatController@nextConversation');

        Route::get('{website}/{conversation}', 'ChatController@conversation');

    });

    Route::group(['prefix' => 'websites'], function () {

        Route::get('/', 'WebsiteController@index');

        Route::get('{website}', 'WebsiteController@show');

        Route::get('{website}/users', 'WebsiteController@users');

    });

    Route::get('settings/system', 'SettingsController@system');

});

Route::group(['middleware' => ['api', 'auth', 'tenant'], 'prefix' => 'api', 'namespace' => 'API'], function () {

    Route::get('auth', function () {

        return response()->json(auth()->user());

    });

    Route::get('conversations/flagged', function () {
        $conversations = \App\FlaggedConversation::with('user')->get();

        return response()->json($conversations, 200);
    });

    Route::group(['prefix' => 'users'], function () {

        Route::post('/', 'UserController@store');

        Route::put('{id}', 'UserController@update');

        Route::delete('/', 'UserController@delete');

        Route::put('{user}/account', 'UserController@updateAccount');

        Route::post('{user}/clear-earnings', 'UserController@clearEarnings');

    });

    Route::delete('notes/{note}', 'NoteController@delete');

    Route::put('notes/{note}', 'NoteController@update');

    Route::group(['prefix' => 'chat'], function () {

        Route::get('/', 'ChatController@lobby');

        Route::get('{website}/{conversation}', 'ChatController@conversation');

        Route::post('{website}/flag-conversation', 'ChatController@flagConversation');

        Route::put('{website}/flag-conversation/{flag_conversation_id}', 'ChatController@updateFlagConversation');

        Route::post('{website}/{conversation}', 'ChatController@send');

        Route::get('{website}/{conversation}/messages', 'ChatController@getMessages');

        Route::post('{website}/{conversation}/notes', 'ChatController@storeNotes');

        Route::delete('{website}/{conversation}/unflag', 'ChatController@unflagConversation');

        Route::delete('{website}/{conversation}/active-conversation', 'ChatController@removeActiveConversation');

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

    Route::group(['prefix' => 'stats'], function () {

        Route::get('/', 'StatController@getStats');

        Route::get('{website}/messages', 'StatController@getMessagesPerDay');

    });

    Route::group(['prefix' => 'settings'], function () {

        Route::get('/', 'SettingsController@index');

        Route::put('/', 'SettingsController@update');

    });

});
