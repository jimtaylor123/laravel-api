<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PassportSeeder extends Seeder
{
    public function run(): void
    {
        # Insert default data into oauth clients table, 
        # so that we don't have to run php artsian passport:install 
        # and record the output in our .env file and postman env values
        # each time we do a fresh migration 

        DB::insert(
            "INSERT INTO `oauth_clients` 
            (`id`, `user_id`, `name`, `secret`, `provider`, `redirect`, 
            `personal_access_client`, `password_client`, `revoked`, `created_at`, 
            `updated_at`) 
            VALUES

            ('9379c079-25cc-42a9-adfa-159628fb9b2d', NULL, 
            'Laravel API Personal Access Client', 
            '$2y$10\$VRpnl/9V2aDMFEY.AdXbX.dGt.OYQ3Niz3D1OFt9yd9izHKINHT3K', # Secret is jYN9HZSeG1ClEbTMjVEFQpeBbSuzrcC8eFhtQde5
            NULL, 'http://localhost', '1', '0', '0', 
            '2021-05-20 11:48:14', '2021-05-20 11:48:14'),

            ('9379c079-5294-4160-ae2f-09a4daf33d6c', NULL, 
            'Laravel API Password Grant Client', 
            '$2y$10\$aSbXgSs6cAn/eXu1A0mcGuzcGccj.M/l7RmNeJeilY8xWV8YSSKpO', # Secret is RKR37tLyaONBNIj5R65tXSxdX8PCybC8gVjHPnsD
            'users', 'http://localhost', '0', '1', '0', '2021-05-20 11:48:15', 
            '2021-05-20 11:48:15');");
    }
}
