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

    public function updateBalance($payer, $payee, $value)
    {
        try {
            $payer->balance -= $value;
            $payer->save();

            $payee->balance += $value;
            $payee->save();

            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function reverseBalance($payer, $payee, $value)
    {
        try {
            $payer->balance += $value;
            $payer->save();

            $payee->balance -= $value;
            $payee->save();

            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

}
