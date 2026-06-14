<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@yield('title', 'Dashboard') — KalaFabrics Admin</title>
  <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;0,600;1,300;1,400&family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;1,9..40,300&display=swap" rel="stylesheet">
  <style>
    /* ── Admin CSS ── */
    *,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
    html{scroll-behavior:smooth}
    body{font-family:'DM Sans',sans-serif;background:#f0ede6;color:#1e2318;font-size:15px;line-height:1.65;-webkit-font-smoothing:antialiased;display:flex;min-height:100vh}
    a{color:inherit;text-decoration:none}
    button{cursor:pointer;border:none;background:none;font-family:inherit}

    /* Sidebar */
    .sidebar{
      width:240px;flex-shrink:0;background:#1e2318;min-height:100vh;
      display:flex;flex-direction:column;position:fixed;top:0;left:0;
      z-index:100;transition:transform .3s ease;
    }
    .sidebar-brand{
      padding:24px 20px 20px;border-bottom:1px solid rgba(255,255,255,.08);
      display:flex;align-items:center;gap:10px;
    }
    .sidebar-brand-icon{
      width:32px;height:32px;background:#c9a85c;border-radius:8px;
      display:flex;align-items:center;justify-content:center;font-size:14px;font-weight:700;color:#1e2318;
    }
    .sidebar-brand-text{font-family:'Cormorant Garamond',serif;font-size:1.15rem;color:white;font-weight:500;}
    .sidebar-brand-sub{font-size:10px;color:rgba(255,255,255,.4);letter-spacing:.08em;text-transform:uppercase;}

    .sidebar-nav{flex:1;padding:16px 10px;}
    .nav-section-label{
      font-size:10px;font-weight:600;letter-spacing:.1em;text-transform:uppercase;
      color:rgba(255,255,255,.3);padding:12px 10px 8px;
    }
    .nav-item{
      display:flex;align-items:center;gap:10px;padding:10px 12px;
      border-radius:8px;font-size:14px;color:rgba(255,255,255,.6);
      transition:all .2s ease;margin-bottom:2px;
    }
    .nav-item:hover{background:rgba(255,255,255,.06);color:rgba(255,255,255,.9);}
    .nav-item.active{background:rgba(201,168,92,.15);color:#c9a85c;}
    .nav-item .nav-icon{width:18px;text-align:center;flex-shrink:0;}
    .nav-item .nav-badge{
      margin-left:auto;background:rgba(255,255,255,.12);color:rgba(255,255,255,.5);
      font-size:11px;padding:2px 7px;border-radius:999px;
    }
    .nav-item.coming-soon{opacity:.4;cursor:default;}
    .nav-item.coming-soon:hover{background:none;color:rgba(255,255,255,.6);}

    .sidebar-footer{padding:16px;border-top:1px solid rgba(255,255,255,.08);}
    .admin-profile{display:flex;align-items:center;gap:10px;margin-bottom:12px;}
    .admin-avatar{
      width:36px;height:36px;border-radius:50%;background:#c9a85c;
      display:flex;align-items:center;justify-content:center;
      font-size:13px;font-weight:700;color:#1e2318;flex-shrink:0;
    }
    .admin-info-name{font-size:13px;font-weight:500;color:white;}
    .admin-info-role{font-size:11px;color:rgba(255,255,255,.4);}
    .sidebar-logout{
      display:flex;align-items:center;gap:8px;width:100%;padding:9px 12px;
      border-radius:8px;font-size:13px;color:rgba(255,255,255,.4);
      transition:all .2s ease;
    }
    .sidebar-logout:hover{background:rgba(192,57,43,.15);color:#e07070;}

    /* Main area */
    .admin-main{margin-left:240px;flex:1;min-height:100vh;display:flex;flex-direction:column;}

    /* Top bar */
    .admin-topbar{
      background:white;border-bottom:1px solid #e8e5dd;
      padding:0 32px;height:60px;display:flex;align-items:center;
      justify-content:space-between;position:sticky;top:0;z-index:50;
    }
    .topbar-title{font-size:16px;font-weight:500;color:#1e2318;}
    .topbar-right{display:flex;align-items:center;gap:16px;}
    .topbar-date{font-size:13px;color:#9a9988;}
    .topbar-site-link{
      font-size:13px;color:#2d3a1e;border:1.5px solid #d8d4c8;
      padding:6px 14px;border-radius:999px;transition:all .2s ease;
      display:flex;align-items:center;gap:6px;
    }
    .topbar-site-link:hover{background:#edeae3;border-color:#2d3a1e;}

    /* Page content */
    .admin-content{padding:32px;flex:1;}

    /* Page header */
    .page-header{margin-bottom:28px;}
    .page-header h1{font-family:'Cormorant Garamond',serif;font-size:2rem;font-weight:400;margin-bottom:6px;}
    .page-header p{font-size:14px;color:#6b6b5a;}

    /* Stat cards */
    .stats-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:16px;margin-bottom:28px;}
    @media(max-width:1100px){.stats-grid{grid-template-columns:repeat(2,1fr);}}
    .stat-card{background:white;border:1px solid #e8e5dd;border-radius:16px;padding:24px;transition:box-shadow .2s ease;}
    .stat-card:hover{box-shadow:0 4px 16px rgba(30,35,24,.1);}
    .stat-card-header{display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:16px;}
    .stat-card-label{font-size:12px;font-weight:600;letter-spacing:.06em;text-transform:uppercase;color:#9a9988;}
    .stat-card-icon{width:38px;height:38px;border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:18px;}
    .icon-green{background:#e8f5f0;}
    .icon-amber{background:#fdf0dc;}
    .icon-blue{background:#e8eef8;}
    .icon-purple{background:#f0e8f8;}
    .stat-card-val{font-family:'Cormorant Garamond',serif;font-size:2.4rem;font-weight:300;line-height:1;margin-bottom:8px;}
    .stat-card-sub{font-size:13px;color:#9a9988;}
    .stat-card-trend{font-size:12px;color:#2d6a4f;display:flex;align-items:center;gap:4px;margin-top:6px;}

    /* Tables */
    .card{background:white;border:1px solid #e8e5dd;border-radius:16px;overflow:hidden;}
    .card-header{padding:20px 24px;border-bottom:1px solid #e8e5dd;display:flex;justify-content:space-between;align-items:center;}
    .card-header h3{font-family:'Cormorant Garamond',serif;font-size:1.2rem;font-weight:400;}
    .card-body{padding:0;}
    table{width:100%;border-collapse:collapse;}
    thead th{padding:12px 20px;font-size:11px;font-weight:600;letter-spacing:.07em;text-transform:uppercase;color:#9a9988;text-align:left;border-bottom:1px solid #e8e5dd;background:#faf9f6;}
    tbody td{padding:14px 20px;font-size:14px;border-bottom:1px solid #f0ede6;vertical-align:middle;}
    tbody tr:last-child td{border-bottom:none;}
    tbody tr:hover td{background:#faf9f6;}

    /* Role badges */
    .role-pill{display:inline-flex;align-items:center;padding:3px 10px;border-radius:999px;font-size:11px;font-weight:600;letter-spacing:.04em;}
    .role-admin   {background:#fdf0dc;color:#8b6914;}
    .role-pengguna{background:#e8e5dd;color:#6b6b5a;}
    .role-ranger  {background:#e8f5f0;color:#2d6a4f;}

    /* Welcome banner */
    .welcome-banner{
      background:linear-gradient(135deg,#1e2318 0%,#2d3a1e 60%,#3d5228 100%);
      border-radius:20px;padding:32px 36px;margin-bottom:28px;
      display:flex;align-items:center;justify-content:space-between;
      color:white;position:relative;overflow:hidden;
    }
    .welcome-banner::after{
      content:'♻';position:absolute;right:24px;top:50%;transform:translateY(-50%);
      font-size:80px;opacity:.06;line-height:1;
    }
    .welcome-title{font-family:'Cormorant Garamond',serif;font-size:1.6rem;font-weight:400;margin-bottom:6px;}
    .welcome-sub{font-size:13px;color:rgba(255,255,255,.65);}
    .welcome-badge{background:rgba(201,168,92,.2);color:#c9a85c;border:1px solid rgba(201,168,92,.3);padding:6px 14px;border-radius:999px;font-size:12px;font-weight:600;white-space:nowrap;}

    /* Activity */
    .two-col{display:grid;grid-template-columns:1fr 1fr;gap:20px;margin-top:20px;}
    @media(max-width:900px){.two-col{grid-template-columns:1fr;}}

    .activity-item{display:flex;gap:12px;padding:14px 20px;border-bottom:1px solid #f0ede6;}
    .activity-item:last-child{border-bottom:none;}
    .activity-dot{width:10px;height:10px;border-radius:50%;flex-shrink:0;margin-top:5px;}
    .dot-green{background:#2d6a4f;}
    .dot-amber{background:#c9a85c;}
    .dot-primary{background:#2d3a1e;}
    .activity-time{font-size:12px;color:#9a9988;margin-bottom:3px;}
    .activity-text{font-size:13px;color:#1e2318;}

    /* Empty state */
    .empty-state{text-align:center;padding:40px 20px;color:#9a9988;}
    .empty-state .icon{font-size:36px;margin-bottom:10px;}
    .empty-state p{font-size:14px;}

    /* Responsive */
    @media(max-width:768px){
      .sidebar{transform:translateX(-100%);}
      .admin-main{margin-left:0;}
    }
  </style>
  @stack('styles')
</head>
<body>

  <!-- ── Sidebar ── -->
  <aside class="sidebar">
    <div class="sidebar-brand">
      <div class="sidebar-brand-icon">K</div>
      <div>
        <div class="sidebar-brand-text">KalaFabrics</div>
        <div class="sidebar-brand-sub">Admin Panel</div>
      </div>
    </div>

    <nav class="sidebar-nav">
      <div class="nav-section-label">Utama</div>

      <a href="{{ route('admin.dashboard') }}" class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
        <span class="nav-icon">📊</span> Dashboard
      </a>

      <div class="nav-section-label" style="margin-top:8px">Manajemen</div>

      <span class="nav-item coming-soon">
        <span class="nav-icon">👥</span> Pengguna
        <span class="nav-badge">Soon</span>
      </span>
      <a href="{{ route('admin.products.index') }}" class="nav-item {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
        <span class="nav-icon">📦</span> Produk
      </a>
      <a href="{{ route('admin.orders.index') }}" class="nav-item {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
        <span class="nav-icon">🛒</span> Pesanan
      </a>
      <span class="nav-item coming-soon">
        <span class="nav-icon">🤝</span> Ranger
        <span class="nav-badge">Soon</span>
      </span>

      <div class="nav-section-label" style="margin-top:8px">Konten</div>

      <span class="nav-item coming-soon">
        <span class="nav-icon">📰</span> Edukasi
        <span class="nav-badge">Soon</span>
      </span>
      <span class="nav-item coming-soon">
        <span class="nav-icon">📅</span> Kegiatan
        <span class="nav-badge">Soon</span>
      </span>

      <div class="nav-section-label" style="margin-top:8px">Laporan</div>

      <span class="nav-item coming-soon">
        <span class="nav-icon">🌿</span> Dampak Lingkungan
        <span class="nav-badge">Soon</span>
      </span>
    </nav>

    <div class="sidebar-footer">
      <div class="admin-profile">
        <div class="admin-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
        <div>
          <div class="admin-info-name">{{ auth()->user()->name }}</div>
          <div class="admin-info-role">Administrator</div>
        </div>
      </div>
      <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="sidebar-logout">
          🚪 Keluar dari Admin
        </button>
      </form>
    </div>
  </aside>

  <!-- ── Main Area ── -->
  <div class="admin-main">

    <!-- Top Bar -->
    <div class="admin-topbar">
      <span class="topbar-title">@yield('page-title', 'Dashboard')</span>
      <div class="topbar-right">
        <span class="topbar-date">{{ now()->locale('id')->isoFormat('dddd, D MMMM Y') }}</span>
        <a href="{{ route('home') }}" class="topbar-site-link" target="_blank">
          <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>
          Lihat Website
        </a>
      </div>
    </div>

    <!-- Content -->
    <div class="admin-content">
      @if(session('success'))
        <div style="background:#e8f5f0;border:1px solid #c8e6d8;border-radius:10px;padding:12px 18px;margin-bottom:20px;font-size:13px;color:#2d6a4f">
          ✅ {{ session('success') }}
        </div>
      @endif
      @yield('content')
    </div>

  </div>

  @stack('scripts')
</body>
</html>
