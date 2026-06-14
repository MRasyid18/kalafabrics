@extends('layouts.app')
@section('title', 'Hub Ranger Lapangan')

@push('styles')
<style>
    /* Styling Tabs */
    .ranger-tabs { display:flex; gap:16px; border-bottom:1px solid #d8d4c8; margin-bottom:24px; overflow-x:auto; white-space:nowrap; }
    .r-tab { padding:12px 20px; font-weight:600; color:#9a9988; cursor:pointer; border-bottom:2px solid transparent; transition:0.2s; }
    .r-tab:hover { color:#1e2318; }
    .r-tab.active { color:#2d3a1e; border-bottom-color:#2d3a1e; }
    .r-pane { display:none; animation:fadeIn 0.3s ease; }
    .r-pane.active { display:block; }
    @keyframes fadeIn { from { opacity:0; transform:translateY(5px); } to { opacity:1; transform:translateY(0); } }

    /* Styling Cards */
    .card-modul { border: 1px solid #e8e5dd; border-radius: 16px; background: white; overflow: hidden; height:100%; display:flex; flex-direction:column; }
    .card-header-modul { background: #faf9f6; border-bottom: 1px solid #e8e5dd; padding: 20px 24px; }
    .card-body-modul { padding: 24px; flex:1; }
    
    .stat-card { background:#faf9f6; border:1px solid #d8d4c8; border-radius:12px; padding:20px; text-align:center; height:100%; }
    .stat-val { font-size:32px; font-weight:600; color:#2d6a4f; margin-bottom:8px; line-height:1; }
    .task-card { background:white; border:1px solid #d8d4c8; border-radius:12px; padding:20px; margin-bottom:16px; transition:0.2s; }
    .task-card:hover { border-color:#c9a85c; box-shadow:0 4px 12px rgba(201,168,92,0.1); }
</style>
@endpush

@section('content')
<div class="container py-5" style="max-width: 1200px;">
    
    <div class="row mb-4 align-items-center">
        <div class="col-lg-8">
            <h1 style="font-family: 'Cormorant Garamond', serif; font-size: clamp(2rem, 5vw, 2.8rem); font-weight: 500; color: #1e2318; margin-bottom: 8px;">
                Ranger Field Hub
            </h1>
            <p style="color: #6b6b5a; font-size: 1.1rem; margin:0;">Selamat bertugas, <strong>{{ $user->name }}</strong>. Akses instrumen operasional Anda di sini.</p>
        </div>
        <div class="col-lg-4 text-lg-end mt-3 mt-lg-0">
            <span style="background: #e8f5f0; color: #2d6a4f; padding: 8px 16px; border-radius: 999px; font-size: 0.85rem; font-weight: 600; border: 1px solid #c8e6d8; display:inline-block;">
                🟢 Status: Aktif / On-Duty
            </span>
        </div>
    </div>

    @if(session('success'))
        <div style="background:#e8f5f0;border:1px solid #c8e6d8;border-radius:8px;padding:12px 16px;margin-bottom:20px;font-size:14px;color:#2d6a4f">
            ✅ {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div style="background:#fdf0ee;border:1px solid #f5c6c0;border-radius:8px;padding:12px 16px;margin-bottom:20px;font-size:14px;color:#c0392b">
            ❌ {{ session('error') }}
        </div>
    @endif

    <div class="ranger-tabs">
        <div class="r-tab active" onclick="switchTab(event, 'tab-operasional')">Operasional Hub (Modul)</div>
        <div class="r-tab" onclick="switchTab(event, 'tab-misi')">Misi & Jam Terbang</div>
        <div class="r-tab" onclick="switchTab(event, 'tab-profil')">Pengaturan Profil</div>
    </div>

    <div id="tab-operasional" class="r-pane active">
        <div class="row g-4">
            
            <div class="col-lg-8">
                <div class="card-modul">
                    <div class="card-header-modul d-flex justify-content-between align-items-center">
                        <div>
                            <h3 style="font-family: 'Cormorant Garamond', serif; font-size: 1.4rem; margin: 0; font-weight: 600; color: #1e2318;">Inbound Logistics Dispatcher</h3>
                            <p style="font-size: 0.8rem; color: #9a9988; margin: 0; margin-top: 4px;">Penyortiran limbah tekstil & validasi Grading B2B.</p>
                        </div>
                        <span class="badge" style="background: #fdf0dc; color: #8b6914; padding: 6px 12px; border-radius: 6px; font-weight: 600;">{{ $sortingTasks->count() }} Antrean</span>
                    </div>
                    <div class="table-responsive">
                        <table class="table w-100 mb-0 align-middle" style="min-width: 600px; white-space: nowrap;">
                            <thead>
                                <tr style="background: white;">
                                    <th style="padding: 16px 24px; font-size: 11px; text-transform: uppercase; color: #9a9988; border-bottom: 1px solid #e8e5dd; text-align: left;">ID Transaksi</th>
                                    <th style="padding: 16px 24px; font-size: 11px; text-transform: uppercase; color: #9a9988; border-bottom: 1px solid #e8e5dd; text-align: left;">Mitra/User</th>
                                    <th style="padding: 16px 24px; font-size: 11px; text-transform: uppercase; color: #9a9988; border-bottom: 1px solid #e8e5dd; text-align: left;">Estimasi Berat</th>
                                    <th style="padding: 16px 24px; font-size: 11px; text-transform: uppercase; color: #9a9988; border-bottom: 1px solid #e8e5dd; text-align: right;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($sortingTasks as $task)
                                <tr>
                                    <td style="padding: 16px 24px; font-family: monospace; font-weight: 600; color: #c9a85c; border-bottom: 1px solid #f0ede6; text-align: left;">#KALA-{{ str_pad($task->id, 5, '0', STR_PAD_LEFT) }}</td>
                                    <td style="padding: 16px 24px; border-bottom: 1px solid #f0ede6; font-weight: 500; text-align: left;">{{ $task->user->name ?? 'Anonim' }}</td>
                                    <td style="padding: 16px 24px; border-bottom: 1px solid #f0ede6; text-align: left;">{{ $task->weight }} Kg</td>
                                    <td style="padding: 16px 24px; border-bottom: 1px solid #f0ede6; text-align: right;">
                                        <a href="{{ route('ranger.waste.validate', $task->id) }}" class="btn btn-sm" style="background: #2d3a1e; color: white; border-radius: 6px; font-size: 12px; font-weight: 600; padding: 6px 14px; transition: 0.2s; text-decoration: none; display: inline-block;" onmouseover="this.style.opacity='0.9'" onmouseout="this.style.opacity='1'">
                                            Validasi & Grading &rarr;
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center py-5" style="color: #9a9988; background: #faf9f6;">Tidak ada penugasan penyortiran limbah saat ini.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card-modul">
                    <div class="card-body-modul">
                        <h3 style="font-family: 'Cormorant Garamond', serif; font-size: 1.4rem; margin-bottom: 4px; font-weight: 600; color: #1e2318;">CMS Contributor</h3>
                        <p style="font-size: 0.85rem; color: #6b6b5a; margin-bottom: 24px;">Unggah dokumentasi / draf edukasi.</p>
                        
                        <div class="d-flex flex-column gap-3">
                            <button type="button" onclick="alert('Membuka Akses Kamera & Galeri (Media Asset Uploader)... \n\n(Catatan: API Uploader ke Server sedang dibangun).')" class="btn w-100" style="background: #faf9f6; color: #1e2318; border: 1px dashed #d8d4c8; padding: 16px; border-radius: 12px; text-align: left; transition: all 0.2s; cursor: pointer;" onmouseover="this.style.borderColor='#c9a85c'; this.style.background='#fdf0dc'" onmouseout="this.style.borderColor='#d8d4c8'; this.style.background='#faf9f6'">
                                <div style="font-size: 1.4rem; margin-bottom: 8px; color: #c9a85c;">☁️</div>
                                <div style="font-weight: 600; font-size: 0.95rem;">Media Asset Uploader</div>
                                <div style="font-size: 0.75rem; color: #9a9988; margin-top: 4px;">Unggah foto event / produk.</div>
                            </button>
                            
                            <button type="button" onclick="alert('Membuka Ruang Kerja Rich Text Editor... \n\n(Catatan: Hak akses Draf sedang dikonfigurasi).')" class="btn w-100" style="background: #faf9f6; color: #1e2318; border: 1px dashed #d8d4c8; padding: 16px; border-radius: 12px; text-align: left; transition: all 0.2s; cursor: pointer;" onmouseover="this.style.borderColor='#2d6a4f'; this.style.background='#e8f5f0'" onmouseout="this.style.borderColor='#d8d4c8'; this.style.background='#faf9f6'">
                                <div style="font-size: 1.4rem; margin-bottom: 8px; color: #2d6a4f;">📝</div>
                                <div style="font-weight: 600; font-size: 0.95rem;">Draft Article Editor</div>
                                <div style="font-size: 0.75rem; color: #9a9988; margin-top: 4px;">Tulis artikel via Rich Text.</div>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="card-modul">
                    <div class="card-body-modul">
                        <h3 style="font-family: 'Cormorant Garamond', serif; font-size: 1.4rem; margin-bottom: 4px; font-weight: 600; color: #1e2318;">Event & Workshop On-Site</h3>
                        <p style="font-size: 0.85rem; color: #6b6b5a; margin-bottom: 20px;">Tracker jadwal dan pemindai kehadiran.</p>
                        
                        <div style="background: #faf9f6; border: 1px solid #e8e5dd; border-radius: 12px; padding: 16px; margin-bottom: 20px;">
                            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px;">
                                <span style="font-weight: 600; font-size: 0.85rem; color: #9a9988; text-transform: uppercase; letter-spacing: 0.05em;">Schedule Tracker</span>
                                <span onclick="alert('Menampilkan Kalender Jadwal Penuh...')" style="font-size: 0.8rem; color: #c9a85c; cursor: pointer; font-weight: 600;">Lihat Kalender &rarr;</span>
                            </div>
                            @forelse($upcomingEvents as $event)
                                <div style="display: flex; gap: 14px; align-items: center; padding: 10px 0; border-bottom: 1px solid #e8e5dd;">
                                    <div style="background: #1e2318; color: white; padding: 8px 12px; border-radius: 8px; text-align: center; min-width: 55px;">
                                        <div style="font-size: 0.7rem; text-transform: uppercase; color: #c9a85c;">{{ \Carbon\Carbon::parse($event->start_datetime)->format('M') }}</div>
                                        <div style="font-size: 1.2rem; font-weight: 600; line-height: 1; margin-top: 2px;">{{ \Carbon\Carbon::parse($event->start_datetime)->format('d') }}</div>
                                    </div>
                                    <div>
                                        <div style="font-weight: 600; font-size: 0.95rem; color: #1e2318;">{{ $event->title }}</div>
                                        <div style="font-size: 0.8rem; color: #6b6b5a; margin-top: 2px;">📍 {{ $event->location ?? 'KalaFabrics Studio' }}</div>
                                    </div>
                                </div>
                            @empty
                                <div style="font-size: 0.9rem; color: #9a9988; padding: 10px 0;">Tidak ada penugasan event dalam waktu dekat.</div>
                            @endforelse
                        </div>

                        <button type="button" onclick="alert('Mengaktifkan Kamera Smartphone untuk Scanning Tiket QR Code...\n\n(Mohon izinkan akses kamera di browser Anda saat modul ini dirilis resmi).')" class="btn w-100" style="background: #2d3a1e; color: white; padding: 16px; border-radius: 10px; font-weight: 600; display: flex; justify-content: center; align-items: center; gap: 10px; transition: 0.2s; border:none;" onmouseover="this.style.background='#1e2318'" onmouseout="this.style.background='#2d3a1e'">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h6v6H4z"/><path d="M14 4h6v6h-6z"/><path d="M4 14h6v6H4z"/><path d="M14 14h6v6h-6z"/></svg>
                            <span>On-Site Ticket Validator (QR)</span>
                        </button>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="card-modul">
                    <div class="card-body-modul">
                        <h3 style="font-family: 'Cormorant Garamond', serif; font-size: 1.4rem; margin-bottom: 4px; font-weight: 600; color: #1e2318;">Bazaar & Field Operations</h3>
                        <p style="font-size: 0.85rem; color: #6b6b5a; margin-bottom: 24px;">Logging aktivitas taktis dan rekonsiliasi stok.</p>
                        
                        <div class="row g-3 h-100">
                            <div class="col-sm-6">
                                <div onclick="alert('Membuka Lembar Ceklis Stok Fisik Bazaar...')" style="border: 1px solid #e8e5dd; border-radius: 12px; padding: 24px; height: 100%; cursor: pointer; transition: all 0.2s;" onmouseover="this.style.borderColor='#2d3a1e'; this.style.background='#faf9f6'" onmouseout="this.style.borderColor='#e8e5dd'; this.style.background='white'">
                                    <div style="font-size: 1.8rem; margin-bottom: 16px;">📦</div>
                                    <div style="font-weight: 600; font-size: 1rem; margin-bottom: 6px; color: #1e2318;">Bazaar Inventory Checklist</div>
                                    <div style="font-size: 0.8rem; color: #6b6b5a; line-height: 1.5;">Rekonsiliasi kuantitas produk pameran.</div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div onclick="alert('Membuka Formulir Pelaporan (Audit Trail) Kendala Taktis Lapangan...')" style="border: 1px solid #e8e5dd; border-radius: 12px; padding: 24px; height: 100%; cursor: pointer; transition: all 0.2s;" onmouseover="this.style.borderColor='#2d3a1e'; this.style.background='#faf9f6'" onmouseout="this.style.borderColor='#e8e5dd'; this.style.background='white'">
                                    <div style="font-size: 1.8rem; margin-bottom: 16px;">📋</div>
                                    <div style="font-weight: 600; font-size: 1rem; margin-bottom: 6px; color: #1e2318;">Field Activity Logger</div>
                                    <div style="font-size: 0.8rem; color: #6b6b5a; line-height: 1.5;">Catat log performa & kendala lapangan.</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="tab-misi" class="r-pane">
        <div class="row g-4 mb-4">
            <div class="col-md-6">
                <div class="stat-card">
                    <div class="stat-val">{{ number_format($totalHours, 1) }}</div>
                    <div style="font-size:14px; color:#6b6b5a; font-weight:500;">Total Jam Terbang</div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="stat-card">
                    <div class="stat-val" style="color:#c9a85c;">{{ $activeMissions->count() }}</div>
                    <div style="font-size:14px; color:#6b6b5a; font-weight:500;">Misi Sedang Berjalan</div>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-lg-6">
                <h3 style="font-family: 'Cormorant Garamond', serif; font-size: 1.6rem; margin-bottom: 16px;">Misi Aktif Anda</h3>
                @forelse($activeMissions as $mission)
                    <div class="task-card">
                        <div style="display:flex; justify-content:space-between; margin-bottom:10px;">
                            <h4 style="margin:0; font-size:16px; font-weight:600;">{{ $mission->task->title }}</h4>
                            <span style="background:#e8eef8; color:#2952a3; padding:4px 10px; border-radius:999px; font-size:11px; font-weight:700;">PROSES</span>
                        </div>
                        <p style="font-size:13px; color:#6b6b5a; margin-bottom:12px;">🕒 {{ \Carbon\Carbon::parse($mission->task->scheduled_datetime)->format('d M Y, H:i') }} | 📍 {{ $mission->task->location }}</p>
                        <form action="{{ route('ranger.tasks.complete', $mission->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-sm" style="background:#2d6a4f; color:white; font-size:12px; font-weight:600; padding:8px 16px; border-radius:6px; border:none; width:100%;">
                                Tandai Selesai & Klaim Poin
                            </button>
                        </form>
                    </div>
                @empty
                    <div style="background:#faf9f6; border:1px dashed #d8d4c8; padding:30px; text-align:center; border-radius:12px; color:#9a9988; font-size:14px;">
                        Anda belum memiliki misi aktif.
                    </div>
                @endforelse
            </div>

            <div class="col-lg-6">
                <h3 style="font-family: 'Cormorant Garamond', serif; font-size: 1.6rem; margin-bottom: 16px;">Misi Tersedia</h3>
                @forelse($availableTasks as $task)
                    <div class="task-card">
                        <div style="display:flex; justify-content:space-between; margin-bottom:10px;">
                            <h4 style="margin:0; font-size:16px; font-weight:600;">{{ $task->title }}</h4>
                            <span style="background:#fdf0dc; color:#8b6914; padding:4px 10px; border-radius:999px; font-size:11px; font-weight:700;">+{{ $task->points_reward }} PTS</span>
                        </div>
                        <p style="font-size:13px; color:#6b6b5a; margin-bottom:12px;">🕒 {{ \Carbon\Carbon::parse($task->scheduled_datetime)->format('d M Y, H:i') }} | 📍 {{ $task->location }}</p>
                        <form action="{{ route('ranger.tasks.take', $task->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-sm" style="background:#2d3a1e; color:white; font-size:12px; font-weight:600; padding:8px 16px; border-radius:6px; border:none; width:100%;">
                                Ambil Misi Ini
                            </button>
                        </form>
                    </div>
                @empty
                    <div style="background:#faf9f6; border:1px dashed #d8d4c8; padding:30px; text-align:center; border-radius:12px; color:#9a9988; font-size:14px;">
                        Belum ada misi baru di lapangan.
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <div id="tab-profil" class="r-pane">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="card-modul w-100">
                    <div class="card-header-modul text-center">
                        <h3 style="font-family: 'Cormorant Garamond', serif; font-size: 1.6rem; margin: 0; font-weight: 600;">Informasi Akun</h3>
                    </div>
                    <div class="card-body-modul">
                        <form action="{{ route('ranger.profile.update') }}" method="POST">
                            @csrf @method('PUT')
                            <div style="margin-bottom:16px;">
                                <label style="font-weight:600; display:block; margin-bottom:8px; font-size:13px; color:#6b6b5a;">Nama Lengkap</label>
                                <input type="text" name="name" value="{{ $user->name }}" style="width:100%; padding:12px; border-radius:8px; border:1px solid #e8e5dd; background:white; font-family:inherit;" required>
                            </div>
                            <div style="margin-bottom:16px;">
                                <label style="font-weight:600; display:block; margin-bottom:8px; font-size:13px; color:#6b6b5a;">Alamat Email</label>
                                <input type="email" name="email" value="{{ $user->email }}" style="width:100%; padding:12px; border-radius:8px; border:1px solid #e8e5dd; background:white; font-family:inherit;" required>
                            </div>
                            <div style="margin-bottom:24px;">
                                <label style="font-weight:600; display:block; margin-bottom:8px; font-size:13px; color:#6b6b5a;">Kata Sandi Baru</label>
                                <input type="password" name="password" placeholder="Kosongkan jika tidak ingin diubah" style="width:100%; padding:12px; border-radius:8px; border:1px solid #e8e5dd; background:white; font-family:inherit;">
                            </div>
                            <button type="submit" class="btn w-100" style="background:#2d3a1e; color:white; padding:12px 24px; border-radius:8px; font-weight:600; border:none; cursor:pointer;">Simpan Perubahan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
    // Fungsi Navigasi Tab
    function switchTab(evt, tabId) {
        let tabs = document.getElementsByClassName("r-tab");
        for (let i = 0; i < tabs.length; i++) { 
            tabs[i].classList.remove("active"); 
        }
        
        let panes = document.getElementsByClassName("r-pane");
        for (let i = 0; i < panes.length; i++) { 
            panes[i].classList.remove("active"); 
        }
        
        evt.currentTarget.classList.add("active");
        document.getElementById(tabId).classList.add("active");
    }
</script>
@endpush