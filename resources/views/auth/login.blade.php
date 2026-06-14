<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sign In - KalaFabrics</title>
  <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;0,600;1,300;1,400&family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;1,9..40,300&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/app.css') }}">
  
  <style>
    /* ── Penyesuaian Responsivitas Tampilan Login ── */
    body, html { margin: 0; padding: 0; height: 100%; background-color: #f0ede6; }
    .auth-page { display: flex; flex-direction: column; min-height: 100vh; }
    
    .auth-nav { padding: 20px; text-align: center; }
    .auth-nav .navbar-brand { font-size: 24px; font-weight: 600; color: #1e2318; text-decoration: none; }
    
    .auth-main { flex: 1; display: flex; align-items: center; justify-content: center; padding: 20px; }
    
    .auth-card { 
      width: 100%; 
      max-width: 400px; 
      background: white; 
      padding: 40px; 
      border-radius: 16px; 
      border: 1px solid #e8e5dd;
      box-shadow: 0 4px 24px rgba(30, 35, 24, 0.04);
    }
    
    .auth-card h2 { font-family: 'Cormorant Garamond', serif; font-size: 28px; margin-top: 0; margin-bottom: 8px; text-align: center; color: #1e2318; }
    .auth-subtitle { text-align: center; color: #6b6b5a; font-size: 14px; margin-bottom: 28px; line-height: 1.5; }
    
    .form-group { margin-bottom: 16px; }
    .form-label { display: block; font-size: 13px; font-weight: 600; color: #6b6b5a; margin-bottom: 6px; }
    .form-control { width: 100%; padding: 12px; border: 1px solid #e8e5dd; border-radius: 8px; font-family: inherit; font-size: 14px; box-sizing: border-box; }
    .form-control:focus { outline: none; border-color: #2d3a1e; }
    
    .input-wrapper { position: relative; }
    .input-toggle { position: absolute; right: 12px; top: 50%; transform: translateY(-50%); background: none; border: none; cursor: pointer; font-size: 16px; color: #9a9988; }
    
    .btn-block { display: block; width: 100%; text-align: center; box-sizing: border-box; }
    .btn-lg { padding: 14px; font-size: 15px; border-radius: 8px; font-weight: 600; text-decoration: none; border: none; cursor: pointer; }
    .btn-primary { background: #2d3a1e; color: white; transition: background 0.2s; }
    .btn-primary:hover { background: #1e2318; }
    .btn-secondary { background: #f0ede6; color: #1e2318; transition: background 0.2s; margin-top: 10px;}
    .btn-secondary:hover { background: #e8e5dd; }

    .footer { padding: 20px; text-align: center; border-top: 1px solid #e8e5dd; font-size: 12px; color: #9a9988; }

    /* Responsivitas untuk Layar HP */
    @media (max-width: 576px) {
      .auth-main { align-items: flex-start; padding: 0 16px; margin-top: 20px; }
      .auth-card { padding: 24px; border: none; box-shadow: none; background: transparent; }
      body, html { background-color: white; }
    }
  </style>
</head>
<body>

<div class="auth-page">

  <nav class="auth-nav">
    <a href="{{ route('home') }}" class="navbar-brand">KalaFabrics</a>
  </nav>

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
          <label class="form-label">Alamat Email</label>
          <input type="email" name="email" class="form-control" placeholder="nama@email.com" value="{{ old('email') }}" required autocomplete="email">
        </div>

        <div class="form-group">
          <label class="form-label">Password</label>
          <div class="input-wrapper">
            <input type="password" name="password" id="passwordInput" class="form-control" placeholder="••••••••" required autocomplete="current-password">
            <button type="button" class="input-toggle" onclick="togglePass()">&#128064;</button>
          </div>
        </div>

        <div style="display:flex;align-items:center;gap:8px;margin-bottom:24px">
          <input type="checkbox" name="remember" id="remember" style="width:16px;height:16px;cursor:pointer">
          <label for="remember" style="font-size:13px;color:#6b6b5a;cursor:pointer">Ingat saya</label>
        </div>

        <button type="submit" class="btn-primary btn-block btn-lg">
          Masuk
        </button>
      </form>

      <a href="{{ route('register') }}" class="btn-secondary btn-block btn-lg" style="display:block;">
        Daftar Akun Baru
      </a>

    </div>
  </main>

  <footer class="footer">
    <span>© {{ date('Y') }} KalaFabrics Circular Textiles. All rights reserved.</span>
  </footer>
</div>

<script>
function togglePass() {
  var inp = document.getElementById('passwordInput');
  var btn = document.querySelector('.input-toggle');
  if (inp.type === 'password') { 
      inp.type = 'text'; 
      btn.innerHTML = '&#128065;'; 
  } else { 
      inp.type = 'password'; 
      btn.innerHTML = '&#128064;'; 
  }
}
</script>
</body>
</html>