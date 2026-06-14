@extends('layouts.app')
@section('title', 'Keranjang Belanja')

@section('content')
<section style="padding:60px 0">
  <div class="container">
    <div style="margin-bottom:32px">
      <h1>Keranjang Belanja</h1>
      <p style="margin-top:8px">Tinjau pesanan Anda dan lanjutkan ke pembayaran.</p>
    </div>

    <div style="display:grid;grid-template-columns:1.4fr 1fr;gap:40px;align-items:start">

      <div id="cart-items-wrapper">
        
        <div id="dynamic-cart-items"></div>

        <div id="empty-cart" style="display:none;text-align:center;padding:60px 20px">
          <div style="font-size:48px;margin-bottom:16px">🛒</div>
          <h3 style="margin-bottom:8px">Keranjang Anda kosong</h3>
          <p style="margin-bottom:24px">Belum ada produk yang ditambahkan.</p>
          <a href="{{ route('catalog') }}" class="btn btn-primary">Lihat Katalog</a>
        </div>

      </div>

      <div class="order-summary" id="order-summary-box">
        <h3>Ringkasan Pesanan</h3>

        <div class="order-line">
          <span id="subtotal-label">Subtotal (0 produk)</span>
          <span id="subtotal-value">Rp 0</span>
        </div>
        <div class="order-line">
          <span>Estimasi Pengiriman</span>
          <span id="shipping-value">Rp 25.000</span>
        </div>

        <div class="order-total">
          <span>Total Harga</span>
          <span id="total-value">Rp 0</span>
        </div>

        <div class="impact-box">
          <span>♻️</span>
          <span>Dampak Positif: Anda menyelamatkan limbah tekstil dengan pesanan ini.</span>
        </div>

        <a href="{{ route('checkout') }}" class="btn btn-primary btn-block btn-lg" id="btn-checkout" style="margin-bottom:12px">
          Lanjut ke Pembayaran
        </a>
        <a href="{{ route('catalog') }}" class="btn btn-secondary btn-block">← Kembali Belanja</a>
      </div>

    </div>
  </div>
</section>
@endsection

@push('scripts')
<script>
  // Format Rupiah
  function formatRupiah(angka) {
    return 'Rp ' + parseInt(angka).toLocaleString('id-ID');
  }

  // Fungsi untuk memuat data dari Session Storage dan membuat HTML
  function loadCart() {
    // Ambil data dari storage, jika kosong gunakan array kosong
    var cartData = JSON.parse(sessionStorage.getItem('kala_cart')) || [];
    var container = document.getElementById('dynamic-cart-items');
    container.innerHTML = ''; // Bersihkan container

    if (cartData.length > 0) {
      cartData.forEach(function(item, index) {
        var subtotal = item.price * item.qty;
        // Gambar default jika di storage tidak ada gambar
        var imgUrl = item.image || 'https://images.unsplash.com/photo-1544816155-12df9643f363?w=300&q=80'; 
        
        var html = `
          <div class="cart-item" data-index="${index}" data-name="${item.name}" data-price="${item.price}" data-qty="${item.qty}">
            <div class="cart-item-img">
              <img src="${imgUrl}" alt="${item.name}">
            </div>
            <div class="cart-item-body">
              <div class="cart-item-name">${item.name}</div>
              <div style="margin-bottom:14px">
                <span class="badge badge-light-green">♻️ Eco-friendly product</span>
              </div>
              <div class="d-flex align-center justify-between">
                <div class="qty-control">
                  <button class="qty-btn" data-action="minus" data-index="${index}">−</button>
                  <span class="qty-value">${item.qty}</span>
                  <button class="qty-btn" data-action="plus" data-index="${index}">+</button>
                </div>
                <div style="text-align:right">
                  <div class="text-sm text-muted item-unit-price">${formatRupiah(item.price)} / item</div>
                  <div style="font-weight:600" class="item-subtotal">${formatRupiah(subtotal)}</div>
                </div>
              </div>
            </div>
            <button class="cart-remove" title="Hapus" data-index="${index}">×</button>
          </div>
        `;
        container.insertAdjacentHTML('beforeend', html);
      });
    }

    recalcCart();
    attachEventListeners();
  }

  // Hitung total dan update UI/Storage
  function recalcCart() {
    var items = document.querySelectorAll('.cart-item');
    var subtotal = 0;
    var totalQty = 0;
    var cartData = [];

    items.forEach(function(item) {
      var price = parseInt(item.dataset.price) || 0;
      var qty   = parseInt(item.dataset.qty)   || 1;
      var name  = item.dataset.name;
      var imgSrc = item.querySelector('img').src;
      
      subtotal += (price * qty);
      totalQty += qty;

      // Simpan ulang ke array untuk storage
      cartData.push({
        name: name,
        price: price,
        qty: qty,
        image: imgSrc
      });
    });

    var shipping = 25000;
    var total    = subtotal + (totalQty > 0 ? shipping : 0);

    document.getElementById('subtotal-label').textContent  = 'Subtotal (' + totalQty + ' produk)';
    document.getElementById('subtotal-value').textContent  = formatRupiah(subtotal);
    document.getElementById('shipping-value').textContent  = totalQty > 0 ? formatRupiah(shipping) : 'Rp 0';
    document.getElementById('total-value').textContent     = formatRupiah(total);

    // Atur tampilan empty state
    var emptyEl = document.getElementById('empty-cart');
    var summaryEl = document.getElementById('order-summary-box');
    var checkoutBtn = document.getElementById('btn-checkout');
    
    if (totalQty === 0) {
      emptyEl.style.display = 'block';
      summaryEl.style.opacity = '0.4';
      summaryEl.style.pointerEvents = 'none';
    } else {
      emptyEl.style.display  = 'none';
      summaryEl.style.opacity = '1';
      summaryEl.style.pointerEvents = 'auto';
    }

    // Update storage
    sessionStorage.setItem('kala_cart', JSON.stringify(cartData));
    if (typeof updateGlobalCartCount === 'function') {
      updateGlobalCartCount();
    }
    sessionStorage.setItem('kala_shipping', totalQty > 0 ? shipping : 0);
  }

  // Pasang event listener ke tombol-tombol yang baru dibuat
  function attachEventListeners() {
    document.querySelectorAll('.qty-btn').forEach(function(btn) {
      btn.addEventListener('click', function() {
        var item = this.closest('.cart-item');
        var qty  = parseInt(item.dataset.qty) || 1;
        var action = this.dataset.action;

        if (action === 'minus') {
          if (qty > 1) qty--;
        } else {
          qty++;
        }

        item.dataset.qty = qty;
        item.querySelector('.qty-value').textContent = qty;
        
        // Update subtotal per item di UI
        var price = parseInt(item.dataset.price);
        item.querySelector('.item-subtotal').textContent = formatRupiah(price * qty);
        
        recalcCart();
      });
    });

    document.querySelectorAll('.cart-remove').forEach(function(btn) {
      btn.addEventListener('click', function() {
        var item = this.closest('.cart-item');
        item.style.transition = 'opacity .3s ease, transform .3s ease';
        item.style.opacity    = '0';
        item.style.transform  = 'translateX(20px)';
        setTimeout(function() {
          item.remove();
          recalcCart();
        }, 300);
      });
    });
  }

  // Inisialisasi saat halaman pertama kali dibuka
  document.addEventListener('DOMContentLoaded', function() {
    loadCart();
  });
</script>
@endpush