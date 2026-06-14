<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@yield('title', 'KalaFabrics') - KalaFabrics</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;0,600;1,300;1,400&family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;1,9..40,300&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/app.css') }}">
  <style>
    /* User Dropdown */
    .user-menu { position:relative; }
    .user-trigger {
      display:flex;align-items:center;gap:8px;cursor:pointer;
      padding:6px 14px 6px 8px;border-radius:var(--r-full);
      border:1.5px solid var(--border);transition:all var(--t);
      background:transparent;font-family:var(--font-body);font-size:14px;
    }
    .user-trigger:hover { border-color:var(--primary);background:var(--bg-alt); }
    .user-avatar {
      width:30px;height:30px;border-radius:50%;background:var(--primary);
      color:white;display:flex;align-items:center;justify-content:center;
      font-size:12px;font-weight:600;flex-shrink:0;
    }
    .user-name { color:var(--text);font-weight:500; }
    .user-role-badge {
      font-size:10px;padding:2px 7px;border-radius:var(--r-full);
      font-weight:600;letter-spacing:.04em;
    }
    .badge-admin    { background:#fdf0dc;color:#8b6914; }
    .badge-ranger   { background:var(--success-bg);color:var(--success); }
    .badge-pengguna { background:var(--bg-alt);color:var(--text-muted); }

    .user-dropdown {
      position:absolute;top:calc(100% + 8px);right:0;
      background:var(--white);border:1px solid var(--border-light);
      border-radius:var(--r-lg);padding:8px;min-width:200px;
      box-shadow:var(--shadow-md);z-index:200;
      display:none;
    }
    .user-menu.open .user-dropdown { display:block; }
    .user-dropdown-header {
      padding:10px 12px 12px;border-bottom:1px solid var(--border-light);margin-bottom:6px;
    }
    .user-dropdown-name { font-weight:600;font-size:14px;color:var(--text); }
    .user-dropdown-email { font-size:12px;color:var(--text-muted);margin-top:2px; }
    .dropdown-item {
      display:flex;align-items:center;gap:10px;padding:9px 12px;
      border-radius:var(--r-md);font-size:14px;color:var(--text);
      transition:background var(--t);cursor:pointer;width:100%;
      text-align:left;background:none;border:none;font-family:var(--font-body);
    }
    .dropdown-item:hover { background:var(--bg-alt); }
    .dropdown-item.danger { color:var(--danger); }
    .dropdown-item.danger:hover { background:var(--danger-bg); }
    .dropdown-divider { height:1px;background:var(--border-light);margin:6px 0; }

    /* Flash message */
    .flash-bar {
      padding:12px 24px;font-size:13px;text-align:center;
      position:sticky;top:var(--nav-h);z-index:99;
    }
    .flash-success { background:#e8f5f0;color:var(--success);border-bottom:1px solid #c8e6d8; }
    .flash-error   { background:var(--danger-bg);color:var(--danger);border-bottom:1px solid #f5c6c0; }
  </style>
  @stack('styles')
</head>
<body>

  <nav class="navbar">
    <div class="container">
      <a href="{{ route('home') }}" class="navbar-brand">KalaFabrics</a>

      <ul class="navbar-nav">
        <li><a href="{{ route('catalog') }}"   class="{{ request()->routeIs('catalog')   ? 'active' : '' }}">Catalog</a></li>
        <li><a href="{{ route('impact') }}"    class="{{ request()->routeIs('impact')    ? 'active' : '' }}">Impact</a></li>
        <li><a href="{{ route('education') }}" class="{{ request()->routeIs('education') ? 'active' : '' }}">Education</a></li>
        <li><a href="{{ route('ranger') }}"    class="{{ request()->routeIs('ranger')    ? 'active' : '' }}">Ranger</a></li>
        <li><a href="{{ route('contact') }}"   class="{{ request()->routeIs('contact')   ? 'active' : '' }}">Contact</a></li>
        @auth
          @if(auth()->user()->isAdmin())
            <li><a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.*') ? 'active' : '' }}" style="color:var(--accent)">⚙ Admin</a></li>
          @endif
        @endauth
      </ul>

      <div class="navbar-actions">

        @guest
          {{-- Belum login --}}
          <a href="{{ route('login') }}" class="btn-sign-in">Sign In</a>
          <a href="{{ route('register') }}" class="btn btn-primary btn-sm">Daftar</a>
        @endguest

        @auth
          {{-- Sudah login --}}
          @if(!auth()->user()->isAdmin())
            <a href="{{ route('cart') }}" class="btn-cart">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/>
                <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/>
              </svg>
              Cart
              <span class="cart-count" id="global-cart-count">0</span>
            </a>
          @endif

          {{-- User dropdown --}}
          <div class="user-menu" id="userMenu">
            <button class="user-trigger" onclick="toggleUserMenu()">
              <div class="user-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
              <span class="user-name">{{ explode(' ', auth()->user()->name)[0] }}</span>
              <span class="user-role-badge badge-{{ auth()->user()->role }}">{{ auth()->user()->roleBadge() }}</span>
              <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"/></svg>
            </button>

            <div class="user-dropdown">
              <div class="user-dropdown-header">
                <div class="user-dropdown-name">{{ auth()->user()->name }}</div>
                <div class="user-dropdown-email">{{ auth()->user()->email }}</div>
              </div>

              @if(auth()->user()->isAdmin())
                <a href="{{ route('admin.dashboard') }}" class="dropdown-item">⚙️ Dashboard Admin</a>
                <div class="dropdown-divider"></div>
              @endif

              @if(auth()->user()->role === 'ranger')
                <a href="{{ route('ranger.dashboard') }}" class="dropdown-item">🏕️ Hub Ranger</a>
                <div class="dropdown-divider"></div>
              @endif

              @if(!auth()->user()->isAdmin())
                <a href="{{ route('user.orders') }}" class="dropdown-item">📦 Pesanan Saya</a>
                <div class="dropdown-divider"></div>
              @endif

              <a href="{{ route('home') }}" class="dropdown-item">🏠 Beranda</a>

              <div class="dropdown-divider"></div>

              <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="dropdown-item danger">🚪 Keluar</button>
              </form>
            </div>
          </div>
        @endauth

      </div>
    </div>
  </nav>

  {{-- Flash Messages --}}
  @if(session('success'))
    <div class="flash-bar flash-success">✅ {{ session('success') }}</div>
  @endif
  @if(session('error'))
    <div class="flash-bar flash-error">❌ {{ session('error') }}</div>
  @endif

  @yield('content')

  <footer class="footer">
    <div class="container">
      <div class="footer-grid">
        <div>
          <div class="footer-brand">KalaFabrics</div>
          <p class="footer-tagline">© 2024 KalaFabrics. Crafted with<br>Quiet Sustainability.</p>
        </div>
        <div>
          <div class="footer-col-title">Company</div>
          <ul class="footer-links">
            <li><a href="#">About</a></li>
            <li><a href="{{ route('catalog') }}">Katalog</a></li>
          </ul>
        </div>
        <div>
          <div class="footer-col-title">Program</div>
          <ul class="footer-links">
            <li><a href="#">Donasi</a></li>
            <li><a href="#">Kemitraan B2B</a></li>
          </ul>
        </div>
        <div>
          <div class="footer-col-title">Kegiatan</div>
          <ul class="footer-links">
            <li><a href="#">Workshop</a></li>
            <li><a href="{{ route('contact') }}">Kontak</a></li>
          </ul>
        </div>
      </div>
    </div>
  </footer>

  <script src="{{ asset('js/app.js') }}"></script>
  <script>
    function toggleUserMenu() {
      document.getElementById('userMenu').classList.toggle('open');
    }
    // Tutup dropdown jika klik di luar
    document.addEventListener('click', function(e) {
      var menu = document.getElementById('userMenu');
      if (menu && !menu.contains(e.target)) {
        menu.classList.remove('open');
      }
    });

    // BUG FIX: Fungsi untuk mengupdate angka keranjang di navbar
    function updateGlobalCartCount() {
      var cartCountEl = document.getElementById('global-cart-count');
      if (cartCountEl) {
        var cartData = JSON.parse(sessionStorage.getItem('kala_cart')) || [];
        var totalItems = 0;
        
        // Hitung total kuantitas dari semua produk
        cartData.forEach(function(item) {
          totalItems += parseInt(item.qty);
        });
        
        cartCountEl.textContent = totalItems;
      }
    }

    // Jalankan fungsi update saat halaman dimuat
    document.addEventListener('DOMContentLoaded', function() {
      updateGlobalCartCount();
    });

    // Opsional: Jika Anda menghapus atau menambah item di halaman Cart, 
    // update angkanya juga secara langsung
    window.addEventListener('storage', function(e) {
      if(e.key === 'kala_cart') {
        updateGlobalCartCount();
      }
    });
  </script>
  @stack('scripts')
</body>
</html>