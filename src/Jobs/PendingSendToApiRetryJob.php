<?php
namespace Daikazu\FormRequestHandler\Jobs;
use Carbon\Carbon;
use Daikazu\FormRequestHandler\Enums\FormRequestStatus;
use Daikazu\FormRequestHandler\Models\FormRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
class PendingSendToApiRetryJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $tries = 1;
    public function handle()
    {
        if (config('form-request-handler.send_to_api')) {
            $formRequests = FormRequest::where('status', FormRequestStatus::PENDING)->whereTime('created_at', '<',
                Carbon::now()->subMinutes(10)->toTimeString())->get();
            foreach ($formRequests as $formRequest) {
                dispatch(new SendFormRequestToAPIJob($formRequest));
            }
        }
    }
}
