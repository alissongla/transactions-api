<?php

namespace App\Http\Repositories\User;

use App\Http\Repositories\BaseRepository;
use App\Models\Account;
use App\Models\User;

class AccountRepository extends BaseRepository
{
    public function __construct(Account $model)
    {
        parent::__construct($model);
    }

    /**
     * Updates the balance of the payer and payee after a transaction.
     *
     * @param  User  $payer
     * @param  User  $payee
     * @param  float  $value
     * @return bool Returns true if the balance update was successful, false otherwise.
     *
     * @throws \Exception If there was an error during the update process.
     */
    public function updateBalance($payer, $payee, $value): bool
    {
        try {
            $payer->balance -= $value;
            $payer->last_transaction = now();
            $payer->save();

            $payee->balance += $value;
            $payee->save();

            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Reverses a transaction by updating the balance of the payer and payee.
     *
     * @param  User  $payer
     * @param  User  $payee
     * @param  float  $value
     * @return bool Returns true if the balance update was successful, false otherwise.
     *
     * @throws \Exception If there was an error during the update process.
     */
    public function reverseBalance($payer, $payee, $value)
    {
        try {
            $payer->balance += $value;
            $payer->last_transaction = now();
            $payer->save();

            $payee->balance -= $value;
            $payee->save();

            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
}
