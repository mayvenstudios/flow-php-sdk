<?php

namespace FlowSDK;
use Illuminate\Support\ServiceProvider;

class FlowServiceProvider extends ServiceProvider{


    public function boot()
    {
        $this->publishes([
            __DIR__.'/../../config/flow.php' => config_path('flow.php'),
        ]);
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../../config/flow.php', 'flow');

        //$this->app->singleton(Flow::class, function () {
        //    return new Flow();
        //});

        $this->app->bind('flow', function($app) {
            return new Flow();
        });
    }

}