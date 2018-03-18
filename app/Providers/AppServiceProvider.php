<?php

namespace App\Providers;

use App\Channel;
use Barryvdh\Debugbar\ServiceProvider as DebugbarServiceProvider;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {


        \View::composer('*', function($view){

            $chanells = Cache::rememberForever('channels', function() {
                return Channel::all();
            });

            $view->with('channels', $chanells);
        });

       // \View::share('channels', \App\Channel::all());

    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
        if($this->app->isLocal()){
            $this->app->register(DebugbarServiceProvider::class);
        }
    }
}
