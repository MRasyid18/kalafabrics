<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\UserPoint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        // Menampilkan daftar pesanan milik user yang sedang login
        $orders = Order::where('user_id', $request->user()->id)
            ->with('items.product')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return response()->json($orders);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'shipping_address' => 'required|string',
            'payment_method' => 'required|string',
            'use_points' => 'nullable|integer|min:0', // Jumlah poin yang ingin ditukarkan
        ]);

        try {
            $order = DB::transaction(function () use ($request, $validated) {
                $user = $request->user();
                $totalAmount = 0;
                $totalPointsReward = 0;
                $pointsToUse = $validated['use_points'] ?? 0;

                // Cek poin user jika ingin menggunakan poin
                if ($pointsToUse > 0) {
                    $userPoint = UserPoint::where('user_id', $user->id)->first();
                    if (!$userPoint || $userPoint->available_points < $pointsToUse) {
                        throw ValidationException::withMessages(['use_points' => 'Poin tidak mencukupi.']);
                    }
                }

                // Buat draft Order
                $order = Order::create([
                    'user_id' => $user->id,
                    'status' => 'pending',
                    'shipping_address' => $validated['shipping_address'],
                    'payment_method' => $validated['payment_method'],
                    'total_amount' => 0, // Akan diupdate
                    'discount_amount' => $pointsToUse, // Asumsi 1 poin = Rp1 (sesuaikan dengan logic bisnis Anda)
                ]);

                // Proses setiap item
                foreach ($validated['items'] as $item) {
                    $product = Product::lockForUpdate()->find($item['product_id']); // Lock baris produk agar tidak terjadi race condition stok

                    if ($product->stock < $item['quantity']) {
                        throw ValidationException::withMessages(['items' => "Stok untuk {$product->name} tidak mencukupi."]);
                    }

                    // Kurangi stok
                    $product->decrement('stock', $item['quantity']);

                    $subtotal = $product->price * $item['quantity'];
                    $totalAmount += $subtotal;
                    $totalPointsReward += ($product->points_reward * $item['quantity']);

                    // Buat Order Item
                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $product->id,
                        'quantity' => $item['quantity'],
                        'price' => $product->price, // Simpan harga saat ini (snapshot)
                    ]);
                }

                // Update total order setelah dikurangi poin
                $finalAmount = max(0, $totalAmount - $pointsToUse);
                $order->update(['total_amount' => $finalAmount]);

                // Update poin user (Kurangi yang dipakai, tambah yang didapat)
                $userPoint = UserPoint::firstOrCreate(['user_id' => $user->id]);
                
                if ($pointsToUse > 0) {
                    $userPoint->available_points -= $pointsToUse;
                    $userPoint->redeemed_points += $pointsToUse;
                }
                
                // Poin reward biasanya ditambahkan saat status order 'completed', 
                // tapi jika logic Anda menambahkannya di awal, bisa diletakkan di sini:
                // $userPoint->total_points += $totalPointsReward;
                // $userPoint->available_points += $totalPointsReward;
                $userPoint->save();

                return $order->load('items.product');
            });

            return response()->json([
                'message' => 'Pesanan berhasil dibuat',
                'order' => $order
            ], 201);

        } catch (\Exception $e) {
            return response()->json(['message' => 'Gagal membuat pesanan', 'error' => $e->getMessage()], 500);
        }
    }

    public function show(Request $request, string $id)
    {
        $order = Order::with('items.product')->findOrFail($id);

        // Pastikan user hanya bisa melihat ordernya sendiri, kecuali admin
        if ($request->user()->role !== 'admin' && $order->user_id !== $request->user()->id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        return response()->json($order);
    }
    
    public function invoice(Request $request, Order $order)
    {
        if ($request->user()->role !== 'admin' && $order->user_id !== $request->user()->id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
        
        return response()->json([
            'invoice_number' => 'INV-' . str_pad($order->id, 6, '0', STR_PAD_LEFT),
            'date' => $order->created_at,
            'order' => $order->load('items.product')
        ]);
    }
}