@extends('layouts.app')
@section('title', 'Edukasi Limbah Tekstil')

@section('content')
<!-- Header -->
<section style="padding:60px 0 40px;text-align:center">
  <div class="container">
    <h1>Edukasi Limbah Tekstil</h1>
    <p style="margin-top:16px;max-width:580px;margin-left:auto;margin-right:auto;font-size:15px">Memahami perjalanan kain dari serat hingga sisa potongan. Temukan bagaimana kita dapat memperpanjang usia pakai material dan mengurangi jejak ekologis melalui langkah-langkah sederhana yang berdampak besar.</p>
    <div style="display:flex;justify-content:center;gap:12px;margin-top:28px">
      <a href="#" class="btn btn-primary btn-lg">Ikut Workshop</a>
      <a href="#" class="btn btn-secondary btn-lg">Donasikan Kain</a>
    </div>
  </div>
</section>

<!-- What is Textile Waste -->
<section style="padding:0 0 60px">
  <div class="container">
    <div class="edu-hero-grid">
      <!-- Main Card -->
      <div class="edu-main-card">
        <img class="edu-main-img" src="https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=900&q=80" alt="Textile Waste">
        <div class="edu-main-overlay"></div>
        <div class="edu-main-content">
          <h3>What is textile waste?</h3>
          <p>Limbah tekstil bukan sekadar pakaian usang. Ia mencakup sisa potongan kain (perca) dari proses produksi, benang cacat, hingga pakaian yang tak lagi dikenakan. Dalam ekosistem yang senyap ini, setiap serat memiliki potensi untuk dilahirkan kembali alih-alih berakhir di tempat pembuangan akhir.</p>
        </div>
      </div>
      <!-- Danger Card -->
      <div class="edu-danger-card">
        <div class="edu-danger-icon">⚠️</div>
        <h4>Why it's dangerous</h4>
        <p>Dekomposisi kain sintetis membutuhkan waktu ratusan tahun, melepaskan mikroplastik dan gas metana. Bahkan serat alami pun, jika terperangkap di TPA tanpa oksigen, gagal terurai secara organis dan justru mencemari tanah serta air tanah dengan zat pewarna kimia sisa.</p>
      </div>
    </div>

    <!-- Comparison + Pre-donation -->
    <div class="comparison-grid">
      <div class="comparison-card">
        <h4>♻️ Upcycling vs Recycling</h4>
        <div class="input-row">
          <div>
            <span class="comparison-tag">UPCYCLING</span>
            <p>Meningkatkan nilai material tanpa menghancurkan strukturnya. Contoh: mengubah sisa kain tenun menjadi tas tote premium atau patchwork artistik. Proses ini mempertahankan karakter asli serat.</p>
          </div>
          <div>
            <span class="comparison-tag">RECYCLING</span>
            <p>Memecah material kembali menjadi serat mentah untuk dipintal menjadi benang baru. Proses ini seringkali membutuhkan energi atau bahan kimiawi, namun efektif untuk volume limbah besar.</p>
          </div>
        </div>
      </div>

      <div class="pre-donation-card">
        <h4>♻️ Pre-donation guide</h4>
        <p style="font-size:13px;color:var(--text-muted);margin-bottom:14px">Sebelum mendonasikan kain atau sisa garmen Anda kepada KalaFabrics, pastikan langkah-langkah berikut terpenuhi untuk menjaga kualitas siklus material:</p>
        <ul class="checklist">
          <li><span class="check-dot"></span>Pisahkan kain berdasarkan jenis serat (katun, linen, sintetis) jika memungkinkan.</li>
          <li><span class="check-dot"></span>Pastikan kain dalam keadaan kering untuk mencegah jamur.</li>
          <li><span class="check-dot"></span>Singkirkan elemen non-tekstil seperti ritsleting logam atau kancing plastik keras.</li>
          <li><span class="check-dot"></span>Lipat atau gulung dengan rapi; material yang diperlakukan dengan hormat akan menghasilkan produk daur ulang yang lebih baik.</li>
        </ul>
      </div>
    </div>
  </div>
</section>

<!-- Jurnal Ekologi Tekstil -->
<section class="bg-alt">
  <div class="container">
    <div class="section-title">
      <h2>Jurnal Ekologi Tekstil</h2>
    </div>
    <div class="journal-grid">
      <div class="journal-card">
        <div class="journal-img">
          <img src="https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=600&q=80" alt="Serat">
        </div>
        <div class="journal-body">
          <span class="journal-tag">Panduan</span>
          <div class="journal-title">Membedakan Serat Alami &amp; Sintetis</div>
          <div class="journal-desc">Langkah mudah mengidentifikasi material kain Anda di rumah melalui tes sentuh dan...</div>
        </div>
      </div>
      <div class="journal-card">
        <div class="journal-img">
          <img src="https://images.unsplash.com/photo-1490481651871-ab68de25d43d?w=600&q=80" alt="Lemari">
        </div>
        <div class="journal-body">
          <span class="journal-tag">Filosofi</span>
          <div class="journal-title">Membangun Lemari Kapsul</div>
          <div class="journal-desc">Mengurangi limbah dimulai dari kebiasaan konsumsi. Panduan kurasi pakaian esensial</div>
        </div>
      </div>
      <div class="journal-card">
        <div class="journal-img">
          <img src="https://images.unsplash.com/photo-1556909114-f6e7ad7d3136?w=600&q=80" alt="Patchwork">
        </div>
        <div class="journal-body">
          <span class="journal-tag">Inovasi</span>
          <div class="journal-title">Seni Patchwork Modern</div>
          <div class="journal-desc">Melihat bagaimana sisa kain tak beraturan digabungkan menjadi kanvas baru bernilai...</div>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection
