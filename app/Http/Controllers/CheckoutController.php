<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


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
            $order = DB::transaction(function () use ($request) {
                $orderNumber = 'ORD-' . strtoupper(uniqid());   
                $newOrder = Order::create([
                    'user_id'          => Auth::id(),
                    'order_number'     => 'ORD-' . strtoupper(uniqid()), // Wajib ada
                    'status'           => 'pending', 
                    'total_amount'     => $request->total_amount,
                    'shipping_address' => $request->shipping_address,
                    'recipient_name'   => Auth::user()->name,
                    'recipient_phone'  => $request->phone,
                    'city'             => 'Samarinda', 
                    'postal_code'      => '75111',
                ]);

                foreach ($request->items as $item) {
                    $product = Product::where('name', $item['name'])->first();
                    if ($product) {
                        OrderItem::create([
                            'order_id'   => $newOrder->id,
                            'product_id' => $product->id,
                            'quantity'   => $item['qty'],
                            'price'      => $item['price'],
                        ]);
                    }
                }
                
                return $newOrder;
            });

            return response()->json([
                'success'  => true, 
                'order_id' => $order->order_number // Kirim order_number ke frontend
            ]);

        } catch (\Exception $e) {
            \Log::error("Checkout Error: " . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Checkout gagal: ' . $e->getMessage()
            ], 500);        
        }
    }
}