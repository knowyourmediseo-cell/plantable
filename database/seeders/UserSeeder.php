<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Create admin user
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@plantableeco.com',
            'password' => Hash::make('Admin@123'),
            'user_type' => 'admin',
            'status' => 'active',
            'email_verified_at' => now(),
        ]);

        // Create demo customer
        User::create([
            'name' => 'Demo Customer',
            'email' => 'customer@plantableeco.com',
            'password' => Hash::make('Customer@123'),
            'phone' => '+1234567890',
            'user_type' => 'customer',
            'status' => 'active',
            'email_verified_at' => now(),
        ]);
    }
}
