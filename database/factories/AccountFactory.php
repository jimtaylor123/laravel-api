<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Account;
use App\Models\AccountType;
use Illuminate\Database\Eloquent\Factories\Factory;

class AccountFactory extends Factory
{
    /**
     * @var string $model
     */
    protected $model = Account::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->text(10),
            'owner_id' => User::inRandomOrder()->first()->id,
            'account_type_id' => AccountType::inRandomOrder()->first()->id
        ];
    }
}
