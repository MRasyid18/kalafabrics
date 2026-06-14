@extends('layouts.admin')
@section('title', 'Dashboard Admin')
@section('page-title', 'Dashboard')

@section('content')

{{-- Welcome Banner --}}
<div class="welcome-banner">
  <div>
    <div class="welcome-title">Selamat datang, {{ auth()->user()->name }}! 👋</div>
    <div class="welcome-sub">Berikut ringkasan aktivitas KalaFabrics hari ini.</div>
  </div>
  <div class="welcome-badge">⚙️ Administrator</div>
</div>

{{-- Stat Cards --}}
<div class="stats-grid">

  <div class="stat-card">
    <div class="stat-card-header">
      <div class="stat-card-label">Total Pengguna</div>
      <div class="stat-card-icon icon-green">👥</div>
    </div>
    <div class="stat-card-val">{{ $stats['total_pengguna'] }}</div>
    <div class="stat-card-sub">Member terdaftar</div>
    <div class="stat-card-trend">↑ Aktif</div>
  </div>

  <div class="stat-card">
    <div class="stat-card-header">
      <div class="stat-card-label">Total Ranger</div>
      <div class="stat-card-icon icon-amber">🤝</div>
    </div>
    <div class="stat-card-val">{{ $stats['total_ranger'] }}</div>
    <div class="stat-card-sub">Ranger aktif</div>
    <div class="stat-card-trend" style="color:#8b6914">↑ Aktif</div>
  </div>

  <div class="stat-card">
    <div class="stat-card-header">
      <div class="stat-card-label">Total Admin</div>
      <div class="stat-card-icon icon-blue">⚙️</div>
    </div>
    <div class="stat-card-val">{{ $stats['total_admin'] }}</div>
    <div class="stat-card-sub">Administrator sistem</div>
  </div>

  <div class="stat-card">
    <div class="stat-card-header">
      <div class="stat-card-label">Semua Pengguna</div>
      <div class="stat-card-icon icon-purple">🌿</div>
    </div>
    <div class="stat-card-val">{{ $stats['total_users'] }}</div>
    <div class="stat-card-sub">Total akun terdaftar</div>
  </div>

</div>

{{-- Dampak Lingkungan (statis / placeholder) --}}
<div class="stats-grid" style="margin-bottom:28px">

  <div class="stat-card">
    <div class="stat-card-header">
      <div class="stat-card-label">Limbah Diolah</div>
      <div class="stat-card-icon icon-green">♻️</div>
    </div>
    <div class="stat-card-val">1,250 <span style="font-size:1.2rem">kg</span></div>
    <div class="stat-card-sub">Kain berhasil diselamatkan</div>
    <div class="stat-card-trend">↑ +15% bulan ini</div>
  </div>

  <div class="stat-card">
    <div class="stat-card-header">
      <div class="stat-card-label">Air Dihemat</div>
      <div class="stat-card-icon icon-blue">💧</div>
    </div>
    <div class="stat-card-val">15,000 <span style="font-size:1.2rem">L</span></div>
    <div class="stat-card-sub">Total penghematan air</div>
    <div class="stat-card-trend">↑ +8% bulan ini</div>
  </div>

  <div class="stat-card">
    <div class="stat-card-header">
      <div class="stat-card-label">CO₂ Dikurangi</div>
      <div class="stat-card-icon icon-amber">🌿</div>
    </div>
    <div class="stat-card-val">3,500 <span style="font-size:1.2rem">kg</span></div>
    <div class="stat-card-sub">Emisi berhasil dicegah</div>
    <div class="stat-card-trend">↑ +22% bulan ini</div>
  </div>

  <div class="stat-card">
    <div class="stat-card-header">
      <div class="stat-card-label">Produk Dibuat</div>
      <div class="stat-card-icon icon-purple">👗</div>
    </div>
    <div class="stat-card-val">850<span style="font-size:1.2rem">+</span></div>
    <div class="stat-card-sub">Item sirkular diciptakan</div>
    <div class="stat-card-trend">↑ +5% bulan ini</div>
  </div>

