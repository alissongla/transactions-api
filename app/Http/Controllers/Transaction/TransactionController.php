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

    /**
     * Handles the request to delete a transaction.
     *
     * @param int $transactionId
     * @return JsonResponse
     * If an error occurs during the deletion, a JSON response with a status code of 400 and an error message is returned.
     * @throws \Exception If the transaction cannot be deleted, an exception is thrown.
     */
    public function destroy($transactionId)
    {
        try {
            return $this->transactionService->deleteTransaction($transactionId);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        }
    }

    /**
     * Handles the request to restore a transaction.
     *
     * @param int $transactionId
     * @return JsonResponse
     * If an error occurs during the restoration, a JSON response with a status code of 400 and an error message is returned.
     * @throws \Exception If the transaction cannot be restored, an exception is thrown.
     */
    public function restore($transactionId)
    {
        try {
            return $this->transactionService->restoreTransaction($transactionId);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        }
    }
}
