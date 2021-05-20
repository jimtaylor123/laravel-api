<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\UserSeeder;
use Illuminate\Support\Facades\App;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        if(App::environment('local')){
            $this->call([
                UserSeeder::class,
                PassportSeeder::class
            ]);
        }
        
    }
}
