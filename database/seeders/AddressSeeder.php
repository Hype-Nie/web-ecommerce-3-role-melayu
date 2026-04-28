<?php

namespace Database\Seeders;

use App\Models\Address;
use App\Models\User;
use Illuminate\Database\Seeder;

class AddressSeeder extends Seeder
{
    public function run(): void
    {
        $siti = User::where('email', 'siti@email.com')->first()->id;
        $ahmad = User::where('email', 'ahmad@email.com')->first()->id;

        Address::create([
            'user_id' => $siti, 'label' => 'Rumah', 'recipient_name' => 'Siti Nurhaliza',
            'phone' => '012-3456789', 'full_address' => 'No. 12, Jalan Bunga Raya, Taman Maju',
            'city' => 'Kuala Lumpur', 'postcode' => '50000', 'state' => 'Kuala Lumpur', 'is_default' => true,
        ]);
        Address::create([
            'user_id' => $siti, 'label' => 'Pejabat', 'recipient_name' => 'Siti Nurhaliza',
            'phone' => '012-3456789', 'full_address' => 'Aras 5, Menara ABC, Jalan Sultan Ismail',
            'city' => 'Kuala Lumpur', 'postcode' => '50250', 'state' => 'Kuala Lumpur', 'is_default' => false,
        ]);
        Address::create([
            'user_id' => $siti, 'label' => 'Kampung', 'recipient_name' => 'Siti Nurhaliza',
            'phone' => '019-9876543', 'full_address' => 'No. 45, Kampung Baru',
            'city' => 'Kota Bharu', 'postcode' => '15000', 'state' => 'Kelantan', 'is_default' => false,
        ]);
        Address::create([
            'user_id' => $ahmad, 'label' => 'Rumah', 'recipient_name' => 'Ahmad Faizal',
            'phone' => '013-9876543', 'full_address' => 'No. 88, Jalan Mawar, Taman Indah',
            'city' => 'Johor Bahru', 'postcode' => '80000', 'state' => 'Johor', 'is_default' => true,
        ]);
    }
}
