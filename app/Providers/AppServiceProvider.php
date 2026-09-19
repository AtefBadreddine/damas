<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Request;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app['request']->server->set('HTTP', 'on');// i have remove "S" here
        /*if ( !Request::secure() && env('APP_ENV') === 'production') {
            $a = \URL::current();
            $a = str_replace("http://", "https://", $a);
            header("Location:".$a);exit();
        }*/
        //return $next(); 
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
