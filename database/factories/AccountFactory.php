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
        // As accounts are created before users, 
        // the owner_id is nullable until an owner is assigned
        $user = User::inRandomOrder()->first();

        return [
            'name' => $this->faker->text(10),
            'owner_id' => $user? $user->id : null,
            'account_type_id' => AccountType::inRandomOrder()->first()->id
        ];
    }
}
