<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        date_default_timezone_set('Europe/Paris');
        $this->publishes([
    __DIR__ . '/../../vendor/components/font-awesome/css' => public_path('vendor/components/font-awesome/css'),
    __DIR__ . '/../../vendor/components/font-awesome/fonts' => public_path('vendor/components/font-awesome/fonts')
        ], 'public');
    }
}
