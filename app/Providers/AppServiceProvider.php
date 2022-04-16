<?php

namespace App\Providers;

use App\Models\Setting;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot()
    {
        \View::composer('*', function ($view) {

            $settings = Setting::find(1);

            $view->with('settings', $settings);
        });
    }
}
