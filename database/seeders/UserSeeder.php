<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'name' => 'Admin User',
                'username' => 'adminuser',
                'email' => 'admin@test.com',
                'role' => 'admin',
                'status' => 'active',
                'password' => bcrypt('password'),
            ],
            [
                'name' => 'Vendor User',
                'username' => 'vendoruser',
                'email' => 'vendor@test.com',
                'role' => 'vendor',
                'status' => 'active',
                'password' => bcrypt('password'),
            ],
            [
                'name' => 'User',
                'username' => 'user',
                'email' => 'user@test.com',
                'role' => 'user',
                'status' => 'active',
                'password' => bcrypt('password'),
            ]
        ]);
    }
}
