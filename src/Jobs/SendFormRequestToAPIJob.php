<?php
namespace Daikazu\FormRequestHandler\Jobs;
use Daikazu\FormRequestHandler\Enums\FormRequestStatus;
use Daikazu\FormRequestHandler\Models\FormRequest;
use Daikazu\FormRequestHandler\Notifications\SimpleNotice;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
class SendFormRequestToAPIJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $tries = 1;
    /**
     * @var FormRequest
     */
    private $formRequest;
    public function __construct(FormRequest $formRequest)
    {
        $this->formRequest = $formRequest;
    }
    public function handle()
    {
//
        $payload = [
            'token'    => config('form-request-handler.api.token'),
            'siteCode' => config('form-request-handler.api.site_id'),
            'data'     => $this->formRequest->toArray(),
        ];
        $client = new Client();
        try {
            $client = new Client();
            $response = $client->post(config('form-request-handler.api.submit_url'), ['form_params' => $payload]);
            $rtrnData = json_decode($response->getBody()->getContents());
            //TODO: ADD API RESPONSE CHECK HERE
            $this->formRequest->status = FormRequestStatus::COMPLETED;
//            $this->formRequest->save();
            if (array_has( config('form-request-handler.notifications'),'slack')) {
                $this->formRequest->notify(new SimpleNotice('✅ Form Request `' . $this->formRequest->uuid . '` was sent to API.'),
                    'success');
            }
        } catch (RequestException $e) {
            if ($e->hasResponse()) {
                if (array_has( config('form-request-handler.notifications'),'slack')) {
                    $this->formRequest->notify(new SimpleNotice('❌ Form Request `' . $this->formRequest->uuid . '` Failed to send to API. ' . '`' . $e->getResponse() . '`'),
                        'error');
                }
            }
            if (array_has( config('form-request-handler.notifications'),'slack')) {
                $this->formRequest->notify(new SimpleNotice('❌ Form Request `' . $this->formRequest->uuid . '` Failed to send to API.'),
                    'error');
            }
            return null;
        }
    }
}
