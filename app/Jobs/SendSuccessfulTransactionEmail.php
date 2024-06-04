<?php

namespace App\Jobs;

use App\Http\Clients\UtilToolsClient;
use App\Http\Repositories\Transaction\TransactionRepository;
use App\Mail\SuccessfulTransactionEmail;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendSuccessfulTransactionEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        private int $transactionId,
    ) {
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        $transactionRepository = new TransactionRepository(new Transaction());
        $utilToolsClient = new UtilToolsClient();
        $transaction = $transactionRepository->getTransaction($this->transactionId);
        $emailData = [
            'payer' => $transaction->payer->name,
            'payee' => $transaction->payee->name,
            'payee_email' => $transaction->payee->email,
            'value' => number_format($transaction->value, 2, ',', '.'),
            'transaction_id' => $transaction->id,
            'transaction_date' => Carbon::parse($transaction->created_at)->format('d/m/Y H:i:s'),
        ];

        if ($utilToolsClient->getNotifyServiceStatus()) {
            try {
                return Mail::to($transaction->payee->email)->send(new SuccessfulTransactionEmail($emailData));
            } catch (\Exception $e) {
                return ResendEmail::dispatch($emailData);
            }
        }

        return ResendEmail::dispatch($emailData);
    }
}
