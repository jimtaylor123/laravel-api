<?php

namespace Database\Seeders;

use App\Models\AccountType;
use Illuminate\Database\Seeder;

class AccountTypeSeeder extends Seeder
{
    public function run(): void
    {
        $types = [
            'Sole Trader',
            'Limited Company',
            'Limited Liability Partnership',
            'Public Limited Company (PLC)',
            'Charity',
        ];

        foreach($types as $type){
            AccountType::factory(['name' => $type])->create();
        }
    }
}
