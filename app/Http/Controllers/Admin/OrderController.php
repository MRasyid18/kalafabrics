<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('user')->orderBy('created_at', 'desc')->paginate(10);
        return view('admin.orders.index', compact('orders'));
    }

    public function update(Request $request, Order $order)
    {
        $request->validate(['status' => 'required|string']);

        $oldStatus = $order->status;
        $newStatus = $request->status;

        // LOGIKA PENGURANGAN STOK:
        // Jika pesanan DITERIMA (diubah menjadi 'processing') dan sebelumnya masih 'pending'
        if ($newStatus == 'processing' && $oldStatus == 'pending') {
            $items = OrderItem::where('order_id', $order->id)->get();
            foreach ($items as $item) {
                $product = \App\Models\Product::find($item->product_id);
                if ($product) {
                    $product->decrement('stock', $item->quantity); // Potong stok!
                }
            }
        }

        $order->update(['status' => $newStatus]);
        return redirect()->route('admin.orders.index')->with('success', 'Status pesanan berhasil diperbarui!');
    }
}