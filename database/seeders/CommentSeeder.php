<?php

namespace Database\Seeders;

use App\Models\Task;
use App\Models\Comment;
use App\Models\Project;
use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    public function run(): void
    {
        $commentableType = [
           Project::class,
           Task::class,
        ];

        foreach($commentableType as $type){

            $models = $type::inRandomOrder()->limit(5)->get();

            foreach($models as $model){
                Comment::factory([
                    'commentable_id' => $model->id,
                    'commentable_type' => get_class($model),
                ])
                ->count(
                   rand(1,10)
                )->create();
            }
           
        }
    }
}
