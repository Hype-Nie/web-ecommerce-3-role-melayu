<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function index(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $product = \App\Models\Product::with('seller')->findOrFail($request->product_id);
        $quantity = $request->quantity;
        $subtotal = $product->price * $quantity;
        $user = auth()->user();

        $addresses = $user->addresses()->orderByDesc('is_default')->get();

        return view('checkout', compact('product', 'quantity', 'subtotal', 'addresses'));
    }

    public function placeOrder(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'address_id' => 'required|exists:addresses,id',
            'payment_method' => 'required|string',
        ]);

        $user = auth()->user();
        $product = \App\Models\Product::with('seller')->findOrFail($request->product_id);
        $quantity = $request->quantity;
        $subtotal = $product->price * $quantity;
        $total = $subtotal;

        $order = null;

        DB::transaction(function () use ($user, $product, $quantity, $request, $subtotal, $total, &$order) {
            $order = Order::create([
                'order_number' => Order::generateOrderNumber(),
                'user_id' => $user->id,
                'address_id' => $request->address_id,
                'subtotal' => $subtotal,
                'total' => $total,
                'status' => 'sold',
                'payment_method' => $request->payment_method,
                'payment_status' => 'unpaid',
                'whatsapp_sent' => true,
            ]);

            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $product->id,
                'product_name' => $product->name,
                'product_price' => $product->price,
                'quantity' => $quantity,
                'subtotal' => $subtotal,
            ]);
        });

        // Build WhatsApp message
        $address = $order->address;
        $message = "[*Pesanan Baru dari CampusBuy*]\n\n";
        $message .= "*No. Pesanan:* {$order->order_number}\n";
        $message .= "*Pelanggan:* {$user->name}\n";
        $message .= "*Campus ID:* {$user->campus_id}\n";
        if ($address) {
            $message .= "*Alamat:* {$address->recipient_name}, {$address->phone}, {$address->address_line}, {$address->city}, {$address->state} {$address->postcode}\n";
        }
        $message .= "\n[*Item Pesanan*]\n";
        $message .= "- {$product->name} x{$quantity} : RM " . number_format($subtotal, 2) . "\n";
        $message .= "\n*Jumlah:* RM " . number_format($total, 2) . "\n";
        $message .= "*Kaedah Bayaran:* {$order->payment_method}\n";
        $message .= "\nTerima kasih kerana menggunakan CampusBuy!";

        // Get seller phone from product
        $sellerPhone = $product->seller->phone ?? '60123456789';
        // Normalize phone number for WhatsApp
        $sellerPhone = preg_replace('/[^0-9]/', '', $sellerPhone);
        if (str_starts_with($sellerPhone, '0')) {
            $sellerPhone = '60' . substr($sellerPhone, 1);
        }

        $waUrl = 'https://wa.me/' . $sellerPhone . '?text=' . urlencode($message);

        return redirect()->away($waUrl);
    }
}
