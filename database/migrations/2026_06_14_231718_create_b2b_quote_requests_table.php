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
        Schema::create('b2b_quote_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->string('company_name');
            $table->string('product_name');
            $table->integer('quantity');
            $table->text('customization_details')->nullable(); // Misal: "Taruh logo di dada kiri"
            $table->string('logo_path')->nullable(); // Upload file logo
            $table->enum('status', ['pending', 'reviewed', 'quoted', 'rejected'])->default('pending');
            $table->decimal('offered_price', 12, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('b2b_quote_requests');
    }
};
