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
        Schema::create('b2b_profiles', function (Blueprint $table) {
            $table->id();
            
            // Relasi One-to-One ke tabel Users
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            
            // Informasi Legalitas Perusahaan
            $table->string('company_name');
            $table->string('company_registration_number')->unique()->nullable(); // NIB / SIUP
            $table->string('npwp', 50)->nullable(); // Khusus untuk penerbitan Faktur Pajak
            
            // Informasi Alamat & Kontak Perusahaan
            $table->text('company_address');
            $table->string('city');
            $table->string('province');
            $table->string('postal_code');
            $table->string('phone');
            
            // Informasi Penanggung Jawab (PIC - CSR/Purchasing)
            $table->string('contact_person_name');
            $table->string('contact_person_phone');
            $table->string('contact_person_email');
            
            // Deskripsi Bisnis & Statistik (Sustainability Impact)
            $table->text('business_description')->nullable();
            $table->decimal('total_waste_donated', 10, 2)->default(0);
            $table->integer('donation_count')->default(0);
            
            // Status Verifikasi Mitra B2B
            $table->boolean('verified')->default(false);
            $table->string('verification_document_path')->nullable(); // Upload dokumen legal/PO
            $table->enum('status', ['pending', 'verified', 'rejected'])->default('pending');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('b2b_profiles');
    }
};