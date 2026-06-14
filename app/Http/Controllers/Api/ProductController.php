<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::where('active', true)->with('category');

        if ($request->has('category')) {
            $query->where('category_id', $request->category);
        }

        if ($request->has('search')) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->has('product_type')) {
            // BUG FIX: Gunakan whereIn agar produk berstatus 'both' tetap ikut terambil
            $query->whereIn('product_type', [$request->product_type, 'both']);
        }

        $products = $query->paginate(15);

        return ProductResource::collection($products);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'slug' => 'required|string|unique:products',
            'description' => 'required|string',
            'environmental_impact' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'sku' => 'required|string|unique:products',
            'image_path' => 'nullable|string',
            'points_reward' => 'nullable|integer|min:0', // FIX: Tambah nullable
            'product_type' => 'required|in:b2c,b2b,both', // FIX: Tambah required
            'bulk_discount_percentage' => 'nullable|numeric|min:0|max:100',
        ]);

        $product = Product::create($validated);

        return new ProductResource($product);
    }

    public function show(Product $product)
    {
        return new ProductResource($product->load('category'));
    }

    public function update(Request $request, Product $product)
    {
        // BUG FIX: Tambahkan 'sometimes' untuk request update parsial (PATCH)
        $validated = $request->validate([
            'category_id' => 'sometimes|exists:categories,id',
            'name' => 'sometimes|string|max:255',
            'slug' => 'sometimes|string|unique:products,slug,' . $product->id,
            'description' => 'sometimes|string',
            'environmental_impact' => 'nullable|string',
            'price' => 'sometimes|numeric|min:0',
            'stock' => 'sometimes|integer|min:0',
            'sku' => 'sometimes|string|unique:products,sku,' . $product->id,
            'image_path' => 'nullable|string',
            'points_reward' => 'nullable|integer|min:0',
            'product_type' => 'sometimes|in:b2c,b2b,both',
            'bulk_discount_percentage' => 'nullable|numeric|min:0|max:100',
            'active' => 'sometimes|boolean',
        ]);

        $product->update($validated);

        return new ProductResource($product);
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return response()->json(['message' => 'Product deleted successfully']);
    }
}