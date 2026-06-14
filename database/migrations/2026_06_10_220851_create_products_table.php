<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description');
            $table->text('environmental_impact')->nullable();
            $table->decimal('price', 10, 2);
            $table->integer('stock');
            $table->string('sku')->unique();
            $table->string('image_path')->nullable();
            $table->integer('points_reward')->default(0);
            $table->enum('product_type', ['b2c', 'b2b', 'both'])->default('b2c');
            $table->decimal('bulk_discount_percentage', 5, 2)->nullable();
            $table->boolean('active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
