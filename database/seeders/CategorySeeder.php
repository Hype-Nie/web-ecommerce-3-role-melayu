<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Elektronik', 'description' => 'Gajet, komputer, telefon pintar dan aksesori elektronik', 'icon' => 'computer-desktop'],
            ['name' => 'Fesyen', 'description' => 'Pakaian, kasut, beg dan aksesori fesyen', 'icon' => 'tag'],
            ['name' => 'Rumah & Taman', 'description' => 'Perabot, hiasan rumah dan peralatan taman', 'icon' => 'home'],
            ['name' => 'Sukan', 'description' => 'Peralatan sukan, pakaian sukan dan aksesori kecergasan', 'icon' => 'bolt'],
            ['name' => 'Kesihatan', 'description' => 'Produk kesihatan, kecantikan dan penjagaan diri', 'icon' => 'heart'],
            ['name' => 'Mainan & Hobi', 'description' => 'Mainan kanak-kanak, permainan dan hobi', 'icon' => 'face-smile'],
            ['name' => 'Buku', 'description' => 'Buku fiksyen, bukan fiksyen dan bahan bacaan', 'icon' => 'book-open'],
        ];

        foreach ($categories as $cat) {
            Category::create($cat);
        }
    }
}
