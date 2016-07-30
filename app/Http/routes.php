<?php

Route::auth();

Route::group(['middleware' => ['auth', 'tenant']], function () {

    Route::get('/testing', function (\App\Services\TenantService $tenant) {

        $this_month = \Carbon\Carbon::now()->startOfMonth();

        $user_sent_messages = \App\UserSentMessage::with('website', 'user')->where('created_at', '>=', $this_month)->get();

        $user_sent_messages->filter(function ($user_sent_message, $key) use ($tenant) {
            $tenant->connect($user_sent_message->website);

            $message = $user_sent_message->message->conversation->messages()
                ->where('id', $user_sent_message->message_id)->first();

            dd($message);
        });

    });

    Route::get('/', 'DashboardController@index');

    Route::get('profile', 'UserController@profile');

    Route::group(['middleware' => 'api', 'prefix' => 'api', 'namespace' => 'API'], function () {

        Route::get('auth', function () {

            return response()->json(auth()->user());

        });

        Route::group(['prefix' => 'users'], function () {

            Route::post('/', 'UserController@store');

            Route::put('{id}', 'UserController@update');

            Route::delete('/', 'UserController@delete');

            Route::put('{user}/account', 'UserController@updateAccount');

        });

        Route::delete('notes/{note}', 'NoteController@delete');

        Route::put('notes/{note}', 'NoteController@update');

        Route::group(['prefix' => 'chat'], function () {

            Route::get('/', 'ChatController@lobby');

            Route::get('{website}/{conversation}', 'ChatController@conversation');

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

        Route::group(['prefix' => 'stats'], function () {

            Route::get('/', 'StatController@getStats');

            Route::get('{website}/messages', 'StatController@getMessagesPerDay');

        });

    });

    Route::group(['prefix' => 'users'], function () {

        Route::get('/', 'UserController@index');

        Route::get('{user}/edit', 'UserController@edit');

        Route::get('{user}/account', 'UserController@getAccount');

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
