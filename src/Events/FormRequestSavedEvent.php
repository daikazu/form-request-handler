<?php
namespace Daikazu\FormRequestHandler\Events;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Daikazu\FormRequestHandler\Models\FormRequest;
class FormRequestSavedEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    /**
     * @var FormRequest
     */
    public $formRequest;
    public function __construct(FormRequest $formRequest)
    {

        dump('FormRequestSavedEvent');
        dump($formRequest->email_subject);
        $this->formRequest = $formRequest;
    }
}
