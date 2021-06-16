<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Project;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    public function run(): void
    {
        // Seed 3 projects for half the users 
        $users = User::limit(config('app.factory.default_quantity')/2)->get();
        
        foreach($users as $user){
            Project::factory(3)->create(['owner_id' => $user->id]);
        }
         
    }
}
