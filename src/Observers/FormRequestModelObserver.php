<?php
namespace Daikazu\FormRequestHandler\Observers;
use Daikazu\FormRequestHandler\Enums\FormRequestStatus;
use Daikazu\FormRequestHandler\Events\FormRequestSavedEvent;
use Daikazu\FormRequestHandler\Models\FormRequest;
use Illuminate\Support\Str;
class FormRequestModelObserver
{
    public function creating(FormRequest $formRequest)
    {
        dump('creating');
        dump($formRequest->email_subject);

        // Don't let people provide their own UUIDs, we will generate a proper one.
        $formRequest->uuid = Str::uuid();
        // Set default status
        $formRequest->status = FormRequestStatus::PENDING ;
        return null;
    }
    public function saving(FormRequest $formRequest)
    {

        dump('saving');
        dump($formRequest->email_subject);

        // What's that, trying to change the UUID huh?  Nope, not gonna happen.
        $original_uuid = $formRequest->getOriginal('uuid');
        if ($original_uuid !== $formRequest->uuid) {
            $formRequest->uuid = $original_uuid;
        }
        return null;
    }
    public function saved(FormRequest $formRequest)
    {

        dump('saved');
        dump($formRequest->email_subject);


        if ($formRequest->status === FormRequestStatus::PENDING ) {
            event(new FormRequestSavedEvent($formRequest));
        }
    }
}
