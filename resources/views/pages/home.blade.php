@extends('layouts.app')
@section('title', 'Beranda Interaktif')

@section('content')

<!-- Hero -->
<section style="padding:0">
  <div class="container">
    <div class="hero-section">
      <div class="hero-content fade-up">
        <h1>Ubah Limbah Kain Menjadi Produk Bernilai</h1>
        <p>KalaFabrics menghubungkan donor limbah, konsumen sadar lingkungan, mitra B2B, pengrajin lokal, dan siswa SMK Tata Busana dalam ekosistem circular textile.</p>
        <div class="hero-actions">
          <a href="#" class="btn btn-primary btn-lg">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
            Donasikan Kain
          </a>
          <a href="{{ route('catalog') }}" class="btn btn-secondary btn-lg">Lihat Produk</a>
        </div>
        <a href="#" class="btn btn-outline btn-sm">Kemitraan B2B</a>
      </div>
      <div class="hero-img-wrapper fade-up delay-2">
        <img src="https://images.unsplash.com/photo-1558769132-cb1aea458c5e?w=800&q=80" alt="Limbah Kain KalaFabrics">
      </div>
    </div>
  </div>
</section>

<!-- Dampak Bersama -->
<section class="bg-alt">
  <div class="container">
    <div class="section-title">
      <h2>Dampak Bersama</h2>
    </div>
    <div class="impact-grid">
      <div class="stat-card fade-up delay-1">
        <div class="stat-icon">♻️</div>
        <div class="stat-value">1,250 <span style="font-size:1.2rem">kg</span></div>
        <div class="stat-label">Limbah Kain Diolola</div>
      </div>
      <div class="stat-card fade-up delay-2">
        <div class="stat-icon">💧</div>
        <div class="stat-value">15,000 <span style="font-size:1.2rem">L</span></div>
        <div class="stat-label">Air Diretematkan</div>
      </div>
      <div class="stat-card fade-up delay-3">
        <div class="stat-icon">🌿</div>
        <div class="stat-value">3,500 <span style="font-size:1.2rem">kg</span></div>
        <div class="stat-label">CO2 Dikurangi</div>
      </div>
      <div class="stat-card fade-up delay-4">
        <div class="stat-icon">👗</div>
        <div class="stat-value">850<span style="font-size:1.2rem">+</span></div>
        <div class="stat-label">Produk Diciptakan</div>
      </div>
    </div>

    <!-- Top Donors -->
    <div class="leaderboard-card" style="max-width:480px;margin:0 auto">
      <div class="leaderboard-header">Top Donasi Bulan Ini</div>
      <div class="leaderboard-row">
        <span class="lb-rank">1</span>
        <span class="lb-name">PT Garmen Makmur</span>
        <span class="lb-level">160 kg</span>
      </div>
      <div class="leaderboard-row">
        <span class="lb-rank">2</span>
        <span class="lb-name">Budi Santoso</span>
        <span class="lb-level">44 kg</span>
      </div>
      <div class="leaderboard-row">
        <span class="lb-rank">3</span>
        <span class="lb-name">Butik Cantik</span>
        <span class="lb-level">30 kg</span>
      </div>
    </div>
  </div>
</section>

