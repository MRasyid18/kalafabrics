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
        Schema::create('volunteer_tasks', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->enum('task_type', ['waste_sorting', 'education_campaign', 'event_support', 'content_creation'])->default('waste_sorting');
            $table->dateTime('scheduled_datetime');
            $table->string('location');
            $table->integer('required_volunteers');
            $table->integer('assigned_volunteers')->default(0);
            $table->string('task_leader_name');
            $table->string('task_leader_contact');
            $table->integer('hours_commitment');
            $table->integer('points_reward')->default(0);
            $table->enum('status', ['open', 'in_progress', 'completed', 'cancelled'])->default('open');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('volunteer_tasks');
    }
};
