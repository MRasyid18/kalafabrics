@extends('layouts.app')

@section('content')
<div class="container py-5" style="background-color: #faf8f5; min-height: 85vh; border-radius: 12px;">
    <div class="row align-items-center mb-5 px-3">
        <div class="col-md-8">
            <h1 class="display-6" style="color: #2c2c2c; font-weight: 700; letter-spacing: -0.5px;">
                Mitra <span style="color: #d4af37;">B2B Dashboard</span>
            </h1>
            <p class="text-muted mb-0">Selamat datang kembali, <strong>{{ $user->name }}</strong>. Pantau kontribusi limbah tekstil dan saldo poin digital perusahaan Anda.</p>
        </div>
        <div class="col-md-4 text-md-end mt-3 mt-md-0">
            <a href="{{ route('b2b.donations.create') }}" class="btn btn-lg shadow-sm" style="background-color: #d4af37; color: #fff; font-weight: 600; border-radius: 8px; border: none; font-size: 0.95rem; transition: all 0.3s;">
                <i class="bi bi-plus-circle me-2"></i> Ajukan Penjemputan Limbah
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success mx-3 border-0 shadow-sm" style="background-color: #e8f5e9; color: #2e7d32; border-radius: 8px;">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
        </div>
    @endif

    <div class="row g-4 mb-5 px-3">
        <div class="col-md-4">
            <div class="card h-100 border-0 shadow-sm" style="background-color: #ffffff; border-left: 5px solid #d4af37 !important; border-radius: 10px;">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="text-muted text-uppercase small tracking-wider" style="font-weight: 600;">Saldo Poin Digital</span>
                        <div class="p-2 bg-light rounded-circle text-warning"><i class="bi bi-wallet2 fs-5"></i></div>
                    </div>
                    <h2 class="mb-1" style="color: #2c2c2c; font-weight: 800;">{{ number_format($currentPoints, 0, ',', '.') }}</h2>
                    <p class="text-muted small mb-0">Poin siap dikonversi untuk potongan produk daur ulang.</p>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card h-100 border-0 shadow-sm" style="background-color: #ffffff; border-left: 5px solid #2c2c2c !important; border-radius: 10px;">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="text-muted text-uppercase small tracking-wider" style="font-weight: 600;">Total Kontribusi</span>
                        <div class="p-2 bg-light rounded-circle text-success"><i class="bi bi-recycle fs-5"></i></div>
                    </div>
                    <h2 class="mb-1" style="color: #2c2c2c; font-weight: 800;">{{ number_format($totalWeight, 1, ',', '.') }} <span style="font-size: 1.2rem; font-weight: 500;">Kg</span></h2>
                    <p class="text-muted small mb-0">Jumlah limbah kain yang berhasil tervalidasi masuk sistem.</p>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card h-100 border-0 shadow-sm" style="background-color: #ffffff; border-left: 5px solid #f39c12 !important; border-radius: 10px;">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="text-muted text-uppercase small tracking-wider" style="font-weight: 600;">Jadwal Menunggu</span>
                        <div class="p-2 bg-light rounded-circle text-info"><i class="bi bi-truck fs-5"></i></div>
                    </div>
                    <h2 class="mb-1" style="color: #2c2c2c; font-weight: 800;">{{ $pendingPickups }} <span style="font-size: 1.2rem; font-weight: 500;">Request</span></h2>
                    <p class="text-muted small mb-0">Permintaan penjemputan lapangan sedang diproses tim Ranger.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row px-3">
        <div class="col-12">
            <div class="card border-0 shadow-sm style-card" style="border-radius: 10px; overflow: hidden; background-color: #ffffff;">
                <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center pt-4 px-4">
                    <h5 class="mb-0" style="font-weight: 700; color: #2c2c2c;"><i class="bi bi-clock-history me-2 text-muted"></i> Aktivitas Penyerahan Terakhir</h5>
                    <a href="{{ route('b2b.donations.history') }}" style="color: #d4af37; text-decoration: none; font-weight: 600; font-size: 0.9rem;">Lihat Semua Riwayat &rarr;</a>
                </div>
                <div class="card-body px-4 pb-4">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light" style="font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.5px;">
                                <tr>
                                    <th class="py-3 px-3">Tanggal Pengajuan</th>
                                    <th class="py-3">Rencana Penjemputan</th>
                                    <th class="py-3">Jenis Limbah</th>
                                    <th class="py-3">Estimasi Berat</th>
                                    <th class="py-3 text-center">Status Transaksi</th>
                                </tr>
                            </thead>
                            <tbody style="font-size: 0.95rem; color: #4a4a4a;">
                                @forelse($recentDonations as $donation)
                                <tr>
                                    <td class="py-3 px-3 text-muted">{{ $donation->created_at->format('d M Y') }}</td>
                                    <td class="py-3"><strong>{{ \Carbon\Carbon::parse($donation->pickup_date)->format('d M Y') }}</strong></td>
                                    <td class="py-3">{{ $donation->waste_type }}</td>
                                    <td class="py-3">{{ $donation->weight }} Kg</td>
                                    <td class="py-3 text-center">
                                        @if($donation->status == 'pending')
                                            <span class="badge px-3 py-2" style="background-color: #fff3cd; color: #856404; font-weight: 600; border-radius: 20px;">Menunggu Ranger</span>
                                        @elseif($donation->status == 'validated')
                                            <span class="badge px-3 py-2" style="background-color: #d4edda; color: #155724; font-weight: 600; border-radius: 20px;">Sukses Tervalidasi</span>
                                        @else
                                            <span class="badge px-3 py-2 bg-light text-dark" style="font-weight: 600; border-radius: 20px;">{{ ucfirst($donation->status) }}</span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-5">
                                        <i class="bi bi-inbox fs-2 mb-2 d-block text-muted"></i>
                                        Belum ada riwayat penyerahan limbah tekstil dari instansi/perusahaan Anda.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection