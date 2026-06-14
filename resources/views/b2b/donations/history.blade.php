@extends('layouts.app')

@section('content')
<div class="container py-5" style="background-color: #faf8f5; min-height: 85vh; border-radius: 12px;">
    
    <div class="row mb-4 px-3">
        <div class="col-12">
            <div class="mb-3">
                <a href="{{ route('b2b.dashboard') }}" class="text-decoration-none" style="color: #d4af37; font-weight: 600;">
                    <i class="bi bi-arrow-left me-1"></i> Kembali ke Dashboard
                </a>
            </div>
            <h2 style="font-weight: 700; color: #2c2c2c;">Log Riwayat <span style="color: #d4af37;">Transaksi Limbah</span></h2>
            <p class="text-muted">Kumpulan arsip seluruh pengajuan distribusi pembuangan limbah tekstil ramah lingkungan milik instansi Anda.</p>
        </div>
    </div>

    <div class="row px-3">
        <div class="col-12">
            <div class="card border-0 shadow-sm" style="border-radius: 10px; overflow: hidden; background-color: #ffffff;">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light" style="font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.5px;">
                                <tr>
                                    <th class="py-3 px-4">ID Transaksi</th>
                                    <th class="py-3">Tanggal Input</th>
                                    <th class="py-3">Jadwal Jemput</th>
                                    <th class="py-3">Jenis Kain</th>
                                    <th class="py-3">Tonase Bersih</th>
                                    <th class="py-3 text-center">Status Pelacakan</th>
                                </tr>
                            </thead>
                            <tbody style="font-size: 0.9rem; color: #4a4a4a;">
                                @forelse($donations as $donation)
                                <tr>
                                    <td class="py-3 px-4 text-muted font-monospace">
                                        <!-- Ini adalah Link menuju Pelacakan (Tracking) -->
                                        <a href="{{ route('b2b.donations.track', $donation->id) }}" style="color: #c9a85c; text-decoration: none; font-weight: 600;">
                                            #KALA-{{ str_pad($donation->id, 5, '0', STR_PAD_LEFT) }}
                                        </a>
                                    </td>
                                    <td class="py-3">{{ $donation->created_at->format('d/m/Y') }}</td>
                                    <td class="py-3"><strong>{{ \Carbon\Carbon::parse($donation->pickup_date)->format('d M Y') }}</strong></td>
                                    <td class="py-3">{{ $donation->waste_type }}</td>
                                    <td class="py-3">{{ $donation->weight }} Kg</td>
                                    <td class="py-3 text-center">
                                        @if($donation->status == 'diajukan') <span class="badge" style="background: #fdf0dc; color: #8b6914;">Baru Diajukan</span>
                                        @elseif($donation->status == 'kurasi') <span class="badge" style="background: #e8eef8; color: #2952a3;">Kurasi</span>
                                        @elseif($donation->status == 'diterima') <span class="badge" style="background: #e8f5f0; color: #2d6a4f;">Tiba di Gudang</span>
                                        @elseif($donation->status == 'selesai') <span class="badge bg-success">Selesai</span>
                                        @elseif($donation->status == 'ditolak') <span class="badge bg-danger">Ditolak</span>
                                        @else <span class="badge bg-secondary">{{ ucfirst($donation->status) }}</span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted py-5">
                                        Belum menemukan rekaman riwayat transaksi apapun.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                @if($donations->hasPages())
                    <div class="card-footer bg-white border-0 pt-3 pb-4 px-4 d-flex justify-content-center">
                        {{ $donations->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection