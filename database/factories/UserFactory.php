<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Account;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserFactory extends Factory
{
    /**
     * @var string $model
     */
    protected $model = User::class;

    public function definition(): array
    {
        $data = [
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'account_id' => Account::inRandomOrder()->first()->id,
            'email' => $this->faker->unique()->safeEmail,
            'email_verified_at' => $this->faker->optional()->date('Y-m-d H:i:s'),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',   // password
            'remember_token' => Str::random(10),
        ];

        return array_filter($data);
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }
}
