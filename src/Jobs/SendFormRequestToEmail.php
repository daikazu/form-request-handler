<?php
namespace Daikazu\FormRequestHandler\Jobs;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Daikazu\FormRequestHandler\Enums\FormRequestStatus;
use Daikazu\FormRequestHandler\Mail\FormRequestMail;
use Daikazu\FormRequestHandler\Models\FormRequest;
class SendFormRequestToEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    /**
     * @var FormRequest
     */
    private $formRequest;
    /**
     * Create a new job instance.
     *
     * @param FormRequest $formRequest
     */
    public function __construct(FormRequest $formRequest)
    {
        dump('SendFormRequestToEmail');
        dump($formRequest->email_subject);

        $this->formRequest = $formRequest;
    }
    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to(config('form-request-handler.send_to_email_address'))->send(new FormRequestMail($this->formRequest));
        // If SEND TO API is false then mark as completed so we don't try to resend older
        // requests once it is SEND TO API
        if (!config('form-request-handler.send_to_api')) {
            $this->formRequest->status = FormRequestStatus::COMPLETED;
            $this->formRequest->save();
        }
    }
}