<!-- Kegiatan & Edukasi -->
<section>
  <div class="container">
    <div class="section-title">
      <h2>Kegiatan &amp; Edukasi</h2>
    </div>
    <div class="events-grid">
      <!-- Event 1 -->
      <div class="event-card">
        <div class="event-img" style="background:#deded6">
          <span class="event-badge"><span class="badge badge-dark">Workshop</span></span>
          <img src="https://images.unsplash.com/photo-1556909114-f6e7ad7d3136?w=600&q=80" alt="Upcycling Daur">
        </div>
        <div class="event-body">
          <div class="event-category">Workshop</div>
          <div class="event-title">Upcycling Daur</div>
          <div class="event-desc">Pelajari cara mudah mendaur ulang baju lama menjadi totebag yang stylish.</div>
          <div class="event-meta">
            <div class="event-meta-item">📅 16Nov 2024</div>
            <div class="event-meta-item">📍 Hub KalaFabrics, Jakarta</div>
          </div>
          <a href="#" class="btn btn-primary btn-block">Daftar</a>
        </div>
      </div>

      <!-- Event 2 -->
      <div class="event-card">
        <div class="event-img" style="background:#e8d5b0">
          <span class="event-badge"><span class="badge badge-amber">Bazar</span></span>
          <img src="https://images.unsplash.com/photo-1542621334-a254cf47733d?w=600&q=80" alt="Sustainable Market">
        </div>
        <div class="event-body">
          <div class="event-category">Bazar</div>
          <div class="event-title">Sustainable Market</div>
          <div class="event-desc">Temukan produk sirkular dari pengrajin lokal dan dukung ekonomi berkelanjutan.</div>
          <div class="event-meta">
            <div class="event-meta-item">📅 22–23 Nov 2024</div>
            <div class="event-meta-item">📍 Taman Kota, Bandung</div>
          </div>
          <a href="#" class="btn btn-primary btn-block">Lihat Detail</a>
        </div>
      </div>

      <!-- Event 3 -->
      <div class="event-card">
        <div class="event-img" style="background:#c5d5c0">
          <span class="event-badge"><span class="badge badge-green">Komunitas</span></span>
          <img src="https://images.unsplash.com/photo-1529156069898-49953e39b3ac?w=600&q=80" alt="Temu Ranger">
        </div>
        <div class="event-body">
          <div class="event-category">Komunitas</div>
          <div class="event-title">Temu Ranger</div>
          <div class="event-desc">Kumpul santai bulanan untuk berbagi pengalaman dan ide proyek sirkular.</div>
          <div class="event-meta">
            <div class="event-meta-item">📅 30 Nov 2024</div>
            <div class="event-meta-item">🌐 Online (Zoom)</div>
          </div>
          <a href="#" class="btn btn-primary btn-block">Daftar</a>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Bergabung Menjadi Ranger -->
<section class="ranger-section">
  <div class="container">
    <h2>Bergabung Menjadi Ranger</h2>
    <p style="max-width:520px;margin:0 auto 32px">Jadilah agen perubahan di komunitasmu. Ranger KalaFabrics adalah relawan yang mengedukasi, mengumpulkan donasi limbah kain, dan mengorganisir kegiatan sosial lokal.</p>
    <a href="{{ route('register') }}" class="btn btn-primary btn-lg" style="margin-bottom:40px">Daftar Jadi Ranger</a>

    <div class="leaderboard-card" style="max-width:480px;margin:0 auto">
      <div class="leaderboard-header">Leaderboard Ranger</div>
      <div class="leaderboard-row">
        <span class="lb-rank">🥇</span>
        <span class="lb-name">Rina M. (Jakarta)</span>
        <span class="lb-level">Level 6 (Gold)</span>
      </div>
      <div class="leaderboard-row">
        <span class="lb-rank">🥈</span>
        <span class="lb-name">Agus T. (Bandung)</span>
        <span class="lb-level">Level 4 (Silver)</span>
      </div>
      <div class="leaderboard-row">
        <span class="lb-rank">🥉</span>
        <span class="lb-name">Siti A. (Yogyakarta)</span>
        <span class="lb-level">Level 3 (Bronze)</span>
      </div>
    </div>
  </div>
</section>

<!-- Hubungi Kami -->
<section id="contact">
  <div class="container">
    <div class="contact-grid">
      <div>
        <h2>Hubungi Kami</h2>
        <p style="margin-bottom:32px">Punya pertanyaan atau ide kolaborasi? Jangan ragu untuk mengirim pesan kepada kami.</p>
        <div class="contact-detail">
          <span>📍</span>
          <span>Jl. Sirkular No. 123, Jakarta Selatan, Indonesia</span>
        </div>
        <div class="contact-detail">
          <span>✉️</span>
          <span>hello@kalafabrics.id</span>
        </div>
        <div class="contact-detail">
          <span>📞</span>
          <span>+62 812 5464 7890</span>
        </div>
        <div class="social-links">
          <a class="social-link" href="#">IG</a>
          <a class="social-link" href="#">FB</a>
          <a class="social-link" href="#">LI</a>
        </div>
      </div>
      <div>
        <form id="contactForm">
          <div class="form-group">
            <label class="form-label form-label-dark">Nama</label>
            <input type="text" class="form-control-box" placeholder="Nama Lengkap">
          </div>
          <div class="form-group">
            <label class="form-label form-label-dark">Email</label>
            <input type="email" class="form-control-box" placeholder="alamat@email.com">
          </div>
          <div class="form-group">
            <label class="form-label form-label-dark">Pesan</label>
            <textarea class="form-control-box" rows="4" placeholder="Tulis pesan Anda di sini..."></textarea>
          </div>
          <button type="submit" class="btn btn-primary btn-block btn-lg">Kirim Pesan</button>
        </form>
      </div>
    </div>
  </div>
</section>

@endsection
