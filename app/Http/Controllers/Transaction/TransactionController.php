<?php

namespace App\Http\Controllers\Transaction;

use App\Http\Controllers\Controller;
use App\Http\Requests\Transactions\StoreTransactionRequest;
use App\Services\TransactionService;
use Illuminate\Http\JsonResponse;

class TransactionController extends Controller
{
    public function __construct(public readonly TransactionService $transactionService)
    {
    }

    /**
     * Handles the request to create a new transaction.
     *
     * @param StoreTransactionRequest $request
     * @return JsonResponse Returns a JSON response indicating the transaction was completed.
     */
    public function store(StoreTransactionRequest $request)
    {
        $this->transactionService->createTransaction($request->payer, $request->payee, $request->value);

        return response()->json(['message' => 'Transaction completed'], 200);
    }
}
