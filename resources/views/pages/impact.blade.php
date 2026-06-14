@extends('layouts.app')
@section('title', 'Dashboard Dampak')

@push('styles')
<style>
  .dashboard-grid-4 { display:grid; grid-template-columns:repeat(4,1fr); gap:16px; margin-bottom:32px; }
  @media(max-width:1024px){ .dashboard-grid-4{ grid-template-columns:repeat(2,1fr); } }
  .chart-grid { display:grid; grid-template-columns:2fr 1fr; gap:24px; margin-bottom:24px; }
  .bottom-grid { display:grid; grid-template-columns:1fr 1fr; gap:24px; }
  @media(max-width:768px){ .chart-grid,.bottom-grid{ grid-template-columns:1fr; } }
</style>
@endpush

@section('content')
<section style="padding:60px 0 40px">
  <div class="container">
    <h1>Dashboard Dampak KalaFabrics</h1>
    <p style="margin-top:12px;max-width:540px">Transparansi komitmen kami terhadap lingkungan. Setiap meter kain bercerita tentang keberlanjutan dan jejak ekologis yang lebih baik.</p>
  </div>
</section>

<section style="padding:0 0 60px">
  <div class="container">

    <!-- Stats Row -->
    <div class="dashboard-grid-4">
      <div class="dashboard-stat">
        <div class="dash-stat-label">Waste Managed <span>♻️</span></div>
        <div class="dash-stat-val">12,450<span class="dash-stat-unit">kg</span></div>
        <div class="dash-stat-change">↑ +15% this month</div>
      </div>
      <div class="dashboard-stat">
        <div class="dash-stat-label">Water Saved <span>💧</span></div>
        <div class="dash-stat-val">45,000<span class="dash-stat-unit" style="font-size:.9rem">Liters</span></div>
        <div class="dash-stat-change">↑ +8% this month</div>
      </div>
      <div class="dashboard-stat">
        <div class="dash-stat-label">CO2 Reduced <span style="font-size:9px;font-weight:800">CO₂</span></div>
        <div class="dash-stat-val">1.2<span class="dash-stat-unit" style="font-size:.9rem">tons</span></div>
        <div class="dash-stat-change">↑ +22% this month</div>
      </div>
      <div class="dashboard-stat">
        <div class="dash-stat-label">Products Created <span>👗</span></div>
        <div class="dash-stat-val">3,102<span class="dash-stat-unit" style="font-size:.9rem">items</span></div>
        <div class="dash-stat-change">↑ +5% this month</div>
      </div>
    </div>

    <!-- Charts -->
    <div class="chart-grid">
      <div class="chart-card">
        <h3>Tren Dampak Bulanan</h3>
        <canvas id="lineChart" style="width:100%;display:block"></canvas>
      </div>
      <div class="chart-card">
        <h3>Kategori Limbah</h3>
        <div class="donut-wrapper">
          <canvas id="donutChart" style="flex-shrink:0"></canvas>
          <div class="donut-legend">
            <div class="legend-item"><span class="legend-dot" style="background:#2d3a1e"></span>Katun</div>
            <div class="legend-item"><span class="legend-dot" style="background:#8bc4a0"></span>Polyester</div>
            <div class="legend-item"><span class="legend-dot" style="background:#c9a85c"></span>Denim</div>
            <div class="legend-item"><span class="legend-dot" style="background:#4a7c59"></span>Linen</div>
            <div class="legend-item"><span class="legend-dot" style="background:#d4cfc4"></span>Lainnya</div>
          </div>
        </div>
      </div>
    </div>

    <!-- Bottom -->
    <div class="bottom-grid">
      <!-- Donors -->
      <div class="chart-card">
        <div class="d-flex align-center justify-between" style="margin-bottom:20px">
          <h3 style="margin:0">Pahlawan Sirkular (Top 5 Donors)</h3>
          <span>🏆</span>
        </div>
        <div class="donor-row">
          <div class="donor-rank gold">1</div>
          <div class="donor-name">Batik Adipura</div>
          <div class="donor-kg">450 kg</div>
        </div>
        <div class="donor-row">
          <div class="donor-rank silver">2</div>
          <div class="donor-name">Lestari Garment</div>
          <div class="donor-kg">380 kg</div>
        </div>
        <div class="donor-row">
          <div class="donor-rank bronze">3</div>
          <div class="donor-name">Indira Textiles</div>
          <div class="donor-kg">310 kg</div>
        </div>
        <div class="donor-row">
          <div class="donor-rank">4</div>
          <div class="donor-name">Studio Kain</div>
          <div class="donor-kg">290 kg</div>
        </div>
        <div class="donor-row">
          <div class="donor-rank">5</div>
          <div class="donor-name">Sartorial Co.</div>
          <div class="donor-kg">215 kg</div>
        </div>
      </div>

      <!-- Activity -->
      <div class="chart-card">
        <h3>Aktivitas Terbaru</h3>
        <div class="activity-item">
          <div class="activity-dot"></div>
          <div>
            <div class="activity-time">2 Jam lalu</div>
            <div class="activity-text">Batik Adipura mendonasikan 50kg sisa kain katun.</div>
          </div>
        </div>
        <div class="activity-item">
          <div class="activity-dot amber"></div>
          <div>
            <div class="activity-time">Kemarin</div>
            <div class="activity-text">KalaFabrics memproduksi 24 Tote Bag dari limbah denim.</div>
          </div>
        </div>
        <div class="activity-item">
          <div class="activity-dot dark"></div>
          <div>
            <div class="activity-time">3 Hari lalu</div>
            <div class="activity-text">Workshop Upcycling berhasil menyelamatkan 120kg limbah tekstil.</div>
          </div>
        </div>
      </div>
    </div>

    <!-- Methodology Note -->
    <div style="margin-top:40px;text-align:center">
      <p class="text-sm text-muted" style="max-width:700px;margin:0 auto">
        <strong style="color:var(--text)">ⓘ Catatan Metodologi:</strong> Pengurangan CO2 dihitung berdasarkan standar LCA (Life Cycle Assessment) tekstil yang mengasumsikan 1kg limbah kapas yang diselamatkan dari TPA mencegah emisi metana yang setara. Penghematan air diukur terhadap konsumsi rata-rata produksi kapas murni.
      </p>
    </div>

  </div>
</section>
@endsection
