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

  <div class="register-right">
    <a href="{{ route('home') }}" style="display:inline-flex;align-items:center;gap:6px;font-size:13px;color:var(--text-muted);margin-bottom:32px;transition:color var(--t)">
      ← Kembali ke Beranda
    </a>

    <div class="intro-tag">Mulai Perjalanan Sirkular Anda</div>
    <p class="intro-desc">Bergabunglah dengan ekosistem kami untuk mengubah limbah kain menjadi karya bernilai.</p>

    {{-- Error messages --}}
    @if ($errors->any())
      <div style="background:#fdf0ee;border:1px solid #f5c6c0;border-radius:8px;padding:14px 16px;margin-bottom:24px;font-size:13px;color:#c0392b">
        <strong>Terdapat kesalahan:</strong>
        <ul style="margin:8px 0 0 16px;padding:0">
          @foreach ($errors->all() as $err)
            <li>{{ $err }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <form method="POST" action="{{ route('register.post') }}">
      @csrf

      <div class="form-group">
        <label class="form-label">Nama Lengkap <span style="color:var(--danger)">*</span></label>
        <input type="text" name="name" class="form-control @error('name') invalid @enderror"
          placeholder="Masukkan nama lengkap Anda" value="{{ old('name') }}">
      </div>

      <div class="form-group">
        <label class="form-label">Email <span style="color:var(--danger)">*</span></label>
        <input type="email" name="email" class="form-control @error('email') invalid @enderror"
          placeholder="nama@email.com" value="{{ old('email') }}">
      </div>

      <div class="input-row">
        <div class="form-group">
          <label class="form-label">Kata Sandi <span style="color:var(--danger)">*</span></label>
          <div class="input-wrapper">
            <input type="password" name="password" id="passInput" class="form-control @error('password') invalid @enderror"
              placeholder="Minimal 8 karakter">
            <button type="button" class="input-toggle" onclick="togglePass('passInput', this)">&#128064;</button>
          </div>
        </div>
        <div class="form-group">
          <label class="form-label">Konfirmasi Kata Sandi <span style="color:var(--danger)">*</span></label>
          <div class="input-wrapper">
            <input type="password" name="password_confirmation" id="passConfInput" class="form-control"
              placeholder="Ulangi kata sandi">
            <button type="button" class="input-toggle" onclick="togglePass('passConfInput', this)">&#128064;</button>
          </div>
        </div>
      </div>

      <div style="margin:32px 0 20px">
        <label class="form-label">Pilih Peran Anda <span style="color:var(--danger)">*</span></label>

        <div class="role-card selected" onclick="selectRole(this, 'b2c')" id="role-b2c">
          <div class="role-card-header">
            <div class="role-title">
              <span>🌿</span> Member / Pengguna
            </div>
            <div class="role-check">
              <svg width="12" height="12" viewBox="0 0 12 12" fill="none" stroke="white" stroke-width="2.5">
                <polyline points="2,6 5,9 10,3"/>
              </svg>
            </div>
          </div>
          <div class="role-desc">Untuk Anda yang ingin mendonasikan kain, membeli produk, dan mengumpulkan poin.</div>
        </div>

        <div class="role-card" onclick="selectRole(this, 'b2b')" id="role-b2b">
          <div class="role-card-header">
            <div class="role-title">
              <span>🏢</span> Mitra B2B
            </div>
            <div class="role-check">
              <svg width="12" height="12" viewBox="0 0 12 12" fill="none" stroke="white" stroke-width="2.5">
                <polyline points="2,6 5,9 10,3"/>
              </svg>
            </div>
          </div>
          <div class="role-desc">Untuk kafe, restoran, atau perusahaan yang ingin solusi tekstil berkelanjutan.</div>
        </div>

        <div class="role-card" onclick="selectRole(this, 'ranger')" id="role-ranger">
          <div class="role-card-header">
            <div class="role-title">
              <span>🤝</span> Ranger
            </div>
            <div class="role-check">
              <svg width="12" height="12" viewBox="0 0 12 12" fill="none" stroke="white" stroke-width="2.5">
                <polyline points="2,6 5,9 10,3"/>
              </svg>
            </div>
          </div>
          <div class="role-desc">Untuk aktivis muda yang ingin bergerak di lapangan dan mengedukasi masyarakat.</div>
        </div>

        <input type="hidden" name="role" id="role-input" value="{{ old('role', 'b2c') }}">
      </div>

      <button type="submit" class="btn btn-primary btn-block btn-lg" style="margin-bottom:20px">
        Buat Akun →
      </button>
    </form>

    <p class="text-center text-sm text-muted">
      Sudah punya akun? <a href="{{ route('login') }}" style="color:var(--accent)">Masuk di sini</a>
    </p>
  </div>

</div>

<script>
function selectRole(card, role) {
  document.querySelectorAll('.role-card').forEach(function(c){ c.classList.remove('selected'); });
  card.classList.add('selected');
  document.getElementById('role-input').value = role;
}

function togglePass(inputId, btn) {
  var inp = document.getElementById(inputId);
  if (inp.type === 'password') { inp.type = 'text'; btn.innerHTML = '&#128065;'; }
  else { inp.type = 'password'; btn.innerHTML = '&#128064;'; }
}

// Restore role selection jika ada old value dari form error
var oldRole = '{{ old("role", "b2c") }}';
if (oldRole === 'ranger') {
  selectRole(document.getElementById('role-ranger'), 'ranger');
} else if (oldRole === 'b2b') {
  selectRole(document.getElementById('role-b2b'), 'b2b');
} else {
  selectRole(document.getElementById('role-b2c'), 'b2c');
}
</script>
</body>
</html>