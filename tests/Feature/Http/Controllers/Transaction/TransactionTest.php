<?php

namespace Tests\Feature;

use App\Http\Clients\UtilToolsClient;
use App\Models\Account;
use App\Models\Transaction;
use App\Services\TransactionService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;
use Tests\TestCase;

class StoreTransactionTest extends TestCase
{
    use RefreshDatabase;

    public function testShouldStoreTransactionSuccess()
    {
        $payer = Account::factory()->create(['balance' => 200, 'type' => 'PF']);
        $payee = Account::factory()->create();
        $utilToolsClient = $this->createMock(UtilToolsClient::class);
        $utilToolsClient->method('getAuthorization')->willReturn(true);

        $this->app->instance(UtilToolsClient::class, $utilToolsClient);

        $requestData = [
            'payer' => $payer->user_id,
            'payee' => $payee->user_id,
            'value' => 100.00,
        ];

        $response = $this->postJson('/api/transaction', $requestData);

        $response->assertStatus(200)
            ->assertJsonStructure(['transaction']);
    }

    public function testSholdStoreTransactionAuthorizationFailure()
    {
        $payer = Account::factory()->create(['balance' => 200, 'type' => 'PF']);
        $payee = Account::factory()->create();
        $utilToolsClient = $this->createMock(UtilToolsClient::class);
        $utilToolsClient->method('getAuthorization')->willReturn(false);

        $this->app->instance(UtilToolsClient::class, $utilToolsClient);

        $requestData = [
            'payer' => $payer->user_id,
            'payee' => $payee->user_id,
            'value' => 100.00,
        ];

        $response = $this->postJson('/api/transaction', $requestData);

        $response->assertStatus(400)
            ->assertJson(['message' => 'Error on authorization']);
    }

    public function testShouldStoreTransactionFailure()
    {
        $transactionServiceMock = Mockery::mock(TransactionService::class);
        $transactionServiceMock->shouldReceive('createTransaction')
            ->andThrow(new \Exception('Transaction failed'));

        $this->app->instance(TransactionService::class, $transactionServiceMock);

        $requestData = [
            'payer' => 1,
            'payee' => 2,
            'value' => 100.00,
        ];

        $response = $this->postJson('/api/transaction', $requestData);

        $response->assertStatus(400)
            ->assertJson(['payer' => ['The selected payer is invalid.']]);
    }

    public function testShouldDeleteTransactionSuccess()
    {
        $transaction = Transaction::factory()->create();
        $response = $this->deleteJson("/api/transaction/{$transaction->id}");

        $response->assertStatus(200)
            ->assertJson(['message' => 'Transaction deleted']);
    }

    public function testShouldDeleteTransactionFailure()
    {
        $transactionServiceMock = Mockery::mock(TransactionService::class);
        $transactionServiceMock->shouldReceive('deleteTransaction')
            ->andThrow(new \Exception('Transaction failed'));

        $this->app->instance(TransactionService::class, $transactionServiceMock);

        $response = $this->deleteJson('/api/transaction/1');

        $response->assertStatus(400)
            ->assertJson(['message' => 'Transaction failed']);
    }

    public function testShouldRestoreTransactionSuccess()
    {
        $transaction = Transaction::factory()->create();
        $response = $this->postJson("/api/transaction/restore/{$transaction->id}");

        $response->assertStatus(200)
            ->assertJson(['message' => 'Transaction restored']);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}
