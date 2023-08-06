<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Vendor;
use Illuminate\Database\Seeder;

class AdminProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::where('email', 'admin@test.com')->first();

        $vendor = new Vendor();
        $vendor->user_id = $user->id;
        $vendor->banner = 'uploads/123.jpg';
        $vendor->phone = '123123123';
        $vendor->email = 'vendor@gmail.com';
        $vendor->address = 'USA';
        $vendor->description = 'shop description';
        $vendor->save();
    }
}
