<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        $siti = User::where('email', 'siti@email.com')->first();
        $ahmad = User::where('email', 'ahmad@email.com')->first();
        $sitiAddr = $siti->addresses()->where('is_default', true)->first()->id;
        $ahmadAddr = $ahmad->addresses()->where('is_default', true)->first()->id;

        $products = Product::all();

        // Order 1 — Siti — Shipped
        $o1 = Order::create([
            'order_number' => 'KD1024', 'user_id' => $siti->id, 'address_id' => $sitiAddr,
            'shipping_type_id' => 1, 'subtotal' => 299.00, 'shipping_cost' => 8.00, 'total' => 307.00,
            'status' => 'shipped', 'payment_method' => 'FPX', 'payment_status' => 'paid',
            'tracking_number' => 'MY2026042812345', 'created_at' => '2026-04-28 10:30:00',
        ]);
        OrderItem::create(['order_id' => $o1->id, 'product_id' => $products[0]->id, 'product_name' => $products[0]->name, 'product_price' => 299.00, 'quantity' => 1, 'subtotal' => 299.00]);

        // Order 2 — Siti — Processing
        $o2 = Order::create([
            'order_number' => 'KD1020', 'user_id' => $siti->id, 'address_id' => $sitiAddr,
            'shipping_type_id' => 2, 'subtotal' => 179.00, 'shipping_cost' => 6.50, 'total' => 185.50,
            'status' => 'processing', 'payment_method' => 'FPX', 'payment_status' => 'paid',
            'created_at' => '2026-04-22 14:00:00',
        ]);
        OrderItem::create(['order_id' => $o2->id, 'product_id' => $products[3]->id, 'product_name' => $products[3]->name, 'product_price' => 179.00, 'quantity' => 1, 'subtotal' => 179.00]);

        // Order 3 — Siti — Completed
        $o3 = Order::create([
            'order_number' => 'KD1015', 'user_id' => $siti->id, 'address_id' => $sitiAddr,
            'shipping_type_id' => 1, 'subtotal' => 178.00, 'shipping_cost' => 8.00, 'total' => 186.00,
            'status' => 'completed', 'payment_method' => 'Kad Kredit', 'payment_status' => 'paid',
            'created_at' => '2026-04-15 09:00:00',
        ]);
        OrderItem::create(['order_id' => $o3->id, 'product_id' => $products[2]->id, 'product_name' => $products[2]->name, 'product_price' => 89.00, 'quantity' => 2, 'subtotal' => 178.00]);

        // Order 4 — Ahmad — Completed
        $o4 = Order::create([
            'order_number' => 'KD1010', 'user_id' => $ahmad->id, 'address_id' => $ahmadAddr,
            'shipping_type_id' => 4, 'subtotal' => 129.00, 'shipping_cost' => 5.00, 'total' => 134.00,
            'status' => 'completed', 'payment_method' => 'E-Wallet', 'payment_status' => 'paid',
            'created_at' => '2026-04-08 16:30:00',
        ]);
        OrderItem::create(['order_id' => $o4->id, 'product_id' => $products[5]->id, 'product_name' => $products[5]->name, 'product_price' => 129.00, 'quantity' => 1, 'subtotal' => 129.00]);

        // Order 5 — Ahmad — Cancelled
        $o5 = Order::create([
            'order_number' => 'KD1005', 'user_id' => $ahmad->id, 'address_id' => $ahmadAddr,
            'shipping_type_id' => 1, 'subtotal' => 149.00, 'shipping_cost' => 8.00, 'total' => 157.00,
            'status' => 'cancelled', 'payment_method' => 'FPX', 'payment_status' => 'refunded',
            'created_at' => '2026-04-01 11:00:00',
        ]);
        OrderItem::create(['order_id' => $o5->id, 'product_id' => $products[1]->id, 'product_name' => $products[1]->name, 'product_price' => 149.00, 'quantity' => 1, 'subtotal' => 149.00]);
    }
}
