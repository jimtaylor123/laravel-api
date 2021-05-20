<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Project;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::limit(10)->get();
        
        foreach($users as $user){
            Project::factory(3)->create(['owner_id' => $user->id]);
        }
         
    }
}
