<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use HasFactory;

    protected $table = 'accounts';

    protected $fillable = [
        'user_id',
        'type',
        'account',
        'digit',
        'balance',
        'last_transaction',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
