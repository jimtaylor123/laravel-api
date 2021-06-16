<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Account;
use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProjectFactory extends Factory
{
    /**
     * @var string $model
     */
    protected $model = Project::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->text(10),
            'owner_id' => User::inRandomOrder()->first()->id,
            'account_id' => Account::inRandomOrder()->first()->id
        ];
    }
}
