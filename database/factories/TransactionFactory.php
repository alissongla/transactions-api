<?php

namespace Database\Factories;

use App\Models\Account;
use App\Models\Transaction;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Transaction>
 */
class TransactionFactory extends Factory
{
    public function definition(): array
    {
        $payer = Account::factory()->create();
        $payee = Account::factory()->create();

        return [
            'payer_user_id' => $payer->user_id,
            'payee_user_id' => $payee->user_id,
            'value' => $this->faker->randomNumber(2),
        ];
    }
}
