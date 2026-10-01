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

        \Validator::extend('unique_slug_per_country', function ($attribute, $value, $parameters) {
            if ($value === null || $value === '') {
                return true;
            }

            $ignoreId = isset($parameters[0]) ? $parameters[0] : null;
            $cityId = \Request::get('city_id');
            $city = $cityId ? \App\Models\City::find($cityId) : null;
            $countryId = $city ? $city->country_id : null;
            if (!$countryId) {
                return true;
            }

            $query = \App\Models\Project::where('slug', $value)->whereHas('city', function ($q) use ($countryId) {
                $q->where('country_id', $countryId);
            });
            if ($ignoreId !== null && $ignoreId !== '' && strtoupper((string) $ignoreId) !== 'NULL') {
                $query->where('id', '!=', $ignoreId);
            }

            return $query->count() === 0;
        }, trans('validation.unique'));
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
        $this->app['db']->extend('mysql', function ($config, $name) {
            $connection = $this->app['db.factory']->make($config, $name);
            $connection->setPostProcessor(new \App\Database\MySqlProcessor);
            return $connection;
        });
    }
}
