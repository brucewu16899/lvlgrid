<?php

namespace Mrjj\LvlGrid;

use Illuminate\Support\ServiceProvider;

class LvlGridServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadViewsFrom(__DIR__ . '/../../resources/views', 'lvlgrid');

        $this->publishes([
            __DIR__ . '/../../resources/views' => base_path('resources/views/vendor/mrjj/lvlgrid')
        ]);
    }

    public function register()
    {
        $this->app->singleton('lvlgrid', function () {
            return $this->app->make(LvlGrid::class);
        });
    }

    public function provides()
    {
        return ['lvlgrid'];
    }
}
