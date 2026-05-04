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
            'name'      => 'Admin Utama',
            'campus_id' => 'ADM001',
            'email'     => 'admin@campusbuy.my',
            'password'  => Hash::make('password'),
            'role'      => 'admin',
            'phone'     => '03-12345678',
            'is_active' => true,
            'is_seller' => false,
            'is_customer' => false,
        ]);

        // Sellers
        User::create([
            'name'      => 'Aminah binti Yusof',
            'campus_id' => '2024010001',
            'email'     => 'aminah@campusbuy.my',
            'password'  => Hash::make('password'),
            'role'      => 'seller',
            'phone'     => '012-3456789',
            'shop_name' => 'Kedai Aminah',
            'is_active' => true,
            'is_seller' => true,
            'is_customer' => true,
        ]);

        User::create([
            'name'      => 'Razak bin Omar',
            'campus_id' => '2024010002',
            'email'     => 'tech@campusbuy.my',
            'password'  => Hash::make('password'),
            'role'      => 'seller',
            'phone'     => '013-9876543',
            'shop_name' => 'Tech Store MY',
            'is_active' => true,
            'is_seller' => true,
            'is_customer' => true,
        ]);

        // Customers
        User::create([
            'name'      => 'Siti Nurhaliza',
            'campus_id' => '2024020001',
            'email'     => 'siti@email.com',
            'password'  => Hash::make('password'),
            'role'      => 'customer',
            'phone'     => '012-3456789',
            'is_active' => true,
            'is_seller' => false,
            'is_customer' => true,
        ]);

        User::create([
            'name'      => 'Ahmad Faizal',
            'campus_id' => '2024020002',
            'email'     => 'ahmad@email.com',
            'password'  => Hash::make('password'),
            'role'      => 'customer',
            'phone'     => '013-9876543',
            'is_active' => true,
            'is_seller' => false,
            'is_customer' => true,
        ]);

        User::create([
            'name'      => 'Nurul Ain',
            'campus_id' => '2024020003',
            'email'     => 'nurul@email.com',
            'password'  => Hash::make('password'),
            'role'      => 'customer',
            'phone'     => '011-1234567',
            'is_active' => true,
            'is_seller' => false,
            'is_customer' => true,
        ]);
    }
}
