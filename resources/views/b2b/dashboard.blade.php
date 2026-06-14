@extends('layouts.app')

@section('content')
<div class="container py-5" style="max-width: 1100px;">
    
    <div class="row align-items-end mb-5">
        <div class="col-md-8">
            <h1 style="font-family: 'Cormorant Garamond', serif; font-size: 2.8rem; font-weight: 500; color: #1e2318; margin-bottom: 8px;">
                Dashboard Mitra
            </h1>
            <p style="color: #6b6b5a; font-size: 1.1rem;">Selamat datang, <strong>{{ $user->name }}</strong>. Pantau performa keberlanjutan perusahaan Anda.</p>
        </div>
        <div class="col-md-4 text-md-end mt-4 mt-md-0">
            <a href="{{ route('b2b.donations.create') }}" class="btn" style="background: #2d3a1e; color: white; padding: 12px 24px; border-radius: 8px; font-weight: 600; font-size: 0.95rem;">
                + Ajukan Penjemputan
            </a>
        </div>
    </div>

    <div class="row g-4 mb-5">
        @foreach([
            ['label' => 'Saldo Poin Digital', 'value' => number_format($currentPoints, 0, ',', '.'), 'unit' => 'PTS', 'color' => '#c9a85c'],
            ['label' => 'Total Limbah (Kg)', 'value' => number_format($totalWeight, 1, ',', '.'), 'unit' => 'KG', 'color' => '#2d6a4f'],
            ['label' => 'Request Aktif', 'value' => $pendingPickups, 'unit' => 'REQ', 'color' => '#6b29a3']
        ] as $stat)
        <div class="col-md-4">
            <div style="background: white; border: 1px solid #e8e5dd; border-radius: 16px; padding: 28px; height: 100%;">
                <div style="font-size: 11px; font-weight: 700; color: #9a9988; text-transform: uppercase; letter-spacing: 0.1em;">{{ $stat['label'] }}</div>
                <div style="font-family: 'Cormorant Garamond', serif; font-size: 2.8rem; font-weight: 500; color: #1e2318; margin: 10px 0;">
                    {{ $stat['value'] }} <span style="font-size: 1.1rem; color: {{ $stat['color'] }}; font-weight: 600;">{{ $stat['unit'] }}</span>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <div style="margin-bottom: 20px; display: flex; justify-content: space-between; align-items: baseline;">
        <h2 style="font-family: 'Cormorant Garamond', serif; font-size: 1.8rem; margin: 0;">Aktivitas Terakhir</h2>
        <a href="{{ route('b2b.donations.history') }}" style="color: #c9a85c; text-decoration: none; font-weight: 600; font-size: 0.9rem;">Lihat Semua &rarr;</a>
    </div>

    <div style="background: white; border: 1px solid #e8e5dd; border-radius: 16px; overflow: hidden;">
        <table class="table table-hover align-middle mb-0">
            <thead style="background: #faf9f6;">
                <tr>
                    <th style="padding: 20px 24px; font-size: 11px; text-transform: uppercase; color: #9a9988; border: none;">ID Transaksi</th>
                    <th style="padding: 20px 24px; font-size: 11px; text-transform: uppercase; color: #9a9988; border: none;">Tanggal</th>
                    <th style="padding: 20px 24px; font-size: 11px; text-transform: uppercase; color: #9a9988; border: none;">Jenis Limbah</th>
                    <th style="padding: 20px 24px; font-size: 11px; text-transform: uppercase; color: #9a9988; border: none;">Berat</th>
                    <th style="padding: 20px 24px; font-size: 11px; text-transform: uppercase; color: #9a9988; border: none;">Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentDonations as $donation)
                <tr>
                    <td style="padding: 20px 24px; font-family: monospace; font-weight: 600; color: #c9a85c;">#KALA-{{ str_pad($donation->id, 5, '0', STR_PAD_LEFT) }}</td>
                    <td style="padding: 20px 24px;">{{ $donation->created_at->format('d M Y') }}</td>
                    <td style="padding: 20px 24px; font-weight: 500;">{{ $donation->waste_type }}</td>
                    <td style="padding: 20px 24px;">{{ $donation->weight }} Kg</td>
                    <td style="padding: 20px 24px;">
                        @php
                            $statusMap = [
                                'diajukan' => ['bg' => '#fdf0dc', 'text' => '#8b6914'],
                                'kurasi' => ['bg' => '#e8eef8', 'text' => '#2952a3'],
                                'selesai' => ['bg' => '#e8f5f0', 'text' => '#2d6a4f']
                            ];
                            $cfg = $statusMap[$donation->status] ?? ['bg' => '#f0ede6', 'text' => '#6b6b5a'];
                        @endphp
                        <span style="background: {{ $cfg['bg'] }}; color: {{ $cfg['text'] }}; padding: 6px 12px; border-radius: 999px; font-size: 11px; font-weight: 700;">
                            {{ strtoupper($donation->status) }}
                        </span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center py-5" style="color: #9a9988;">Belum ada riwayat penyerahan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection