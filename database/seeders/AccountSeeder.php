<?php

namespace Database\Seeders;

use App\Models\Account;
use App\Models\User;
use Illuminate\Database\Seeder;

class AccountSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::limit(5)->get();
        
        foreach($users as $user){
            Account::factory(3)->create(['owner_id' => $user->id]);
        }
         
    }
}
