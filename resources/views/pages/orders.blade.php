@extends('layouts.app')
@section('title', 'Pesanan Saya')

@section('content')
<section style="padding:60px 0; min-height:60vh;">
  <div class="container" style="max-width:800px; margin:0 auto;">
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:24px;">
        <h2>Riwayat Pesanan Saya</h2>
        <a href="{{ route('catalog') }}" style="color:var(--primary); font-weight:600;">← Lanjut Belanja</a>
    </div>

    @forelse($orders as $order)
      <div style="background:white; border:1px solid #d8d4c8; border-radius:12px; padding:20px; margin-bottom:16px;">
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:12px;">
            <div style="font-weight:600; font-size:16px;">Order #ORD-{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</div>
            <div>
                @if($order->status == 'pending')
                    <span style="background:#fdf0dc; color:#8b6914; padding:4px 12px; border-radius:999px; font-size:12px; font-weight:600;">⌛ Menunggu Verifikasi</span>
                @elseif($order->status == 'processing')
                    <span style="background:#e8f5f0; color:#2d6a4f; padding:4px 12px; border-radius:999px; font-size:12px; font-weight:600;">✅ Sedang Diproses</span>
                @elseif($order->status == 'cancelled')
                    <span style="background:#fdf0ee; color:#c0392b; padding:4px 12px; border-radius:999px; font-size:12px; font-weight:600;">❌ Dibatalkan (Ditolak)</span>
                @else
                    <span style="background:#e8eef8; color:#1e3a8a; padding:4px 12px; border-radius:999px; font-size:12px; font-weight:600;">{{ ucfirst($order->status) }}</span>
                @endif
            </div>
        </div>
        <div style="font-size:14px; color:#6b6b5a; margin-bottom:8px;">Tanggal: {{ $order->created_at->format('d M Y, H:i') }}</div>
        <div style="font-size:14px; font-weight:600;">Total Belanja: Rp {{ number_format($order->total_amount, 0, ',', '.') }}</div>
      </div>
    @empty
      <div style="text-align:center; padding:40px; color:#9a9988; background:white; border-radius:12px; border:1px dashed #d8d4c8;">
        Belum ada pesanan yang dibuat.
      </div>
    @endforelse
  </div>
</section>
@endsection