<?php

namespace Database\Factories;

use App\Models\Task;
use App\Models\User;
use App\Models\Comment;
use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;

class CommentFactory extends Factory
{
    /**
     * @var string $model
     */
    protected $model = Comment::class;

    public function definition(): array
    {
        $commentableType = $this->faker->randomElement(
                                [
                                    Project::class, 
                                    Task::class,
                                ]
                            )::inRandomOrder()
                            ->first();

        return [
            'text' => $this->faker->text(10),
            'author_id' => User::inRandomOrder()->first()->id,
            'commentable_id' => $commentableType->id,
            'commentable_type' => get_class($commentableType),
        ];
    }
}
