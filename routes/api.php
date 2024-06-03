<?php

use App\Http\Controllers\Transaction\TransactionController;
use Illuminate\Support\Facades\Route;

Route::post('/transaction', [TransactionController::class, 'store']);
Route::delete('/transaction/{transactionId}', [TransactionController::class, 'destroy']);
Route::post('/transaction/restore/{transactionId}', [TransactionController::class, 'restore']);
