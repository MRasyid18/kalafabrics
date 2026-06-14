<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class CheckoutController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'shipping_address' => 'required|string',
            'phone' => 'required|string',
            'items' => 'required|array',
            'total_amount' => 'required|numeric'
        ]);

        try {
            // FIX: Simpan hasil transaksi ke variabel $order
            $order = DB::transaction(function () use ($request) {
                $newOrder = Order::create([
                    'user_id' => auth()->id(),
                    'status' => 'pending', 
                    'shipping_address' => $request->shipping_address . ' | Telp: ' . $request->phone,
                    'payment_method' => 'WhatsApp Transfer',
                    'total_amount' => $request->total_amount,
                ]);

                foreach ($request->items as $item) {
                    // Cari produk berdasarkan nama
                    $product = Product::where('name', $item['name'])->first();
                    if ($product) {
                        OrderItem::create([
                            'order_id' => $newOrder->id,
                            'product_id' => $product->id,
                            'quantity' => $item['qty'],
                            'price' => $item['price'],
                        ]);
                    }
                }
                
                return $newOrder; // Mengembalikan objek order ke luar transaksi
            });

            // Sekarang variabel $order sudah terdefinisi dengan benar
            return response()->json([
                'success' => true, 
                'order_id' => str_pad($order->id, 5, '0', STR_PAD_LEFT)
            ]);

        } catch (\Exception $e) {
            // Log error ke file laravel.log agar Anda tahu penyebabnya
            \Log::error('Checkout Error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false, 
                'message' => 'Terjadi kesalahan sistem: ' . $e->getMessage()
            ], 500);
        }
    }

    public function history()
    {
        $orders = Order::where('user_id', auth()->id())->orderBy('created_at', 'desc')->get();
        return view('pages.orders', compact('orders'));
    }
}