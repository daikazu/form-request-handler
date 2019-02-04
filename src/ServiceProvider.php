<?php

namespace Daikazu\FormRequestHandler;

use Illuminate\Console\Scheduling\Schedule;
use Daikazu\FormRequestHandler\Jobs\PendingSendToApiRetryJob;
use Daikazu\FormRequestHandler\Observers\FormRequestModelObserver;
use Daikazu\FormRequestHandler\Models\FormRequest;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    const CONFIG_PATH = __DIR__ . '/../config/form-request-handler.php';

    public function boot()
    {
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'form-request-handler');

        $this->publishes([
            __DIR__ . '/../config/form-request-handler.php' => config_path('form-request-handler.php'),
            __DIR__ . '/../resources/views'                 => base_path('resources/views/vendor/form-request-handler'),
        ], 'form-request-handler');

        FormRequest::observe(FormRequestModelObserver::class);

        $this->app->booted(function () {
            $schedule = app(Schedule::class);
            $schedule->job(new PendingSendToApiRetryJob())->everyTenMinutes();
        });


    }

    public function register()
    {
        $this->mergeConfigFrom(
            self::CONFIG_PATH,
            'form-request-handler'
        );

        $this->loadMigrationsFrom(__DIR__ . '/Migrations');
        $this->app->register(EventServiceProvider::class);


        $this->app->bind('form-request-handler', function () {
            return new FormRequestHandler();
        });
    }
}
