<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\User::create([
           'first_name' => 'Super',
           'last_name' => 'Admin',
            'email' => 'admin@schaltwerk.com',
            'password' => bcrypt('12345678'),
            'user_type' => \App\Enums\UserType::SUPER_ADMIN,
            'email_verified_at' => now()
        ]);

        \App\User::create([
            'first_name' => 'Standard ',
            'last_name' => 'User',
            'email' => 'user@schaltwerk.com',
            'password' => bcrypt('12345678'),
            'user_type' => \App\Enums\UserType::USER,
            'email_verified_at' => now()
        ]);

        \App\User::create([
            'first_name' => 'Company',
            'last_name' => 'Admin',
            'email' => 'administrator@schaltwerk.com',
            'password' => bcrypt('12345678'),
            'user_type' => \App\Enums\UserType::COMPANY_ADMIN,
            'email_verified_at' => now()
        ]);

    }
}
