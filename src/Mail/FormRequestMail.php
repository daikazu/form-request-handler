<?php

namespace Daikazu\FormRequestHandler\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Daikazu\FormRequestHandler\Models\FormRequest;

class FormRequestMail extends Mailable
{
    use Queueable, SerializesModels;
    /**
     * @var FormRequest
     */
    private $formRequest;

    /**
     * Create a new message instance.
     *
     * @param FormRequest $formRequest
     */
    public function __construct(FormRequest $formRequest)
    {
        $this->formRequest = $formRequest;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        if (config('form-request-handler.send_to_email_otag')) {
            $this->withSwiftMessage(function ($message) {
                $message->getHeaders()
                    ->addTextHeader('o:tag', config('form-request-handler.send_to_email_otag'));
            });
        }
        $mailer = $this->text('form-request-handler::email', ['formRequest' => $this->formRequest]);
        // SEND TO EMAIL ADDRESS
        $mailer->from(config('form-request-handler.send_to_email_address'));
        // EMAIL SUBJECT LINE
        $mailer->subject($this->formRequest->email_subject);
        return $mailer;
    }
}
