<?php

namespace Tjwenke\Alidayu;

use Illuminate\Support\ServiceProvider as LaravelServiceProvider;

class ServiceProvider extends LaravelServiceProvider
{
    protected $defer = true;

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/config.php' => config_path('alidayu.php'),
        ]);
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/config.php', 'alidayu'
        );
        $this->app->singleton(MessageService::class, function ($app) {
            return new MessageService();
        });
    }
    
    public function provides()
    {
        return [MessageService::class];
    }
}
