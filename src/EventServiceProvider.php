<?php

namespace Daikazu\FormRequestHandler;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [];

    public function __construct()
    {
        foreach (config('form-request-handler.events') as $event => $listener) {
            $this->listen[$event] = $listener;
        }
    }

    public function boot()
    {
        parent::boot();
    }
}
