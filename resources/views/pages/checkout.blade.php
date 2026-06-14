@extends('layouts.app')
@section('title', 'Pembayaran')

@section('content')
<section style="padding:60px 0">
  <div class="container" style="max-width:600px; margin:0 auto;">
    <h2>Informasi Pengiriman</h2>
    <p>Silakan lengkapi data di bawah ini untuk melanjutkan pesanan via WhatsApp.</p>

    <form id="checkoutForm" style="margin-top:24px; background:white; padding:30px; border-radius:12px; border:1px solid #d8d4c8;">
        <div class="form-group" style="margin-bottom:16px;">
            <label style="font-weight:600; font-size:14px; display:block; margin-bottom:8px;">Nama Lengkap</label>
            <input type="text" id="buyer-name" class="form-control-box" style="width:100%; padding:10px; border-radius:8px; border:1px solid #ccc;" value="{{ auth()->user()->name }}" required>
        </div>
        <div class="form-group" style="margin-bottom:16px;">
            <label style="font-weight:600; font-size:14px; display:block; margin-bottom:8px;">Nomor WhatsApp</label>
            <input type="text" id="buyer-phone" class="form-control-box" style="width:100%; padding:10px; border-radius:8px; border:1px solid #ccc;" placeholder="0812..." required>
        </div>
        <div class="form-group" style="margin-bottom:24px;">
            <label style="font-weight:600; font-size:14px; display:block; margin-bottom:8px;">Alamat Pengiriman</label>
            <textarea id="buyer-address" class="form-control-box" style="width:100%; height:80px; padding:10px; border-radius:8px; border:1px solid #ccc;" required></textarea>
        </div>

        <div style="background:#faf9f6; padding:16px; border-radius:8px; margin-bottom:24px;">
            <div style="display:flex; justify-content:space-between; font-weight:600; font-size:16px;">
                <span>Total Tagihan (+Ongkir):</span>
                <span id="display-total">Rp 0</span>
            </div>
        </div>

        <button type="submit" id="btn-submit" class="btn btn-primary btn-block" style="font-size:16px; padding:12px;">
            Buat Pesanan via WhatsApp
        </button>
    </form>
  </div>
</section>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        let cart = JSON.parse(sessionStorage.getItem('kala_cart')) || [];
        let shipping = parseInt(sessionStorage.getItem('kala_shipping')) || 0;
        
        if(cart.length === 0) {
            alert('Keranjang belanja Anda kosong!');
            window.location.href = "{{ route('catalog') }}";
            return;
        }

        let subtotal = 0;
        cart.forEach(item => subtotal += (item.price * item.qty));
        let totalAmount = subtotal + shipping;

        document.getElementById('display-total').textContent = 'Rp ' + totalAmount.toLocaleString('id-ID');

        document.getElementById('checkoutForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            let btn = document.getElementById('btn-submit');
            btn.textContent = 'Memproses...';
            btn.disabled = true;

            let name = document.getElementById('buyer-name').value;
            let phone = document.getElementById('buyer-phone').value;
            let address = document.getElementById('buyer-address').value;

            // 1. Simpan ke Database
            fetch("{{ route('checkout.store') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    shipping_address: address,
                    phone: phone,
                    items: cart,
                    total_amount: totalAmount
                })
            })
            .then(res => res.json())
            .then(data => {
                if(data.success) {
                    // 2. Kosongkan keranjang
                    sessionStorage.removeItem('kala_cart');
                    sessionStorage.removeItem('kala_shipping');

                    // 3. Arahkan ke WhatsApp Admin
                    let adminWa = '6281234567890'; // GANTI DENGAN NOMOR WA ADMIN
                    let text = `Halo Admin KalaFabrics! Saya ingin mengonfirmasi pesanan saya:\n\n`;
                    text += `*ID Pesanan:* #ORD-${data.order_id}\n`;
                    text += `*Nama:* ${name}\n`;
                    text += `*Total Pembayaran:* Rp ${totalAmount.toLocaleString('id-ID')}\n\n`;
                    text += `Mohon info rekening untuk pembayaran.`;
                    
                    window.location.href = `https://wa.me/${adminWa}?text=${encodeURIComponent(text)}`;
                } else {
                    alert('Terjadi kesalahan saat membuat pesanan.');
                    btn.textContent = 'Buat Pesanan via WhatsApp';
                    btn.disabled = false;
                }
            })
            .catch(err => { console.error(err); alert('Kesalahan jaringan.'); btn.disabled = false; });
        });
    });
</script>
@endpush