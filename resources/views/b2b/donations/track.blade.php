@extends('layouts.app')

@section('content')
<div class="container py-5" style="background-color: #faf8f5; min-height: 85vh; border-radius: 12px;">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            
            <div class="mb-4">
                <a href="{{ route('b2b.donations.history') }}" class="text-decoration-none" style="color: #d4af37; font-weight: 600;">
                    <i class="bi bi-arrow-left me-1"></i> Kembali ke Riwayat
                </a>
            </div>

            <div class="card border-0 shadow-sm mb-4" style="border-radius: 12px; background-color: #ffffff;">
                <div class="card-body p-4 p-md-5">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <h3 style="font-weight: 700; color: #2c2c2c;">Pelacakan <span style="color: #d4af37;">Limbah</span></h3>
                            <p class="text-muted mb-0">ID Transaksi: <strong class="font-monospace">#KALA-{{ str_pad($donation->id, 5, '0', STR_PAD_LEFT) }}</strong></p>
                        </div>
                        <div class="text-end">
                            <span class="badge bg-light text-dark border p-2" style="font-size: 0.9rem;">{{ $donation->weight }} Kg • {{ $donation->waste_type }}</span>
                        </div>
                    </div>
                    
                    <hr class="mb-5">

                    @php
                        $statuses = ['diajukan', 'kurasi', 'penjemputan', 'diterima', 'selesai'];
                        $currentIndex = array_search($donation->status, $statuses);
                        if ($currentIndex === false && $donation->status != 'ditolak') $currentIndex = 0;
                    @endphp

                    @if($donation->status == 'ditolak')
                        <div class="alert alert-danger text-center p-4" style="border-radius: 10px;">
                            <i class="bi bi-x-circle fs-1 mb-2 d-block"></i>
                            <h5 class="mb-1">Pengajuan Limbah Ditolak</h5>
                            <p class="mb-0 small">Mohon maaf, jenis atau kondisi limbah belum memenuhi standar kurasi KalaFabrics saat ini.</p>
                        </div>
                    @else
                        <div class="position-relative m-4">
                            <div class="progress" style="height: 4px; background-color: #f1f1f1;">
                                <div class="progress-bar" role="progressbar" style="width: {{ ($currentIndex / 4) * 100 }}%; background-color: #d4af37;"></div>
                            </div>
                            
                            <div class="d-flex justify-content-between mt-3 position-absolute w-100" style="top: -20px;">
                                <div class="text-center" style="width: 20%;">
                                    <div class="rounded-circle d-inline-flex align-items-center justify-content-center text-white mb-2" style="width: 35px; height: 35px; background-color: {{ $currentIndex >= 0 ? '#d4af37' : '#e9ecef' }};">
                                        <i class="bi bi-file-earmark-text"></i>
                                    </div>
                                    <div class="small fw-bold" style="color: {{ $currentIndex >= 0 ? '#2c2c2c' : '#adb5bd' }};">Diajukan</div>
                                </div>
                                <div class="text-center" style="width: 20%;">
                                    <div class="rounded-circle d-inline-flex align-items-center justify-content-center text-white mb-2" style="width: 35px; height: 35px; background-color: {{ $currentIndex >= 1 ? '#d4af37' : '#e9ecef' }};">
                                        <i class="bi bi-search"></i>
                                    </div>
                                    <div class="small fw-bold" style="color: {{ $currentIndex >= 1 ? '#2c2c2c' : '#adb5bd' }};">Kurasi Admin</div>
                                </div>
                                <div class="text-center" style="width: 20%;">
                                    <div class="rounded-circle d-inline-flex align-items-center justify-content-center text-white mb-2" style="width: 35px; height: 35px; background-color: {{ $currentIndex >= 2 ? '#d4af37' : '#e9ecef' }};">
                                        <i class="bi bi-truck"></i>
                                    </div>
                                    <div class="small fw-bold" style="color: {{ $currentIndex >= 2 ? '#2c2c2c' : '#adb5bd' }};">Penjemputan</div>
                                </div>
                                <div class="text-center" style="width: 20%;">
                                    <div class="rounded-circle d-inline-flex align-items-center justify-content-center text-white mb-2" style="width: 35px; height: 35px; background-color: {{ $currentIndex >= 3 ? '#d4af37' : '#e9ecef' }};">
                                        <i class="bi bi-box-seam"></i>
                                    </div>
                                    <div class="small fw-bold" style="color: {{ $currentIndex >= 3 ? '#2c2c2c' : '#adb5bd' }};">Tiba di Gudang</div>
                                </div>
                                <div class="text-center" style="width: 20%;">
                                    <div class="rounded-circle d-inline-flex align-items-center justify-content-center text-white mb-2" style="width: 35px; height: 35px; background-color: {{ $currentIndex >= 4 ? '#198754' : '#e9ecef' }};">
                                        <i class="bi bi-check2-all"></i>
                                    </div>
                                    <div class="small fw-bold" style="color: {{ $currentIndex >= 4 ? '#198754' : '#adb5bd' }};">Poin Cair</div>
                                </div>
                            </div>
                        </div>
                        <div class="mt-5 pt-4 text-center text-muted small">
                            Status saat ini: <strong>{{ strtoupper($donation->status) }}</strong>. Proses verifikasi poin bergantung pada penimbangan akurat di gudang kami.
                        </div>
                    @endif

                </div>
            </div>

        </div>
    </div>
</div>
@endsection