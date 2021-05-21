<?php

namespace Database\Factories;

use App\Models\Task;
use App\Models\User;
use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;

class TaskFactory extends Factory
{
    /**
     * @var string $model
     */
    protected $model = Task::class;

    public function definition(): array
    {
        return [
            'title' => $this->faker->text(10),
            'description' => $this->faker->text(100),
            'project_id' => Project::inRandomOrder()->first()->id,
            'owner_id' => User::inRandomOrder()->first()->id,
        ];
    }
}
