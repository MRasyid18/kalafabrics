@extends('layouts.admin')
@section('title', 'Manajemen Pesanan')
@section('page-title', 'Pesanan')

@section('content')
<div class="page-header">
    <h1>Manajemen Pesanan</h1>
    <p>Pantau dan perbarui status pesanan pelanggan.</p>
</div>

<div class="card">
    <div class="card-body">
        <table>
            <thead>
                <tr>
                    <th>ID Pesanan</th>
                    <th>Pelanggan</th>
                    <th>Total Harga</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                <tr>
                    <td style="font-weight:600; color:#2d3a1e;">#ORD-{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</td>
                    <td>
                        <div>{{ $order->user->name ?? 'User Dihapus' }}</div>
                        <div style="font-size:12px; color:#9a9988;">{{ $order->created_at->format('d M Y, H:i') }}</div>
                    </td>
                    <td style="font-weight:500;">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                    <td>
                        <form action="{{ route('admin.orders.update', $order->id) }}" method="POST" style="display:flex; gap:8px;">
                            @csrf @method('PUT')
                            <select name="status" style="padding:4px 8px; border:1px solid #d8d4c8; border-radius:6px; font-size:13px; background:#faf9f6;">
                                <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Diproses</option>
                                <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>Dikirim</option>
                                <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Selesai</option>
                                <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                            </select>
                            <button type="submit" style="background:#2d3a1e; color:white; padding:4px 10px; border-radius:6px; font-size:12px;">Update</button>
                        </form>
                    </td>
                    <td><a href="#" style="color:#c9a85c; font-weight:600; font-size:13px;">Lihat Detail</a></td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="empty-state">Belum ada pesanan yang masuk.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<div style="margin-top: 20px;">
    {{ $orders->links('pagination::bootstrap-4') }}
</div>
@endsection