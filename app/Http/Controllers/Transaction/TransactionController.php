<?php

namespace App\Http\Controllers\Transaction;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Transaction;
use App\Http\Requests\Transactions\StoreTransactionRequest;
use App\Models\User;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function store(StoreTransactionRequest $request)
    {
        $payer = User::find($request->payer)->with('account')->first();
        $payee = User::find($request->payee);
        $value = $request->value;

        if($payer->account->type === 'PJ'){
            return response()->json(['message' => 'Shopkeeper cannot make transactions'], 400);
        }

        if ($payer->id === $payee->id) {
            return response()->json(['message' => 'You cannot transfer to yourself'], 400);
        }

        if ($payer->balance < $value) {
            return response()->json(['message' => 'Insufficient balance'], 400);
        }

        $payer->balance -= $value;
        $payee->balance += $value;

        $payer->save();
        $payee->save();

        $transaction = new \App\Models\Transaction();
        $transaction->payer_user_id = $payer->id;
        $transaction->payee_user_id = $payee->id;
        $transaction->value = $value;
        $transaction->save();

        return response()->json(['message' => 'Transaction completed'], 200);
    }
}
