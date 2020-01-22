<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Handlers\SmsHandler;

class SmsServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(SmsHandler::class, function ($app){
            return new SmsHandler(config('sms'));
        });

        $this->app->alias(SmsHandler::class, 'smshandler');
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
