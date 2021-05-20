<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Create one consistent user for dev purposes
        User::factory()->create([
            'email' => config('app.test_user.email'),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // 'password'
            'first_name' => config('app.test_user.first_name'),
            'last_name' => config('app.test_user.last_name'),
        ]);

        // Create several users for each role
        User::factory(100)->create();
    }
}
