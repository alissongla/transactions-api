<?php

namespace App\Services;

use App\Http\Clients\UtilToolsClient;
use App\Http\Repositories\Transaction\TransactionRepository;
use App\Http\Repositories\User\AccountRepository;
use App\Jobs\SendSuccessfulTransactionEmail;

class TransactionService
{
    const USER_ID_FIELD = 'user_id';
    public function __construct(
        public readonly AccountRepository $accountRepository,
        public readonly TransactionRepository $transactionRepository,
        public readonly UtilToolsClient $utilToolsClient
    )
    {
    }

    /**
     * Creates a transaction between two users.
     *
     * @param int $payerUserId
     * @param int $payeeUserID
     * @param float $value
     *
     * @return mixed Returns the transaction if successful, or a JSON response with an error message if unsuccessful.
     */
    public function createTransaction($payerUserId, $payeeUserID, $value)
    {
        if ($payerUserId === $payeeUserID) {
            return $this->responseError('You cannot transfer to yourself');
        }

        $payer = $this->accountRepository->findByCustomColumn($payerUserId, self::USER_ID_FIELD);
        $payee = $this->accountRepository->findByCustomColumn($payeeUserID, self::USER_ID_FIELD);

        if (!$payer || !$payee) {
            return $this->responseError('User not found');
        }

        if($payer->type === 'PJ'){
            return $this->responseError('Shopkeeper cannot make transactions');
        }

        if ($payer->balance < $value) {
            return $this->responseError('Insufficient balance');
        }

        $authorization = $this->utilToolsClient->getAuthorization();
        if(!$authorization) {
            return $this->responseError('Error on authorization');
        }

        $transaction = $this->transactionRepository->createTransaction($payer, $payee, $value);
        if (!$transaction) {
            return $this->responseError('Error on transaction');
        }
        $this->accountRepository->updateBalance($payer, $payee, $value);

        $mailJob = new SendSuccessfulTransactionEmail($transaction->id);
        dispatch($mailJob);
        return response()->json(['message' => 'Transaction completed', 'transaction' => $transaction], 200);
    }

    /**
     * Deletes a transaction.
     *
     * @param int $transactionId
     * @return JsonResponse
     * If the transaction does not exist, a JSON response with a status code of 400 and an error message is returned.
     */
    public function deleteTransaction($transactionId)
    {
        $transaction = $this->transactionRepository->find($transactionId);
        if (!$transaction) {
            return $this->responseError('Transaction not found');
        }

        $payer = $this->accountRepository->findByCustomColumn($transaction->payer_user_id, self::USER_ID_FIELD);
        $payee = $this->accountRepository->findByCustomColumn($transaction->payee_user_id, self::USER_ID_FIELD);

        $this->accountRepository->reverseBalance($payer, $payee, $transaction->value);
        $this->transactionRepository->delete($transactionId);

        return response()->json(['message' => 'Transaction deleted'], 200);
    }

    /**
     * Restores a previously deleted transaction.
     *
     * @param int $transactionId
     * @return JsonResponse
     * If the transaction does not exist, a JSON response with a status code of 400 and an error message is returned.
     */
    public function restoreTransaction($transactionId)
    {
        $transaction = $this->transactionRepository->findTrashed($transactionId);
        if (!$transaction) {
            return $this->responseError('Transaction not found');
        }

        $payer = $this->accountRepository->findByCustomColumn($transaction->payer_user_id, self::USER_ID_FIELD);
        $payee = $this->accountRepository->findByCustomColumn($transaction->payee_user_id, self::USER_ID_FIELD);

        $this->accountRepository->updateBalance($payer, $payee, $transaction->value);
        $this->transactionRepository->restore($transactionId);

        return response()->json(['message' => 'Transaction restored'], 200);
    }

    private function responseError($message) {
        return response()->json(['message' => $message], 400);
    }
}
