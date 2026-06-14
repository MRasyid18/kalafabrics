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
        Schema::create('waste_donations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            // --- KOLOM INPUT FORMULIR B2B ---
            $table->string('waste_type');
            $table->decimal('weight', 8, 2)->default(0);
            $table->string('condition')->nullable();
            $table->enum('delivery_method', ['self_delivery', 'ranger_pickup'])->default('ranger_pickup');
            $table->string('photo_path')->nullable();
            $table->date('pickup_date')->nullable();
            $table->text('address')->nullable();
            $table->text('notes')->nullable();
            
            // Status Pipeline (gabungan skema lama dan baru)
            $table->enum('status', ['diajukan', 'kurasi', 'penjemputan', 'diterima', 'selesai', 'ditolak', 'pending_pickup', 'picked_up', 'verified', 'rejected'])->default('diajukan');

            // --- KOLOM ADVANCED TRACKING (Bawaan Lama) ---
            // Dibuat nullable agar form B2B yang belum mengisi ini tidak error
            $table->string('donation_number')->nullable()->unique(); 
            $table->decimal('total_weight_kg', 10, 2)->nullable();
            $table->integer('points_awarded')->default(0);
            $table->text('donation_address')->nullable();
            $table->string('city')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('contact_person_name')->nullable();
            $table->string('contact_person_phone')->nullable();
            $table->timestamp('scheduled_pickup_date')->nullable();
            $table->timestamp('picked_up_at')->nullable();
            $table->timestamp('received_at')->nullable();
            $table->timestamp('verified_at')->nullable();
            $table->text('verification_notes')->nullable();
            $table->string('admin_verified_by')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('waste_donations');
    }
};