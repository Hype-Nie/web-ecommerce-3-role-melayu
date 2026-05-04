<?php

namespace Database\Seeders;

use App\Models\ShippingType;
use Illuminate\Database\Seeder;

class ShippingTypeSeeder extends Seeder
{
    public function run(): void
    {
        $types = [
            ['name' => 'Pos Laju', 'description' => 'Penghantaran ekspres 1-2 hari bekerja', 'price' => 8.00, 'estimated_days' => '1-2 hari', 'is_active' => true],
            ['name' => 'J&T Express', 'description' => 'Penghantaran standard 2-3 hari bekerja', 'price' => 6.50, 'estimated_days' => '2-3 hari', 'is_active' => true],
            ['name' => 'DHL eCommerce', 'description' => 'Penghantaran antarabangsa 5-7 hari bekerja', 'price' => 25.00, 'estimated_days' => '5-7 hari', 'is_active' => true],
            ['name' => 'Ninja Van', 'description' => 'Penghantaran ekonomi 3-5 hari bekerja', 'price' => 5.00, 'estimated_days' => '3-5 hari', 'is_active' => true],
            ['name' => 'GDex', 'description' => 'Penghantaran standard 2-4 hari bekerja', 'price' => 7.00, 'estimated_days' => '2-4 hari', 'is_active' => false],
        ];

        foreach ($types as $type) {
            ShippingType::create($type);
        }
    }
}
