<?php

namespace App\Http\Repositories\Transaction;

use App\Http\Repositories\BaseRepository;
use App\Models\Transaction;

class TransactionRepository extends BaseRepository
{
    public function __construct(Transaction $model)
    {
        parent::__construct($model);
    }

    public function createTransaction($payer, $payee, $value)
    {
        return $this->create([
            'payer_user_id' => $payer->user_id,
            'payee_user_id' => $payee->user_id,
            'value' => $value
        ]);
    }

    public function restoreTransaction($transactionId)
    {
        $deletedTransaction = $this->model->withTrashed()->find($transactionId);
        if ($deletedTransaction) {
            $deletedTransaction->restore();
            return $deletedTransaction;
        }

        return null;
    }

    public function deleteTransaction($transactionId)
    {
        $deletedTransaction = $this->model->find($transactionId);
        if ($deletedTransaction) {
            $deletedTransaction->delete();
            return $deletedTransaction;
        }

        return null;
    }

    public function getTransaction($transactionId)
    {
        return $this->model->with('payer', 'payee')->find($transactionId);
    }
}
