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
            $table->string('donation_number')->unique();
            $table->enum('status', ['pending_pickup', 'picked_up', 'received', 'verified', 'rejected'])->default('pending_pickup');
            $table->decimal('total_weight_kg', 10, 2);
            $table->integer('points_awarded')->default(0);
            $table->text('donation_address');
            $table->string('city');
            $table->string('postal_code');
            $table->string('contact_person_name');
            $table->string('contact_person_phone');
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
