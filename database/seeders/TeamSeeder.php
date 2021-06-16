<?php

namespace Database\Seeders;

use App\Models\Team;
use Illuminate\Database\Seeder;

class TeamSeeder extends Seeder
{
    public function run(): void
    {
        Team::factory(
            config('app.factory.default_quantity')/2
        )->hasUsers(5)
        ->create();
    }
}
