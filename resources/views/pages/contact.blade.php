@extends('layouts.app')
@section('title', 'Hubungi Kami')

@section('content')
<section style="padding:80px 0">
  <div class="container">
    <div class="contact-grid">
      <div>
        <h2>Hubungi Kami</h2>
        <p style="margin-top:12px;margin-bottom:32px">Punya pertanyaan atau ide kolaborasi? Jangan ragu untuk mengirim pesan kepada kami.</p>
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
            <textarea class="form-control-box" rows="5" placeholder="Tulis pesan Anda di sini..."></textarea>
          </div>
          <button type="submit" class="btn btn-primary btn-block btn-lg">Kirim Pesan</button>
        </form>
      </div>
    </div>
  </div>
</section>
@endsection
