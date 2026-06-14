@extends('layouts.app')
@section('title', 'Riwayat Transaksi & Poin')

@section('content')
<div class="container py-5" style="max-width: 1100px;">
    
    <div class="mb-4">
        <a href="{{ route('b2b.dashboard') }}" style="color: #6b6b5a; text-decoration: none; font-size: 14px; font-weight: 600;">&larr; Kembali ke Dashboard</a>
    </div>

    <div class="row align-items-end mb-4">
        <div class="col-md-8">
            <h1 style="font-family: 'Cormorant Garamond', serif; font-size: clamp(2rem, 5vw, 2.5rem); font-weight: 500; color: #1e2318; margin-bottom: 8px;">
                Buku Poin & Riwayat Validasi
            </h1>
            <p style="color: #6b6b5a; font-size: 1.1rem; margin: 0;">Pantau hasil penyortiran Ranger dan akumulasi Poin Digital perusahaan Anda.</p>
        </div>
        <div class="col-md-4 text-md-end mt-3 mt-md-0">
            <a href="{{ route('b2b.donations.create') }}" class="btn" style="background: #2d3a1e; color: white; padding: 10px 20px; border-radius: 8px; font-weight: 600; font-size: 0.9rem;">
                + Request Penjemputan Baru
            </a>
        </div>
    </div>

    <!-- Ringkasan Saldo -->
    <div class="row g-4 mb-5">
        <div class="col-md-6">
            <div style="background: linear-gradient(135deg, #fdf0dc 0%, #f9e4c1 100%); border: 1px solid #e8d5b5; border-radius: 16px; padding: 28px; height: 100%; position: relative; overflow: hidden;">
                <div style="font-size: 11px; font-weight: 700; color: #8b6914; text-transform: uppercase; letter-spacing: 0.1em; position: relative; z-index: 2;">Total Saldo Poin Anda</div>
                <div style="font-family: 'Cormorant Garamond', serif; font-size: 3rem; font-weight: 600; color: #1e2318; margin: 10px 0; position: relative; z-index: 2;">
                    {{ number_format($currentPoints, 0, ',', '.') }} <span style="font-size: 1.2rem; color: #8b6914; font-weight: 600;">PTS</span>
                </div>
                <div style="font-size: 80px; position: absolute; right: 20px; top: 50%; transform: translateY(-50%); opacity: 0.15; line-height: 1; z-index: 1;">🌟</div>
            </div>
        </div>
        <div class="col-md-6">
            <div style="background: white; border: 1px solid #e8e5dd; border-radius: 16px; padding: 28px; height: 100%; position: relative; overflow: hidden;">
                <div style="font-size: 11px; font-weight: 700; color: #9a9988; text-transform: uppercase; letter-spacing: 0.1em; position: relative; z-index: 2;">Total Limbah Tervalidasi</div>
                <div style="font-family: 'Cormorant Garamond', serif; font-size: 3rem; font-weight: 500; color: #1e2318; margin: 10px 0; position: relative; z-index: 2;">
                    {{ number_format($validatedWeight, 1, ',', '.') }} <span style="font-size: 1.2rem; color: #2d6a4f; font-weight: 600;">KG</span>
                </div>
                <div style="font-size: 80px; position: absolute; right: 20px; top: 50%; transform: translateY(-50%); opacity: 0.05; line-height: 1; z-index: 1;">♻️</div>
            </div>
        </div>
    </div>

    <!-- Tabel Riwayat Lengkap -->
    <h2 style="font-family: 'Cormorant Garamond', serif; font-size: 1.6rem; margin-bottom: 20px;">Detail Transaksi</h2>
    <div class="table-responsive" style="background: white; border: 1px solid #e8e5dd; border-radius: 16px;">
        <table class="table table-hover align-middle mb-0" style="min-width: 900px; white-space: nowrap;">
            <thead style="background: #faf9f6;">
                <tr>
                    <th style="padding: 20px 24px; font-size: 11px; text-transform: uppercase; color: #9a9988; border-bottom: 1px solid #e8e5dd;">ID Transaksi</th>
                    <th style="padding: 20px 24px; font-size: 11px; text-transform: uppercase; color: #9a9988; border-bottom: 1px solid #e8e5dd;">Tgl Pengajuan</th>
                    <th style="padding: 20px 24px; font-size: 11px; text-transform: uppercase; color: #9a9988; border-bottom: 1px solid #e8e5dd;">Jenis Material</th>
                    <th style="padding: 20px 24px; font-size: 11px; text-transform: uppercase; color: #9a9988; border-bottom: 1px solid #e8e5dd;">Berat Aktual</th>
                    <th style="padding: 20px 24px; font-size: 11px; text-transform: uppercase; color: #9a9988; border-bottom: 1px solid #e8e5dd;">Estimasi Poin</th>
                    <th style="padding: 20px 24px; font-size: 11px; text-transform: uppercase; color: #9a9988; border-bottom: 1px solid #e8e5dd;">Status Validasi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($donations as $donation)
                <tr>
                    <td style="padding: 20px 24px; font-family: monospace; font-weight: 600; color: #c9a85c; border-bottom: 1px solid #f0ede6;">
                        #KALA-{{ str_pad($donation->id, 5, '0', STR_PAD_LEFT) }}
                    </td>
                    <td style="padding: 20px 24px; border-bottom: 1px solid #f0ede6; color: #6b6b5a;">
                        {{ $donation->created_at->format('d M Y') }}
                    </td>
                    <td style="padding: 20px 24px; border-bottom: 1px solid #f0ede6; font-weight: 500;">
                        {{ $donation->waste_type }}
                    </td>
                    <td style="padding: 20px 24px; border-bottom: 1px solid #f0ede6;">
                        @if($donation->status === 'selesai')
                            <span style="color: #1e2318; font-weight: 600;">{{ $donation->weight }} Kg</span>
                            <span style="font-size: 11px; color: #2d6a4f; margin-left: 6px;">(Tervalidasi)</span>
                        @else
                            <span style="color: #9a9988;">{{ $donation->weight }} Kg</span>
                            <span style="font-size: 11px; color: #c9a85c; margin-left: 6px;">(Estimasi B2B)</span>
                        @endif
                    </td>
                    <td style="padding: 20px 24px; border-bottom: 1px solid #f0ede6;">
                        @if($donation->status === 'selesai')
                            <!-- Simulasi Poin (Karena grading tidak disimpan ke DB di step sblmnya, kita kalkulasi standar) -->
                            <span style="font-weight: 600; color: #8b6914;">+{{ floor($donation->weight * 50) }} PTS</span>
                        @else
                            <span style="color: #9a9988;">Menunggu...</span>
                        @endif
                    </td>
                    <td style="padding: 20px 24px; border-bottom: 1px solid #f0ede6;">
                        @php
                            $statusMap = [
                                'diajukan' => ['bg' => '#fdf0dc', 'text' => '#8b6914', 'label' => 'Menunggu Ranger'],
                                'kurasi' => ['bg' => '#e8eef8', 'text' => '#2952a3', 'label' => 'Sedang Disortir'],
                                'selesai' => ['bg' => '#e8f5f0', 'text' => '#2d6a4f', 'label' => 'Selesai & Poin Cair']
                            ];
                            $cfg = $statusMap[$donation->status] ?? ['bg' => '#f0ede6', 'text' => '#6b6b5a', 'label' => strtoupper($donation->status)];
                        @endphp
                        <span style="background: {{ $cfg['bg'] }}; color: {{ $cfg['text'] }}; padding: 6px 12px; border-radius: 999px; font-size: 11px; font-weight: 700; display: inline-block;">
                            {{ $cfg['label'] }}
                        </span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-5" style="color: #9a9988;">Belum ada riwayat penyerahan limbah.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection