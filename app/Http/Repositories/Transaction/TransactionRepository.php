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
            'payer_user_id' => $payer->id,
            'payee_user_id' => $payee->id,
            'value' => $value
        ]);
    }

    public function restoreTransaction($id)
    {
        $deletedTransaction = $this->model->withTrashed()->find($id);
        if ($deletedTransaction) {
            $deletedTransaction->restore();
            return $deletedTransaction;
        }

        return null;
    }
}