</div>

{{-- Tabel & Aktivitas --}}
<div class="two-col">

  {{-- Pengguna Terbaru --}}
  <div class="card">
    <div class="card-header">
      <h3>Pengguna Terbaru</h3>
      <span style="font-size:12px;color:#9a9988">5 terakhir mendaftar</span>
    </div>
    <div class="card-body">
      @if($recent_users->count())
        <table>
          <thead>
            <tr>
              <th>Nama</th>
              <th>Role</th>
              <th>Bergabung</th>
            </tr>
          </thead>
          <tbody>
            @foreach($recent_users as $user)
              <tr>
                <td>
                  <div style="display:flex;align-items:center;gap:10px">
                    <div style="width:30px;height:30px;border-radius:50%;background:#edeae3;display:flex;align-items:center;justify-content:center;font-size:12px;font-weight:600;color:#6b6b5a;flex-shrink:0">
                      {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>
                    <div>
                      <div style="font-size:14px;font-weight:500">{{ $user->name }}</div>
                      <div style="font-size:12px;color:#9a9988">{{ $user->email }}</div>
                    </div>
                  </div>
                </td>
                <td>
                  <span class="role-pill role-{{ $user->role }}">{{ $user->roleBadge() }}</span>
                </td>
                <td style="font-size:13px;color:#9a9988">
                  {{ $user->created_at->diffForHumans() }}
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      @else
        <div class="empty-state">
          <div class="icon">👤</div>
          <p>Belum ada pengguna terdaftar.</p>
        </div>
      @endif
    </div>
  </div>

  {{-- Aktivitas Terbaru (statis) --}}
  <div class="card">
    <div class="card-header">
      <h3>Aktivitas Platform</h3>
      <span style="font-size:12px;color:#9a9988">Terbaru</span>
    </div>
    <div class="card-body">
      <div class="activity-item">
        <div class="activity-dot dot-green"></div>
        <div>
          <div class="activity-time">2 jam lalu</div>
          <div class="activity-text">Pengguna baru mendaftar sebagai Member.</div>
        </div>
      </div>
      <div class="activity-item">
        <div class="activity-dot dot-amber"></div>
        <div>
          <div class="activity-time">Kemarin</div>
          <div class="activity-text">KalaFabrics memproduksi 24 Tote Bag dari limbah denim.</div>
        </div>
      </div>
      <div class="activity-item">
        <div class="activity-dot dot-primary"></div>
        <div>
          <div class="activity-time">3 hari lalu</div>
          <div class="activity-text">Workshop Upcycling berhasil menyelamatkan 120kg limbah tekstil.</div>
        </div>
      </div>
      <div class="activity-item">
        <div class="activity-dot dot-green"></div>
        <div>
          <div class="activity-time">4 hari lalu</div>
          <div class="activity-text">Batik Adipura mendonasikan 50kg sisa kain katun.</div>
        </div>
      </div>
      <div class="activity-item">
        <div class="activity-dot dot-amber"></div>
        <div>
          <div class="activity-time">1 minggu lalu</div>
          <div class="activity-text">Ranger baru bergabung di wilayah Bandung.</div>
        </div>
      </div>
    </div>
  </div>

</div>

{{-- Info fitur menyusul --}}
<div style="margin-top:24px;background:white;border:1px dashed #d8d4c8;border-radius:16px;padding:28px;text-align:center">
  <div style="font-size:28px;margin-bottom:10px">🚧</div>
  <div style="font-size:15px;font-weight:500;color:#1e2318;margin-bottom:6px">Fitur Lainnya Segera Hadir</div>
  <p style="font-size:13px;color:#9a9988;max-width:420px;margin:0 auto">
    Manajemen Pengguna, Produk, Pesanan, Ranger, Konten Edukasi, dan Laporan Dampak Lingkungan akan segera tersedia.
  </p>
</div>

@endsection
