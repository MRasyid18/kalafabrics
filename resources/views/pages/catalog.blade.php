@extends('layouts.app')
@section('title', 'Katalog Produk')

@section('content')
<section style="padding:60px 0 40px">
  <div class="container">
    <div class="d-flex align-center justify-between" style="margin-bottom:32px">
      <div>
        <h1>Upcycled &amp; Recycled Catalog</h1>
        <p style="margin-top:12px;max-width:480px">Discover our curated collection of sustainable goods, thoughtfully crafted from repurposed textiles to minimise environmental impact without compromising on artisanal quality.</p>
      </div>
      <div>
        <input type="text" class="form-control-box" placeholder="🔍  Search catalog..." style="width:220px">
      </div>
    </div>

    <div class="filter-tabs">
      <button class="filter-tab active">Semua</button>
      <button class="filter-tab">Upcycled Fashion</button>
      <button class="filter-tab">Recycled Craft</button>
      <button class="filter-tab">B2B Products</button>
      <button class="filter-tab">♻️ Tukar dengan Poin</button>
    </div>

    <div class="products-grid">
      @php
          // Menarik data produk langsung dari database
          $dbProducts = \App\Models\Product::where('active', true)->orderBy('created_at', 'desc')->get();
      @endphp

      @forelse($dbProducts as $prod)
        @php
            // Format URL Gambar (menggunakan gambar dari storage atau default jika kosong)
            $imageUrl = $prod->image_path 
                ? asset('storage/' . $prod->image_path) 
                : 'https://images.unsplash.com/photo-1544816155-12df9643f363?w=600&q=80';
        @endphp

        <div class="product-card">
          <div class="product-img">
            <img src="{{ $imageUrl }}" alt="{{ $prod->name }}" style="width:100%; height:250px; object-fit:cover;">
            @if($prod->product_type === 'both' || $prod->product_type === 'b2c')
               <div class="product-clean-badge">✓ Clean Standard</div>
            @endif
          </div>
          <div class="product-body">
            <div class="product-category">{{ strtoupper($prod->product_type) }} Products</div>
            <div class="product-name">{{ $prod->name }}</div>
            <div class="product-price">Rp {{ number_format($prod->price, 0, ',', '.') }}</div>
            <div class="product-save">● Stok: {{ $prod->stock }}</div>
            <div class="product-actions">
              <button class="btn btn-primary btn-block add-to-cart-btn" 
                data-name="{{ $prod->name }}" 
                data-price="{{ $prod->price }}" 
                data-img="{{ $imageUrl }}">
                Tambah ke Keranjang
              </button>
            </div>
          </div>
        </div>
      @empty
        <div style="grid-column: 1 / -1; text-align: center; padding: 40px; color: var(--text-muted);">
            Belum ada produk yang tersedia di katalog.
        </div>
      @endforelse
    </div>

    <div class="pagination">
      <button class="page-btn">&#8592;</button>
      <span class="page-info">1 / 1</span>
      <button class="page-btn">&#8594;</button>
    </div>
  </div>
</section>
@endsection

@push('scripts')
<script>
  document.addEventListener('DOMContentLoaded', function() {
    // Tangkap semua tombol "Tambah ke Keranjang"
    var addToCartButtons = document.querySelectorAll('.add-to-cart-btn');

    addToCartButtons.forEach(function(btn) {
      btn.addEventListener('click', function(e) {
        e.preventDefault();

        // Ambil data produk dari atribut data HTML
        var productName = this.getAttribute('data-name');
        var productPrice = parseInt(this.getAttribute('data-price'));
        var productImg = this.getAttribute('data-img');

        // Ambil keranjang saat ini dari sessionStorage, atau buat array kosong jika belum ada
        var cart = JSON.parse(sessionStorage.getItem('kala_cart')) || [];

        // Cek apakah produk sudah ada di keranjang
        var existingItemIndex = cart.findIndex(function(item) {
          return item.name === productName;
        });

        if (existingItemIndex !== -1) {
          // Jika sudah ada, tambahkan quantity-nya
          cart[existingItemIndex].qty += 1;
        } else {
          // Jika belum ada, masukkan produk baru ke array keranjang
          cart.push({
            name: productName,
            price: productPrice,
            qty: 1,
            image: productImg
          });
        }

        // Simpan kembali array keranjang yang sudah diupdate ke sessionStorage
        sessionStorage.setItem('kala_cart', JSON.stringify(cart));

        // Pindah ke halaman cart
        window.location.href = "{{ route('cart') }}";
      });
    });
  });
</script>
@endpush