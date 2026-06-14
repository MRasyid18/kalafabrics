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
        Schema::create('leaderboards', function (Blueprint $table) {
            $table->id();
            $table->foreignId('b2b_profile_id')->constrained()->onDelete('cascade');
            $table->enum('leaderboard_type', ['waste_donation', 'purchases'])->default('waste_donation');
            $table->integer('rank');
            $table->decimal('total_contribution', 10, 2);
            $table->integer('points_earned')->default(0);
            $table->integer('transaction_count')->default(0);
            $table->timestamp('last_updated_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leaderboards');
    }
};
