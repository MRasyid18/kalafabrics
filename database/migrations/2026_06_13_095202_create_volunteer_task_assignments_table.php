<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('volunteer_task_assignments', function (Blueprint $table) {
            $table->id();
            // Menghubungkan dengan tabel users (Ranger)
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            // Menghubungkan dengan tabel volunteer_tasks (Misi)
            $table->foreignId('volunteer_task_id')->constrained('volunteer_tasks')->onDelete('cascade');
            
            // Status pengerjaan: accepted (diterima), completed (selesai)
            $table->string('status')->default('accepted'); 
            
            // Perekaman jam terbang
            $table->decimal('actual_hours', 5, 1)->default(0);
            $table->timestamp('completed_at')->nullable();
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('volunteer_task_assignments');
    }
};