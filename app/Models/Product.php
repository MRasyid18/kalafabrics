<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'description',
        'environmental_impact',
        'price',
        'stock',
        'sku',
        'image_path',
        'points_reward',
        'product_type',
        'bulk_discount_percentage',
        'active',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'bulk_discount_percentage' => 'decimal:2',
        'active' => 'boolean',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function b2bOrderItems(): HasMany
    {
        return $this->hasMany(B2bOrderItem::class);
    }
}
