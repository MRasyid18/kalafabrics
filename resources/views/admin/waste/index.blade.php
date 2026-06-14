@extends('layouts.admin')

@section('page-title', 'Manajemen Kurasi Limbah')

@push('styles')
<style>
    /* ── Penyesuaian Tabel Modern ── */
    .admin-table-wrapper {
        background: #ffffff;
        border: 1px solid #e8e5dd;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 4px 20px rgba(30, 35, 24, 0.03);
    }
    .admin-table {
        width: 100%;
        border-collapse: collapse;
    }
    .admin-table th {
        background: #faf9f6;
        padding: 18px 24px;
        font-size: 11px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        color: #9a9988;
        border-bottom: 1px solid #e8e5dd;
        text-align: left;
    }
    .admin-table td {
        padding: 16px 24px;
        font-size: 14px;
        color: #1e2318;
        border-bottom: 1px solid #f0ede6;
        vertical-align: middle;
    }
    .admin-table tbody tr:last-child td { border-bottom: none; }
    .admin-table tbody tr:hover td { background: #faf9f6; }

    /* ── Tipografi Tabel ── */
    .td-title { font-weight: 600; color: #2d3a1e; display: block; margin-bottom: 2px; }
    .td-subtitle { font-size: 12px; color: #9a9988; }
    .tx-id { font-family: monospace; font-size: 13px; font-weight: 600; color: #c9a85c; background: #fcfaf5; padding: 4px 8px; border-radius: 6px; border: 1px dashed #e8e5dd;}

    /* ── Badge Status (Sinkron dengan halaman detail) ── */
    .badge-status { display: inline-flex; align-items: center; padding: 6px 14px; border-radius: 999px; font-size: 11px; font-weight: 600; letter-spacing: 0.04em; }
    .bg-diajukan { background: #fdf0dc; color: #8b6914; border: 1px solid rgba(201,168,92,0.3); }
    .bg-kurasi { background: #e8eef8; color: #2952a3; border: 1px solid rgba(41,82,163,0.2); }
    .bg-penjemputan { background: #f0e8f8; color: #6b29a3; border: 1px solid rgba(107,41,163,0.2); }
    .bg-diterima { background: #e8f5f0; color: #2d6a4f; border: 1px solid rgba(45,106,79,0.2); }
    .bg-selesai { background: #2d6a4f; color: #ffffff; }
    .bg-ditolak { background: #fce8e8; color: #c0392b; border: 1px solid rgba(192,57,43,0.2); }

    .badge-method { font-size: 11px; font-weight: 600; display: inline-flex; align-items: center; gap: 4px; color: #6b6b5a; background: #e8e5dd; padding: 4px 10px; border-radius: 6px; }

    /* ── Tombol Aksi Custom ── */
    .btn-action-kurasi {
        display: inline-flex; align-items: center; gap: 6px; justify-content: center;
        background: #c9a85c; color: #fff;
        padding: 8px 16px; border-radius: 8px;
        font-size: 12px; font-weight: 600;
        transition: all 0.2s ease; border: none; text-decoration: none; min-width: 130px;
    }
    .btn-action-kurasi:hover {
        background: #b5954a; transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(201,168,92,0.3);
    }
    
    .btn-action-detail {
        display: inline-flex; align-items: center; gap: 6px; justify-content: center;
        background: #e8f5f0; color: #2d6a4f;
        padding: 8px 16px; border-radius: 8px;
        font-size: 12px; font-weight: 600;
        transition: all 0.2s ease; border: none; text-decoration: none; min-width: 130px;
    }
    .btn-action-detail:hover { background: #d1eadd; transform: translateY(-2px); }

    .empty-state-row { text-align: center; padding: 60px 20px !important; color: #9a9988; }
</style>
@endpush

@section('content')
<div class="page-header" style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 24px;">
    <div>
        <h1 style="font-family: 'Cormorant Garamond', serif; font-size: 2.2rem; font-weight: 400; color: #1e2318; margin-bottom: 4px;">Daftar Pengajuan Limbah</h1>
        <p style="font-size: 14px; color: #6b6b5a; margin: 0;">Kelola, tinjau, dan setujui penjemputan limbah tekstil dari Mitra B2B.</p>
    </div>
</div>

<div class="admin-table-wrapper">
    <table class="admin-table">
        <thead>
            <tr>
                <th>ID Transaksi</th>
                <th>Mitra (B2B)</th>
                <th>Detail Limbah</th>
                <th>Metode</th>
                <th>Status Pelacakan</th>
                <th style="text-align: center;">Tindakan Admin</th>
            </tr>
        </thead>
        <tbody>
            @forelse($donations as $donation)
            <tr>
                <td>
                    <span class="tx-id">#KALA-{{ str_pad($donation->id, 5, '0', STR_PAD_LEFT) }}</span>
                    <div class="td-subtitle" style="margin-top: 6px;">{{ $donation->created_at->format('d M Y') }}</div>
                </td>
                
                <td>
                    <span class="td-title">{{ $donation->user->name }}</span>
                    <span class="td-subtitle">{{ $donation->user->email }}</span>
                </td>
                
                <td>
                    <span class="td-title" style="color: #1e2318;">{{ $donation->waste_type }}</span>
                    <span class="td-subtitle">{{ $donation->weight }} Kg • {{ $donation->condition }}</span>
                </td>
                
                <td>
                    @if($donation->delivery_method == 'self_delivery')
                        <span class="badge-method"><svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg> Kirim Mandiri</span>
                    @else
                        <span class="badge-method" style="background: #e8f5f0; color: #2d6a4f;"><svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="1" y="3" width="15" height="13"></rect><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"></polygon><circle cx="5.5" cy="18.5" r="2.5"></circle><circle cx="18.5" cy="18.5" r="2.5"></circle></svg> Jemput Ranger</span>
                    @endif
                </td>
                
                <td>
                    @php
                        $statusClass = 'bg-diajukan'; // default
                        if($donation->status == 'kurasi') $statusClass = 'bg-kurasi';
                        if($donation->status == 'penjemputan') $statusClass = 'bg-penjemputan';
                        if($donation->status == 'diterima') $statusClass = 'bg-diterima';
                        if($donation->status == 'selesai') $statusClass = 'bg-selesai';
                        if($donation->status == 'ditolak') $statusClass = 'bg-ditolak';
                    @endphp
                    <span class="badge-status {{ $statusClass }}">
                        {{ strtoupper($donation->status) }}
                    </span>
                </td>
                
                <td style="text-align: center;">
                    @if(in_array($donation->status, ['selesai', 'ditolak']))
                        <a href="{{ route('admin.waste.show', $donation->id) }}" class="btn-action-detail">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                            Lihat Detail
                        </a>
                    @else
                        <a href="{{ route('admin.waste.show', $donation->id) }}" class="btn-action-kurasi">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                            Proses Kurasi
                        </a>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="empty-state-row">
                    <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" style="margin-bottom: 12px; opacity: 0.5;"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><circle cx="8.5" cy="8.5" r="1.5"></circle><polyline points="21 15 16 10 5 21"></polyline></svg>
                    <p style="margin: 0;">Belum ada pengajuan donasi limbah tekstil dari Mitra B2B.</p>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

@if($donations->hasPages())
<div style="margin-top: 24px; display: flex; justify-content: center;">
    {{ $donations->links() }}
</div>
@endif
@endsection