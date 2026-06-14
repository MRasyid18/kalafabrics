@extends('layouts.app')
@section('title', 'Program Ranger')

@section('content')
<section style="padding:80px 0; text-align:center; min-height: 70vh;">
  <div class="container" style="max-width:800px;">
    
    <div style="margin-bottom: 24px; font-size: 48px;">🏕️</div>
    <h1 style="font-size:36px; color:var(--primary); margin-bottom:16px; font-family:'Cormorant Garamond', serif;">Jadilah Bagian dari Perubahan</h1>
    <p style="font-size:18px; color:var(--text-muted); margin-bottom:40px; line-height: 1.6;">
      KalaFabrics Ranger adalah program kerelawanan untuk Anda yang peduli pada isu limbah tekstil dan kelestarian lingkungan bumi. Mari turun tangan langsung bersama kami.
    </p>

    <!-- LOGIKA PENGECEKAN ROLE -->
    @auth
        @if(auth()->user()->role === 'ranger')
            <!-- Jika User adalah Ranger -->
            <div style="background:#e8f5f0; border:1px solid #c8e6d8; padding:32px; border-radius:12px; margin-bottom:32px;">
                <h3 style="color:#2d6a4f; margin-bottom:8px;">Anda sudah terdaftar sebagai Ranger! 🌟</h3>
                <p style="color:#2d6a4f; margin-bottom:24px;">Terima kasih atas dedikasi Anda. Misi lapangan terbaru sudah menanti Anda.</p>
                <a href="{{ route('ranger.dashboard') }}" class="btn btn-primary" style="font-size:16px; padding:12px 32px;">Masuk ke Hub Ranger</a>
            </div>
        @else
            <!-- Jika User login tapi BUKAN Ranger (misal: B2C / B2B) -->
            <div style="background:#faf9f6; border:1px solid #d8d4c8; padding:32px; border-radius:12px; margin-bottom:32px;">
                <h3 style="margin-bottom:12px; color:#1e2318;">Tertarik menjadi Ranger?</h3>
                <p style="margin-bottom:24px; color:#6b6b5a;">Akun Anda saat ini terdaftar sebagai <b>{{ strtoupper(auth()->user()->role) }}</b>. Untuk beralih atau mendaftar sebagai relawan Ranger, silakan hubungi tim Admin kami.</p>
                <a href="{{ route('contact') }}" class="btn btn-secondary" style="font-size:16px; padding:12px 32px;">Hubungi Admin</a>
            </div>
        @endif
    @else
        <!-- Jika belum login sama sekali -->
        <a href="{{ route('register') }}" class="btn btn-primary" style="font-size:18px; padding:14px 40px;">Daftar Jadi Ranger Sekarang</a>
    @endauth
    
    <div style="margin-top: 60px; text-align: left;">
        <h3 style="margin-bottom: 20px;">Apa saja tugas seorang Ranger?</h3>
        <ul style="color: var(--text-muted); line-height: 1.8;">
            <li>Mengedukasi masyarakat tentang bahaya limbah tekstil (Fast Fashion).</li>
            <li>Membantu proses penyortiran kain donasi dari mitra B2B.</li>
            <li>Menjadi panitia atau fasilitator dalam acara Workshop Upcycling KalaFabrics.</li>
            <li>Menjalankan kampanye lingkungan hidup di berbagai daerah.</li>
        </ul>
    </div>

  </div>
</section>
@endsection