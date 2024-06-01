<?php

namespace Database\Factories;

use App\Models\Account;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends Factory<Account>
 */
class AccountFactory extends Factory
{

    public function definition(): array
    {
        $user = User::factory()->create();
        $isCpf = strlen($user->document) === 11;
        return [
            'user_id' => $user->id,
            'type' => $isCpf ? 'PF' : 'PJ',
            'account' => fake()->unique()->randomNumber(6),
            'digit' => fake()->unique()->randomNumber(2),
            'balance' => fake()->randomFloat(2, 0, 10000),
            'last_transaction' => null,
        ];
    }
}
