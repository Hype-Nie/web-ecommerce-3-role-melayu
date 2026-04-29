<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $seller1 = User::where('email', 'aminah@CampusBy.my')->first()->id;
        $seller2 = User::where('email', 'tech@CampusBy.my')->first()->id;

        $products = [
            ['seller_id' => $seller2, 'category_id' => 1, 'name' => 'Jam Tangan Pintar Pro', 'description' => 'Jam tangan pintar dengan paparan AMOLED 1.5 inci, pemantauan kesihatan 24/7, kalis air IP68, dan hayat bateri sehingga 7 hari.', 'price' => 299.00, 'old_price' => 399.00, 'stock' => 24],
            ['seller_id' => $seller1, 'category_id' => 2, 'name' => 'Beg Galas Premium', 'description' => 'Beg galas kalis air dengan pelbagai poket, sesuai untuk kerja dan kembara. Bahan berkualiti tinggi dan tahan lama.', 'price' => 149.00, 'old_price' => 199.00, 'stock' => 15],
            ['seller_id' => $seller2, 'category_id' => 1, 'name' => 'Fon Telinga Wayarles', 'description' => 'Fon telinga Bluetooth 5.3 dengan pembatalan bunyi aktif, hayat bateri 30 jam, dan mikrofon terbina dalam.', 'price' => 89.00, 'old_price' => null, 'stock' => 50],
            ['seller_id' => $seller1, 'category_id' => 4, 'name' => 'Kasut Sukan Ringan', 'description' => 'Kasut sukan ringan dengan tapak getah berkualiti tinggi. Sesuai untuk berlari dan aktiviti sukan harian.', 'price' => 179.00, 'old_price' => 249.00, 'stock' => 3],
            ['seller_id' => $seller2, 'category_id' => 1, 'name' => 'Kamera Digital Mini', 'description' => 'Kamera digital kompak 48MP dengan zoom optik 5x, rakaman video 4K, dan WiFi terbina dalam.', 'price' => 459.00, 'old_price' => 599.00, 'stock' => 10],
            ['seller_id' => $seller1, 'category_id' => 5, 'name' => 'Set Penjagaan Kulit', 'description' => 'Set lengkap penjagaan kulit termasuk pencuci muka, toner, serum dan pelembap. Sesuai untuk semua jenis kulit.', 'price' => 129.00, 'old_price' => null, 'stock' => 0],
            ['seller_id' => $seller2, 'category_id' => 3, 'name' => 'Lampu Meja LED', 'description' => 'Lampu meja LED dengan 3 mod pencahayaan, boleh laras kecerahan, dan port USB untuk pengecasan.', 'price' => 69.00, 'old_price' => 89.00, 'stock' => 35],
            ['seller_id' => $seller1, 'category_id' => 4, 'name' => 'Botol Air Termos', 'description' => 'Botol air termos keluli tahan karat 500ml. Kekalkan suhu panas 12 jam dan sejuk 24 jam.', 'price' => 49.00, 'old_price' => null, 'stock' => 80],
        ];

        foreach ($products as $p) {
            $p['slug'] = Str::slug($p['name']);
            Product::create($p);
        }
    }
}
