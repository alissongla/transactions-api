<?php

use App\Http\Controllers\Transaction\TransactionController;
use Illuminate\Support\Facades\Route;

Route::post('/transaction', [TransactionController::class, 'store']);
