<?php

namespace Daikazu\FormRequestHandler\Listeners;

use Daikazu\FormRequestHandler\Events\FormRequestSavedEvent;
use Daikazu\FormRequestHandler\Jobs\SendFormRequestToAPIJob;
use Daikazu\FormRequestHandler\Jobs\SendFormRequestToEmail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class FormRequestListener implements ShouldQueue
{
    use InteractsWithQueue;

    public function __construct()
    {

    }

    public function handle(FormRequestSavedEvent $event)
    {

        dump('FormRequestListener(handle)');
        dump($event->formRequest->email_subject);

        if (config('form-request-handler.send_to_api')) {
            dispatch(new SendFormRequestToAPIJob($event->formRequest));
        }
        if (config('form-request-handler.send_to_email')) {
            dispatch(new SendFormRequestToEmail($event->formRequest));
        }
    }
}
