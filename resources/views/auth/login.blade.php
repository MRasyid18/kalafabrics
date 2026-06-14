<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sign In - KalaFabrics</title>
  <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;0,600;1,300;1,400&family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;1,9..40,300&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>

<div class="auth-page">

  <!-- Nav -->
  <nav class="auth-nav">
    <a href="{{ route('home') }}" class="navbar-brand">KalaFabrics</a>
  </nav>

  <!-- Main -->
  <main class="auth-main">
    <div class="auth-card">
      <h2>Selamat Datang Kembali</h2>
      <p class="auth-subtitle">Silakan masuk untuk melanjutkan perjalanan sirkular Anda.</p>

      {{-- Alert Error --}}
      @if ($errors->any())
        <div style="background:#fdf0ee;border:1px solid #f5c6c0;border-radius:8px;padding:12px 16px;margin-bottom:20px;font-size:13px;color:#c0392b">
          {{ $errors->first() }}
        </div>
      @endif

      {{-- Alert Success (setelah logout/register) --}}
      @if (session('success'))
        <div style="background:#e8f5f0;border:1px solid #c8e6d8;border-radius:8px;padding:12px 16px;margin-bottom:20px;font-size:13px;color:#2d6a4f">
          {{ session('success') }}
        </div>
      @endif

      <form method="POST" action="{{ route('login.post') }}">
        @csrf

        <div class="form-group">
          <label class="form-label">Email</label>
          <input type="email" name="email" class="form-control @error('email') invalid @enderror"
            placeholder="nama@email.com" value="{{ old('email') }}" autocomplete="email">
        </div>

        <div class="form-group">
          <div class="d-flex justify-between align-center" style="margin-bottom:8px">
            <label class="form-label" style="margin:0">Password</label>
          </div>
          <div class="input-wrapper">
            <input type="password" name="password" id="passwordInput" class="form-control"
              placeholder="••••••••" autocomplete="current-password">
            <button type="button" class="input-toggle" onclick="togglePass()">&#128064;</button>
          </div>
        </div>

        <div style="display:flex;align-items:center;gap:8px;margin-bottom:24px">
          <input type="checkbox" name="remember" id="remember" style="width:16px;height:16px;cursor:pointer">
          <label for="remember" style="font-size:13px;color:var(--text-muted);cursor:pointer">Ingat saya</label>
        </div>

        <button type="submit" class="btn btn-primary btn-block btn-lg" style="margin-bottom:12px">
          Masuk
        </button>
      </form>

      <a href="{{ route('register') }}" class="btn btn-secondary btn-block btn-lg">
        Daftar Akun Baru
      </a>

      {{-- Demo Login Info --}}
      <div class="auth-divider">
        <div class="auth-divider-line"></div>
        <span class="auth-divider-text">Akun Demo</span>
        <div class="auth-divider-line"></div>
      </div>

      <div style="background:var(--bg-alt);border-radius:var(--r-lg);padding:16px;font-size:13px">
        <div style="margin-bottom:10px;display:flex;justify-content:space-between">
          <span style="color:var(--text-muted)">👤 Admin</span>
          <span>admin@kalafabrics.id / <strong>admin</strong></span>
        </div>
        <div style="display:flex;justify-content:space-between">
          <span style="color:var(--text-muted)">🌿 Pengguna</span>
          <span>pengguna@kalafabrics.id / <strong>password</strong></span>
        </div>
      </div>

    </div>
  </main>

  <!-- Footer -->
  <footer style="padding:24px 40px;border-top:1px solid var(--border-light)">
    <div style="display:flex;justify-content:center;align-items:center">
      <span class="text-xs text-muted">© 2024 KalaFabrics Circular Textiles. All rights reserved.</span>
    </div>
  </footer>
</div>

<script>
function togglePass() {
  var inp = document.getElementById('passwordInput');
  var btn = document.querySelector('.input-toggle');
  if (inp.type === 'password') { inp.type = 'text'; btn.innerHTML = '&#128065;'; }
  else { inp.type = 'password'; btn.innerHTML = '&#128064;'; }
}
</script>
</body>
</html>
