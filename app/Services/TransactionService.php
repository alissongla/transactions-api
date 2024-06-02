<?php

namespace App\Services;

use App\Http\Clients\UtilToolsClient;
use App\Http\Repositories\Transaction\TransactionRepository;
use App\Http\Repositories\User\AccountRepository;
use App\Http\Repositories\User\UserRepository;

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

        return $transaction;
    }

    private function responseError($message) {
        return response()->json(['message' => $message], 400);
    }
}
