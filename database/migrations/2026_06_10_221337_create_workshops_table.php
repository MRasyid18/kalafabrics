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
        Schema::create('workshops', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->text('learning_objectives')->nullable();
            $table->enum('category', ['environmental_education', 'textile_recycling', 'sustainability', 'crafts'])->default('environmental_education');
            $table->dateTime('start_datetime');
            $table->dateTime('end_datetime');
            $table->string('location');
            $table->integer('max_participants');
            $table->integer('current_participants')->default(0);
            $table->boolean('is_online')->default(false);
            $table->string('online_link')->nullable();
            $table->string('facilitator_name');
            $table->string('facilitator_email');
            $table->integer('points_reward')->default(0);
            $table->boolean('active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('workshops');
    }
};
