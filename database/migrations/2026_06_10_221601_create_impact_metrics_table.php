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
        Schema::create('impact_metrics', function (Blueprint $table) {
            $table->id();
            $table->decimal('total_waste_collected_kg', 15, 2)->default(0);
            $table->decimal('total_carbon_saved_kg', 15, 2)->default(0);
            $table->decimal('water_saved_liters', 15, 2)->default(0);
            $table->integer('total_products_sold')->default(0);
            $table->integer('total_users')->default(0);
            $table->integer('total_b2b_partners')->default(0);
            $table->integer('active_volunteers')->default(0);
            $table->integer('total_workshops_completed')->default(0);
            $table->integer('total_workshop_participants')->default(0);
            $table->decimal('total_donation_value', 15, 2)->default(0);
            $table->timestamp('last_updated_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('impact_metrics');
    }
};
