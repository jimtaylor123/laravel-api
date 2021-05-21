<?php

namespace Database\Factories;

use App\Models\AccountType;
use Illuminate\Database\Eloquent\Factories\Factory;

class AccountTypeFactory extends Factory
{
    /**
     * @var string $model
     */
    protected $model = AccountType::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->text(10),
        ];
    }
}
