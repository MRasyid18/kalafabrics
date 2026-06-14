<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Daftar Akun - KalaFabrics</title>
  <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;0,600;1,300;1,400&family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;1,9..40,300&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>

<div class="register-layout">

  <!-- Left Panel -->
  <div class="register-left">
    <img class="register-left-bg" src="https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=800&q=80" alt="bg">
    <div class="register-left-brand">
      <span style="background:var(--accent-light);width:20px;height:20px;border-radius:50%;display:inline-block"></span>
      KalaFabrics
    </div>
    <div class="register-left-content">
      <p class="register-quote">"Merajut kembali benang yang terputus, menciptakan nilai baru dari setiap serat untuk masa depan yang lebih tenang."</p>
      <div class="register-divider-line"></div>
      <div class="register-attr">— FILOSOFI KALA</div>
    </div>
  </div>

  <!-- Right Panel -->
  <div class="register-right">
    <div class="intro-tag">Mulai Perjalanan Sirkular Anda</div>
    <p class="intro-desc">Bergabunglah dengan ekosistem kami untuk mengubah limbah kain menjadi karya bernilai.</p>

    <div class="form-group">
      <label class="form-label">Nama Lengkap</label>
      <input type="text" class="form-control" placeholder="Masukkan nama lengkap Anda">
    </div>

    <div class="form-group">
      <label class="form-label">Email</label>
      <input type="email" class="form-control" placeholder="nama@email.com">
    </div>

    <div class="input-row">
      <div class="form-group">
        <label class="form-label">Kata Sandi</label>
        <input type="password" class="form-control" placeholder="Minimal 8 karakter">
      </div>
      <div class="form-group">
        <label class="form-label">Konfirmasi Kata Sandi</label>
        <input type="password" class="form-control" placeholder="Ulangi kata sandi">
      </div>
    </div>

    <div style="margin:32px 0 20px">
      <label class="form-label">Pilih Peran Anda</label>

      <div class="role-card selected" onclick="selectRole(this)">
        <div class="role-card-header">
          <div class="role-title">
            <span>🌿</span>
            Member
          </div>
          <div class="role-check">
            <svg width="12" height="12" viewBox="0 0 12 12" fill="none" stroke="white" stroke-width="2"><polyline points="2,6 5,9 10,3"/></svg>
          </div>
        </div>
        <div class="role-desc">Untuk Anda yang ingin mendonasikan kain, membeli produk, dan mengumpulkan poin.</div>
      </div>

      <div class="role-card" onclick="selectRole(this)">
        <div class="role-card-header">
          <div class="role-title">
            <span>🏢</span>
            Mitra B2B
          </div>
          <div class="role-check">
            <svg width="12" height="12" viewBox="0 0 12 12" fill="none" stroke="white" stroke-width="2"><polyline points="2,6 5,9 10,3"/></svg>
          </div>
        </div>
        <div class="role-desc">Untuk kafe, restoran, atau perusahaan yang ingin solusi tekstil berkelanjutan.</div>
      </div>

      <div class="role-card" onclick="selectRole(this)">
        <div class="role-card-header">
          <div class="role-title">
            <span>🤝</span>
            Ranger
          </div>
          <div class="role-check">
            <svg width="12" height="12" viewBox="0 0 12 12" fill="none" stroke="white" stroke-width="2"><polyline points="2,6 5,9 10,3"/></svg>
          </div>
        </div>
        <div class="role-desc">Untuk aktivis muda yang ingin bergerak di lapangan dan mengedukasi masyarakat.</div>
      </div>
    </div>

    <a href="{{ route('home') }}" class="btn btn-primary btn-block btn-lg" style="margin-bottom:20px">Buat Akun →</a>

    <p class="text-center text-sm text-muted">
      Sudah punya akun? <a href="{{ route('login') }}" style="color:var(--accent)">Masuk di sini</a>
    </p>
  </div>

</div>

<script>
function selectRole(card) {
  document.querySelectorAll('.role-card').forEach(function(c){ c.classList.remove('selected'); });
  card.classList.add('selected');
}
</script>
</body>
</html>
