<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'payer_user_id',
        'payee_user_id',
        'value',
    ];

    public function payer()
    {
        return $this->belongsTo(User::class, 'payer_user_id');
    }

    public function payee()
    {
        return $this->belongsTo(User::class, 'payee_user_id');
    }
}
