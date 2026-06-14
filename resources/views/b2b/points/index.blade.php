@extends('layouts.app')

@section('content')
<div class="container py-5" style="background-color: #faf8f5; min-height: 85vh; border-radius: 12px;">
    
    <div class="row align-items-center mb-5 px-3">
        <div class="col-md-8">
            <h1 class="display-6" style="color: #2c2c2c; font-weight: 700; letter-spacing: -0.5px;">
                Buku Besar <span style="color: #d4af37;">Poin Digital</span>
            </h1>
            <p class="text-muted mb-0">Tukar poin yang dikumpulkan dari limbah Anda dengan potongan grosir atau sertifikat hijau.</p>
        </div>
    </div>

    <div class="row px-3 g-4">
        
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm mb-4 text-white" style="background: linear-gradient(135deg, #2c2c2c 0%, #1a1a1a 100%); border-radius: 12px;">
                <div class="card-body p-4 text-center">
                    <h6 class="text-uppercase text-muted tracking-wider mb-3" style="font-size: 0.8rem;">Total Saldo Poin Aktif</h6>
                    <h1 class="display-4 mb-0" style="color: #d4af37; font-weight: 800;">
                        {{ number_format($currentPoints, 0, ',', '.') }}
                    </h1>
                    <p class="small text-light mt-2 opacity-75">1 Poin ≈ Rp100</p>
                </div>
            </div>

            <div class="card border-0 shadow-sm" style="border-radius: 12px;">
                <div class="card-header bg-white border-0 pt-4 px-4 pb-0">
                    <h5 style="font-weight: 700; color: #2c2c2c;">Reward Marketplace</h5>
                </div>
                <div class="card-body px-4 pb-4">
                    <div class="d-flex align-items-center justify-content-between border-bottom pb-3 mb-3">
                        <div>
                            <h6 class="mb-1" style="font-weight: 600;">Voucer Diskon Grosir 10%</h6>
                            <small class="text-muted">Potongan untuk Bulk Order</small>
                        </div>
                        <button class="btn btn-sm btn-outline-dark" style="border-radius: 6px;">500 Pts</button>
                    </div>
                    <div class="d-flex align-items-center justify-content-between border-bottom pb-3 mb-3">
                        <div>
                            <h6 class="mb-1" style="font-weight: 600;">Eksposur Logo di Web</h6>
                            <small class="text-muted">Logo masuk ke daftar Mitra Kami</small>
                        </div>
                        <button class="btn btn-sm btn-outline-dark" style="border-radius: 6px;">1500 Pts</button>
                    </div>
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <h6 class="mb-1" style="font-weight: 600;">Green Report Lengkap</h6>
                            <small class="text-muted">Untuk Laporan ESG Tahunan</small>
                        </div>
                        <button class="btn btn-sm" style="background-color: #d4af37; color: white; border-radius: 6px;">2500 Pts</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 12px; background-color: #ffffff;">
                <div class="card-header bg-white border-0 pt-4 px-4 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0" style="font-weight: 700; color: #2c2c2c;">Log Riwayat Masuk</h5>
                </div>
                <div class="card-body px-4">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light" style="font-size: 0.85rem; text-transform: uppercase;">
                                <tr>
                                    <th class="py-3 px-3">Tanggal Verifikasi</th>
                                    <th class="py-3">Sumber / ID Donasi</th>
                                    <th class="py-3">Berat Tervalidasi</th>
                                    <th class="py-3 text-end">Poin Diperoleh</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($pointHistory as $log)
                                <tr>
                                    <td class="py-3 px-3 text-muted">{{ $log->updated_at->format('d M Y, H:i') }}</td>
                                    <td class="py-3">
                                        <strong>Setor Limbah</strong><br>
                                        <small class="text-muted font-monospace">#KALA-{{ str_pad($log->id, 5, '0', STR_PAD_LEFT) }}</small>
                                    </td>
                                    <td class="py-3">{{ $log->weight }} Kg</td>
                                    <td class="py-3 text-end font-monospace" style="color: #198754; font-weight: 700;">+{{ floor($log->weight * 10) }} Pts</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted py-5">
                                        <i class="bi bi-receipt fs-2 mb-2 d-block text-muted"></i>
                                        Belum ada riwayat penambahan poin. Setorkan limbah Anda untuk mulai mengumpulkan poin!
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    @if($pointHistory->hasPages())
                        <div class="mt-3 d-flex justify-content-center">
                            {{ $pointHistory->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>

    </div>
</div>
@endsection