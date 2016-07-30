<?php

namespace App\Providers;

use App\User;
use Auth;
use Illuminate\Support\ServiceProvider;
use Validator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Validator::extend('validate_auth', function ($attribute, $value, $parameters, $validator) {
            $user = User::findOrFail($parameters[0]);
            return Auth::validate([
                'email' => $user->email,
                'password' => $value,
            ]);
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
