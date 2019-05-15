<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;

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
        
        Validator::extend('mobile', function($attribute, $value, $parameters, $validator) {
            $value = preg_replace('/\s+/', '', $value);
            $output = [];
            preg_match('/^(?:09|\+639)\d{9}$/', $value, $output);
            return count($output) != 0;
        });

        Validator::extend('adult', function($attribute, $value, $parameters){
            $minAge = ( ! empty($parameters)) ? (int) $parameters[0] : 18;
            return Carbon::now()->diff(new Carbon($value))->y >= $minAge;
        });
    }
}
