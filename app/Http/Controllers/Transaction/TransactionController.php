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
        try {
            return $this->transactionService->createTransaction($request->payer, $request->payee, $request->value);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        }
    }

    public function destroy($id)
    {
        try {
            return $this->transactionService->deleteTransaction($id);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        }
    }

    public function restore($id)
    {
        try {
            return $this->transactionService->restoreTransaction($id);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        }
    }
}
