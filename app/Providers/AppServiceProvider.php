<?php

namespace App\Providers;

use App\Config;
use App\User;
use Auth;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
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

        view()->composer('_partials.header', function (View $view) {
            $currency = Config::whereKey('currency')->first()->value;
            $user = auth()->user();
            $current_income = 0;

            $current_month_messages = $user->sent_messages()->where('created_at', '>', Carbon::now()->startOfMonth())->get();

            foreach ($current_month_messages as $current) {
                $current_income = $current_income + ($user->pay_rate * $current->replies->count());
            }

            $view->with(compact('current_income', 'currency'));
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
