<?php

namespace App\Jobs;

use App\Http\Clients\UtilToolsClient;
use App\Mail\SuccessfulTransactionEmail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class ResendEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 3;

    public $timeout = 30;

    public function __construct(protected array $emailData)
    {
    }

    public function handle(): void
    {
        try {
            $utilToolsClient = new UtilToolsClient();
            if (! $utilToolsClient->getNotifyServiceStatus()) {
                $this->release(600);

                return;
            }
            Mail::to($this->emailData['payee_email'])->send(new SuccessfulTransactionEmail($this->emailData));
        } catch (\Exception $e) {
            Log::error('Failed to send email in job: '.$e->getMessage());
            $this->release(60);
        }
    }
}
