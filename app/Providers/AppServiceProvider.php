<?php

namespace App\Providers;

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
            $user = auth()->user();
            $current_month_income = 0;
            $last_month_income = 0;

            $current_month_messages = $user->sent_messages()->where('created_at', '>', Carbon::now()->startOfMonth())->get();
            $last_month_messages = $user->sent_messages()->whereBetween('created_at',
                [Carbon::now()->subMonth(), Carbon::now()->startOfMonth()])
                ->get();

            foreach ($current_month_messages as $current) {
                $current_month_income = $current_month_income + ($user->pay_rate * $current->replies->count());
            }

            foreach ($last_month_messages as $last_month) {
                $last_month_income = $last_month_income + ($user->pay_rate * $last_month->replies->replies->count());
            }
            $view->with('last_month_income', $last_month_income);
            $view->with('current_month_income', $current_month_income);
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
