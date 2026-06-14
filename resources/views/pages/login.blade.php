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
    <button style="width:32px;height:32px;border:1.5px solid var(--border);border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:14px;color:var(--text-muted)">?</button>
  </nav>

  <!-- Main -->
  <main class="auth-main">
    <div class="auth-card">
      <h2>Selamat Datang Kembali</h2>
      <p class="auth-subtitle">Silakan masuk untuk melanjutkan perjalanan sirkular Anda.</p>

      <div class="form-group">
        <label class="form-label">Email</label>
        <input type="email" class="form-control" placeholder="nama@email.com">
      </div>

      <div class="form-group">
        <div class="d-flex justify-between align-center" style="margin-bottom:8px">
          <label class="form-label" style="margin:0">Password</label>
          <a href="#" class="forgot-link">Lupa Password?</a>
        </div>
        <div class="input-wrapper">
          <input type="password" class="form-control" placeholder="••••••••" id="passwordInput">
          <button class="input-toggle" onclick="togglePass()">&#128064;</button>
        </div>
      </div>

      <div style="margin-top:28px">
        <a href="{{ route('home') }}" class="btn btn-primary btn-block btn-lg" style="margin-bottom:12px">Masuk</a>
        <a href="{{ route('register') }}" class="btn btn-secondary btn-block btn-lg">Daftar Akun</a>
      </div>

      <div class="auth-divider">
        <div class="auth-divider-line"></div>
        <span class="auth-divider-text">Atau masuk cepat (Prototype)</span>
        <div class="auth-divider-line"></div>
      </div>

      <div>
        <a href="{{ route('home') }}" class="quick-login-opt">
          <span class="quick-login-icon">👤</span>
          Masuk sebagai Member
        </a>
        <a href="{{ route('home') }}" class="quick-login-opt">
          <span class="quick-login-icon">🏢</span>
          Masuk sebagai Mitra B2B
        </a>
        <a href="{{ route('home') }}" class="quick-login-opt">
          <span class="quick-login-icon">⚙️</span>
          Masuk sebagai Admin
        </a>
      </div>
    </div>
  </main>

  <!-- Footer -->
  <footer style="padding:24px 40px;border-top:1px solid var(--border-light)">
    <div style="display:flex;justify-content:space-between;align-items:center;max-width:var(--max-w);margin:0 auto;flex-wrap:wrap;gap:12px">
      <span class="navbar-brand">KalaFabrics</span>
      <div style="display:flex;gap:24px">
        <a href="#" class="text-sm text-muted" style="transition:color var(--t)">Sustainability Report</a>
        <a href="#" class="text-sm text-muted" style="transition:color var(--t)">Artisans</a>
        <a href="#" class="text-sm text-muted" style="transition:color var(--t)">B2B Portal</a>
        <a href="{{ route('contact') }}" class="text-sm text-muted" style="transition:color var(--t)">Contact</a>
      </div>
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
