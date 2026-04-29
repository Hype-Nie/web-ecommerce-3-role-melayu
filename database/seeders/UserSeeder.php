<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        User::create([
            'name' => 'Admin Utama',
            'email' => 'admin@CampusBy.my',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'phone' => '03-12345678',
            'is_active' => true,
        ]);

        // Sellers
        User::create([
            'name' => 'Aminah binti Yusof',
            'email' => 'aminah@CampusBy.my',
            'password' => Hash::make('password'),
            'role' => 'seller',
            'phone' => '012-3456789',
            'shop_name' => 'Kedai Aminah',
            'is_active' => true,
        ]);

        User::create([
            'name' => 'Razak bin Omar',
            'email' => 'tech@CampusBy.my',
            'password' => Hash::make('password'),
            'role' => 'seller',
            'phone' => '013-9876543',
            'shop_name' => 'Tech Store MY',
            'is_active' => true,
        ]);

        // Customers
        User::create([
            'name' => 'Siti Nurhaliza',
            'email' => 'siti@email.com',
            'password' => Hash::make('password'),
            'role' => 'customer',
            'phone' => '012-3456789',
            'is_active' => true,
        ]);

        User::create([
            'name' => 'Ahmad Faizal',
            'email' => 'ahmad@email.com',
            'password' => Hash::make('password'),
            'role' => 'customer',
            'phone' => '013-9876543',
            'is_active' => true,
        ]);

        User::create([
            'name' => 'Nurul Ain',
            'email' => 'nurul@email.com',
            'password' => Hash::make('password'),
            'role' => 'customer',
            'phone' => '011-1234567',
            'is_active' => true,
        ]);
    }
}
