<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with('user', 'items');

        if ($request->filled('from')) {
            $query->whereDate('created_at', '>=', $request->from);
        }
        if ($request->filled('to')) {
            $query->whereDate('created_at', '<=', $request->to);
        }
        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        $orders       = $query->latest()->get();
        $totalOrders  = $orders->count();
        $totalRevenue = $orders->where('payment_status', 'paid')->sum('total');
        $avgOrder     = $totalOrders > 0 ? $totalRevenue / $totalOrders : 0;

        return view('admin.reports', compact('orders', 'totalOrders', 'totalRevenue', 'avgOrder'));
    }

    public function export(Request $request)
    {
        $query = Order::with('user', 'items');

        if ($request->filled('from')) {
            $query->whereDate('created_at', '>=', $request->from);
        }
        if ($request->filled('to')) {
            $query->whereDate('created_at', '<=', $request->to);
        }
        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        $orders = $query->latest()->get();

        $response = new StreamedResponse(function () use ($orders) {
            $handle = fopen('php://output', 'w');

            // BOM for Excel UTF-8
            fprintf($handle, chr(0xEF) . chr(0xBB) . chr(0xBF));

            // Header
            fputcsv($handle, [
                'No. Pesanan', 'Pelanggan', 'E-mel', 'Produk',
                'Subtotal (RM)', 'Penghantaran (RM)', 'Jumlah (RM)',
                'Status', 'Pembayaran', 'Tarikh',
            ]);

            foreach ($orders as $o) {
                $productNames = $o->items->pluck('product_name')->implode(', ');
                fputcsv($handle, [
                    $o->order_number,
                    $o->user->name,
                    $o->user->email,
                    $productNames,
                    number_format($o->subtotal, 2),
                    number_format($o->shipping_cost, 2),
                    number_format($o->total, 2),
                    $o->statusLabel(),
                    $o->payment_status === 'paid' ? 'Dibayar' : 'Belum Dibayar',
                    $o->created_at->format('d/m/Y H:i'),
                ]);
            }

            fclose($handle);
        });

        $filename = 'laporan_transaksi_' . now()->format('Ymd_His') . '.csv';

        $response->headers->set('Content-Type', 'text/csv');
        $response->headers->set('Content-Disposition', 'attachment; filename="' . $filename . '"');

        return $response;
    }
}
