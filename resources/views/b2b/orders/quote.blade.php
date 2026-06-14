@extends('layouts.app')

@section('content')
<div class="container py-5" style="max-width: 800px;">
    <div class="mb-4">
        <a href="{{ route('b2b.dashboard') }}" class="text-decoration-none" style="color: #9a9988;">&larr; Kembali ke Dashboard</a>
    </div>

    <div class="card border-0 shadow-sm" style="border-radius: 16px; padding: 40px; background: #ffffff;">
        <h2 style="font-family: 'Cormorant Garamond', serif; font-size: 2rem; margin-bottom: 8px;">Request for Quote (RFQ)</h2>
        <p style="color: #6b6b5a; margin-bottom: 32px;">Ajukan penawaran harga khusus untuk pesanan grosir (B2B) dan kustomisasi produk Anda.</p>

        @if(session('success'))
            <div class="alert alert-success border-0" style="background: #e8f5f0; color: #2d6a4f; border-radius: 8px;">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('b2b.quote.submit') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="mb-4">
                <label class="form-label fw-bold">Nama Produk</label>
                <input type="text" name="product_name" class="form-control p-3" placeholder="Misal: Fabric Cotton Organic A1" required>
            </div>

            <div class="mb-4">
                <label class="form-label fw-bold">Kuantitas (Min. 10 Unit)</label>
                <input type="number" name="quantity" class="form-control p-3" min="10" placeholder="Contoh: 50" required>
            </div>

            <div class="mb-4">
                <label class="form-label fw-bold">Detail Kustomisasi</label>
                <textarea name="customization_details" class="form-control p-3" rows="3" placeholder="Jelaskan kebutuhan kustomisasi Anda, seperti penempatan logo atau warna khusus..."></textarea>
            </div>

            <div class="mb-4">
                <label class="form-label fw-bold">Upload Logo (Opsional)</label>
                <input type="file" name="logo" class="form-control p-3">
                <small class="text-muted">Format: PNG, SVG, atau JPG (Maks 2MB).</small>
            </div>

            <button type="submit" class="btn btn-dark w-100 p-3" style="border-radius: 8px; font-weight: 600;">
                Kirim Permintaan Penawaran
            </button>
        </form>
    </div>
</div>
@endsection