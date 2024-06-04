<?php

namespace Tests\Unit\Services\Transaction;

use App\Http\Clients\UtilToolsClient;
use App\Http\Repositories\Transaction\TransactionRepository;
use App\Http\Repositories\User\AccountRepository;
use App\Models\Account;
use App\Models\Transaction;
use App\Services\TransactionService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\JsonResponse;
use Tests\TestCase;

class TransactionServiceTest extends TestCase
{
    use RefreshDatabase;

    protected $transactionService;

    protected function setUp(): void
    {
        parent::setUp();
        $utilToolsClient = $this->createMock(UtilToolsClient::class);
        $utilToolsClient->method('getAuthorization')->willReturn(true);
        $this->transactionService = new TransactionService(
            app(AccountRepository::class),
            app(TransactionRepository::class),
            $utilToolsClient
        );
    }

    public function testShouldCreateTransaction()
    {
        $payer = Account::factory()->create(['balance' => 200, 'type' => 'PF']);
        $payee = Account::factory()->create();
        $transaction = $this->transactionService->createTransaction($payer->user_id, $payee->user_id, 100);
        $transaction = json_decode($transaction->getContent());
        $transaction = $transaction->transaction;
        $this->assertEquals($payer->user_id, $transaction->payer_user_id);
        $this->assertEquals($payee->user_id, $transaction->payee_user_id);
        $this->assertEquals(100, $transaction->value);
    }

    public function testShouldReturnsErrorWhenPayerIsPayee()
    {
        $payer = Account::factory()->create(['balance' => 200]);
        $response = $this->transactionService->createTransaction($payer->user_id, $payer->user_id, 100);

        $this->assertEquals(400, $response->status());
        $this->assertEquals('{"message":"You cannot transfer to yourself"}', $response->getContent());
    }

    public function testShouldReturnsErrorWhenInsufficientBalance()
    {
        $payer = Account::factory()->create(['balance' => 50, 'type' => 'PF']);
        $payee = Account::factory()->create();
        $response = $this->transactionService->createTransaction($payer->user_id, $payee->user_id, 100);

        $this->assertEquals(400, $response->status());
        $this->assertEquals('{"message":"Insufficient balance"}', $response->getContent());
    }

    public function testShouldReturnsErrorWhenUserNotFound()
    {
        $payer = Account::factory()->create(['balance' => 200, 'type' => 'PF']);
        $response = $this->transactionService->createTransaction($payer->user_id, 999, 100);

        $this->assertEquals(400, $response->status());
        $this->assertEquals('{"message":"User not found"}', $response->getContent());
    }

    public function testShouldReturnsErrorWhenShopkeeperMakeTransaction()
    {
        $payer = Account::factory()->create(['balance' => 200, 'type' => 'PJ']);
        $payee = Account::factory()->create();
        $response = $this->transactionService->createTransaction($payer->user_id, $payee->user_id, 100);

        $this->assertEquals(400, $response->status());
        $this->assertEquals('{"message":"Shopkeeper cannot make transactions"}', $response->getContent());
    }

    public function testShouldReturnsErrorWhenErrorOnAuthorization()
    {
        $payer = Account::factory()->create(['balance' => 200, 'type' => 'PF']);
        $payee = Account::factory()->create();
        $utilToolsClient = $this->createMock(UtilToolsClient::class);
        $utilToolsClient->method('getAuthorization')->willReturn(false);
        $transactionService = new TransactionService(
            app(AccountRepository::class),
            app(TransactionRepository::class),
            $utilToolsClient
        );
        $response = $transactionService->createTransaction($payer->user_id, $payee->user_id, 100);

        $this->assertEquals(400, $response->status());
        $this->assertEquals('{"message":"Error on authorization"}', $response->getContent());
    }

    public function testShouldDeleteTransactionSuccessfully()
    {
        $transaction = Transaction::factory()->create();
        $response = $this->transactionService->deleteTransaction($transaction->id);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testShouldDeleteTransactionWithNonExistentId()
    {
        $transactionId = 9999;
        $response = $this->transactionService->deleteTransaction($transactionId);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(400, $response->getStatusCode());
    }
}
