<?php

namespace Database\Factories;

use App\Models\Team;
use Illuminate\Database\Eloquent\Factories\Factory;

class TeamFactory extends Factory
{
    /**
     * @var string $model
     */
    protected $model = Team::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
        ];
    }
}
