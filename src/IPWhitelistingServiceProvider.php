<?php

namespace WebToppings\IPWhitelisting;

use Illuminate\Support\ServiceProvider;

class IPWhitelistingServiceProvider extends ServiceProvider
{
    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->make('WebToppings\IPWhitelisting\IPWhitelistingController');
    }

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__.'/migrations');
        $this->loadViewsFrom(__DIR__.'/views', 'ipwhitelisting');
        $this->publishes([
            __DIR__.'/views' => base_path('resources/views/webtoppings/ipwhitelisting'),
        ]);
    }
}
