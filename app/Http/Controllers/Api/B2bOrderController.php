<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\B2bOrder;
use App\Models\B2bOrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class B2bOrderController extends Controller
{
    public function index(Request $request)
    {
        $orders = B2bOrder::where('user_id', $request->user()->id)
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
            'items.*.quantity' => 'required|integer|min:10', // B2B biasanya ada minimum order
            'shipping_address' => 'required|string',
            'payment_method' => 'required|string',
            'company_name' => 'required|string',
            'tax_number' => 'nullable|string', // NPWP
        ]);

        try {
            $order = DB::transaction(function () use ($request, $validated) {
                $user = $request->user();
                $totalAmount = 0;

                $order = B2bOrder::create([
                    'user_id' => $user->id,
                    'status' => 'pending_verification', // B2B biasanya butuh verifikasi admin
                    'shipping_address' => $validated['shipping_address'],
                    'payment_method' => $validated['payment_method'],
                    'company_name' => $validated['company_name'],
                    'tax_number' => $validated['tax_number'] ?? null,
                    'total_amount' => 0, 
                ]);

                foreach ($validated['items'] as $item) {
                    $product = Product::lockForUpdate()->find($item['product_id']);

                    if ($product->stock < $item['quantity']) {
                        throw ValidationException::withMessages(['items' => "Stok untuk {$product->name} tidak mencukupi."]);
                    }

                    $product->decrement('stock', $item['quantity']);

                    // Implementasi Bulk Discount (jika ada field bulk_discount_percentage di tabel produk)
                    $price = $product->price;
                    if ($product->bulk_discount_percentage > 0) {
                        $discount = $price * ($product->bulk_discount_percentage / 100);
                        $price -= $discount;
                    }

                    $subtotal = $price * $item['quantity'];
                    $totalAmount += $subtotal;

                    B2bOrderItem::create([
                        'b2b_order_id' => $order->id,
                        'product_id' => $product->id,
                        'quantity' => $item['quantity'],
                        'price' => $price, 
                    ]);
                }

                $order->update(['total_amount' => $totalAmount]);

                return $order->load('items.product');
            });

            return response()->json([
                'message' => 'Pesanan B2B berhasil dibuat dan menunggu verifikasi',
                'order' => $order
            ], 201);

        } catch (\Exception $e) {
            return response()->json(['message' => 'Gagal membuat pesanan', 'error' => $e->getMessage()], 500);
        }
    }

    public function show(Request $request, string $id)
    {
        $order = B2bOrder::with('items.product')->findOrFail($id);

        if ($request->user()->role !== 'admin' && $order->user_id !== $request->user()->id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        return response()->json($order);
    }

    public function submitQuoteRequest(Request $request)
    {
        $request->validate([
            'product_name' => 'required',
            'quantity' => 'required|integer|min:10', // Minimal order B2B
            'logo' => 'nullable|image|max:2048',
        ]);

        $logoPath = $request->hasFile('logo') ? $request->file('logo')->store('logos', 'public') : null;

        \App\Models\B2bQuoteRequest::create([
            'user_id' => Auth::id(),
            'company_name' => Auth::user()->b2bProfile->company_name,
            'product_name' => $request->product_name,
            'quantity' => $request->quantity,
            'customization_details' => $request->customization_details,
            'logo_path' => $logoPath,
            'status' => 'pending'
        ]);

        return redirect()->back()->with('success', 'Permintaan penawaran harga telah dikirim ke tim kami!');
    }
}