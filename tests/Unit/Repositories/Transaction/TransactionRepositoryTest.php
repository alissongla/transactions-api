<?php

namespace Tests\Unit\Repositories\Transaction;

use App\Http\Repositories\Transaction\TransactionRepository;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TransactionRepositoryTest extends TestCase
{
    use RefreshDatabase;

    protected TransactionRepository $transactionRepository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->transactionRepository = new TransactionRepository(new Transaction);
    }

    public function testCreateTransactionCreatesTransaction()
    {
        $payer = User::factory()->create();
        $payee = User::factory()->create();
        $transaction = $this->transactionRepository->createTransaction($payer, $payee, 100);
        $this->assertEquals($payer->id, $transaction->payer_user_id);
        $this->assertEquals($payee->id, $transaction->payee_user_id);
        $this->assertEquals(100, $transaction->value);
    }

    public function testRestoreTransactionRestoresTransaction()
    {
        $transaction = Transaction::factory()->create();
        $transaction->delete();
        $this->assertNotNull($transaction->deleted_at);
        $this->transactionRepository->restoreTransaction($transaction->id);
        $restoredTransaction = Transaction::find($transaction->id);
        $this->assertNull($restoredTransaction->deleted_at);
    }

    public function testRestoreTransactionReturnsNullWhenTransactionDoesNotExist()
    {
        $restoredTransaction = $this->transactionRepository->restoreTransaction(999);
        $this->assertNull($restoredTransaction);
    }
}
