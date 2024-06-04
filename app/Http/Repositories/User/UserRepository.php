<?php

namespace App\Http\Repositories\User;

use App\Http\Repositories\BaseRepository;
use App\Models\User;

class UserRepository extends BaseRepository
{
    public function __construct(User $model)
    {
        parent::__construct($model);
    }

    public function findByEmail($email)
    {
        return $this->model->where('email', $email)->first();
    }

    public function findByDocument($document)
    {
        return $this->model->where('document', $document)->first();
    }

    public function findByAccount($account, $digit)
    {
        return $this->model->whereHas('account', function ($query) use ($account, $digit) {
            $query->where('account', $account)->where('digit', $digit);
        })->first();
    }

    public function findUserWithAccount($userId)
    {
        return $this->model->with('account')->find($userId);
    }
}
