<?php

namespace App\Providers;

use App\Services\Gumroad\GumroadService;
use Illuminate\Support\ServiceProvider;

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
        $this->app->when(GumroadService::class)
            ->needs('$accessToken')
            ->give(config('services.gumroad.access_token'));

        $this->app->when(GumroadService::class)
            ->needs('$uri')
            ->give(config('services.gumroad.uri'));
    }
}
