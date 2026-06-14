@extends('layouts.admin')
@section('title', 'Manajemen Produk')
@section('page-title', 'Produk')

@push('styles')
<style>
    .modal { display: none; position: fixed; z-index: 1000; left: 0; top: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5); align-items: center; justify-content: center; }
    .modal.show { display: flex; }
    .modal-content { background-color: #fff; border-radius: 12px; padding: 24px; width: 100%; max-width: 450px; box-shadow: 0 4px 20px rgba(0,0,0,0.15); max-height: 90vh; overflow-y: auto; }
    .modal-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
    .modal-title { font-size: 1.2rem; font-weight: 600; font-family: 'Cormorant Garamond', serif; }
    .close-btn { background: none; border: none; font-size: 1.5rem; cursor: pointer; color: #9a9988; }
    .form-group { margin-bottom: 16px; }
    .form-label { display: block; font-size: 13px; font-weight: 600; margin-bottom: 6px; color: #1e2318; }
    .form-control { width: 100%; padding: 10px 12px; border: 1px solid #d8d4c8; border-radius: 8px; font-size: 14px; font-family: inherit; }
    .form-actions { display: flex; justify-content: flex-end; gap: 10px; margin-top: 24px; }
    .btn-submit { background: #2d3a1e; color: white; padding: 10px 20px; border-radius: 8px; font-weight: 600; border: none; cursor:pointer;}
    .btn-cancel { background: #e8e5dd; color: #1e2318; padding: 10px 20px; border-radius: 8px; font-weight: 600; border: none; cursor:pointer;}
</style>
@endpush

@section('content')
<div class="page-header" style="display:flex; justify-content:space-between; align-items:center;">
    <div>
        <h1>Manajemen Produk</h1>
        <p>Kelola semua produk sirkular dan barang B2B KalaFabrics.</p>
    </div>
    <button onclick="openModal('addModal')" class="btn" style="background:#2d3a1e; color:white; padding:10px 20px; border-radius:8px; font-weight:600;">+ Tambah Produk</button>
</div>

<div class="card">
    <div class="card-body">
        <table>
            <thead>
                <tr>
                    <th>Gambar</th>
                    <th>Nama Produk</th>
                    <th>Harga</th>
                    <th>Stok</th>
                    <th>Tipe</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $product)
                <tr>
                    <!-- Tampilkan Gambar Produk -->
                    <td>
                        @if($product->image_path)
                            <img src="{{ asset('storage/' . $product->image_path) }}" alt="{{ $product->name }}" style="width: 50px; height: 50px; object-fit: cover; border-radius: 8px;">
                        @else
                            <div style="width:50px; height:50px; background:#f0f0f0; border-radius:8px; display:flex; align-items:center; justify-content:center; font-size:10px; color:#999;">No Img</div>
                        @endif
                    </td>
                    <td>
                        <div style="font-weight:500;">{{ $product->name }}</div>
                        <div style="font-size:12px; color:#9a9988;">SKU: {{ $product->sku }}</div>
                    </td>
                    <td>Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                    <td>
                        @if($product->stock > 5) <span style="color:#2d6a4f; font-weight:600;">{{ $product->stock }}</span>
                        @else <span style="color:#c0392b; font-weight:600;">{{ $product->stock }} (Menipis)</span> @endif
                    </td>
                    <td><span class="role-pill role-pengguna">{{ strtoupper($product->product_type) }}</span></td>
                    <td>
                        <div style="display:flex; gap:10px; align-items:center;">
                            <button type="button" onclick="openEditModal('{{ $product->id }}', '{{ addslashes($product->name) }}', '{{ $product->price }}', '{{ $product->stock }}', '{{ $product->product_type }}')" style="color:#c9a85c; font-weight:600; background:none; border:none; cursor:pointer;">Edit</button>
                            <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus produk ini?');" style="margin:0;">
                                @csrf @method('DELETE')
                                <button type="submit" style="color:#c0392b; font-weight:600; background:none; border:none; cursor:pointer;">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="empty-state">Belum ada produk yang ditambahkan.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<div style="margin-top: 20px;">{{ $products->links('pagination::bootstrap-4') }}</div>

<!-- POPUP TAMBAH PRODUK -->
<div id="addModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <div class="modal-title">Tambah Produk Baru</div>
            <button class="close-btn" onclick="closeModal('addModal')">&times;</button>
        </div>
        <!-- Tambahkan enctype -->
        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="form-label">Gambar Produk</label>
                <input type="file" name="image" class="form-control" accept="image/*">
            </div>
            <div class="form-group">
                <label class="form-label">Nama Produk</label>
                <input type="text" name="name" class="form-control" required>
            </div>
            <div class="form-group">
                <label class="form-label">Harga (Rp)</label>
                <input type="number" name="price" class="form-control" required min="0">
            </div>
            <div class="form-group">
                <label class="form-label">Stok Awal</label>
                <input type="number" name="stock" class="form-control" required min="0" value="0">
            </div>
            <div class="form-group">
                <label class="form-label">Tipe Distribusi</label>
                <select name="product_type" class="form-control" required>
                    <option value="b2c">B2C (Eceran)</option><option value="b2b">B2B (Borongan)</option><option value="both">Keduanya</option>
                </select>
            </div>
            <div class="form-actions">
                <button type="button" class="btn-cancel" onclick="closeModal('addModal')">Batal</button>
                <button type="submit" class="btn-submit">Simpan Produk</button>
            </div>
        </form>
    </div>
</div>

<!-- POPUP EDIT PRODUK -->
<div id="editModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <div class="modal-title">Edit Data Produk</div>
            <button class="close-btn" onclick="closeModal('editModal')">&times;</button>
        </div>
        <form id="edit-form" method="POST" enctype="multipart/form-data">
            @csrf @method('PUT')
            <div class="form-group">
                <label class="form-label">Ubah Gambar (Opsional)</label>
                <input type="file" name="image" class="form-control" accept="image/*">
                <small style="color:#9a9988; font-size:11px;">Biarkan kosong jika tidak ingin mengubah gambar.</small>
            </div>
            <div class="form-group">
                <label class="form-label">Nama Produk</label>
                <input type="text" name="name" id="edit-name" class="form-control" required>
            </div>
            <div class="form-group">
                <label class="form-label">Harga (Rp)</label>
                <input type="number" name="price" id="edit-price" class="form-control" required min="0">
            </div>
            <div class="form-group">
                <label class="form-label">Stok Tersedia</label>
                <input type="number" name="stock" id="edit-stock" class="form-control" required min="0">
            </div>
            <div class="form-group">
                <label class="form-label">Tipe Distribusi</label>
                <select name="product_type" id="edit-type" class="form-control" required>
                    <option value="b2c">B2C (Eceran)</option><option value="b2b">B2B (Borongan)</option><option value="both">Keduanya</option>
                </select>
            </div>
            <div class="form-actions">
                <button type="button" class="btn-cancel" onclick="closeModal('editModal')">Batal</button>
                <button type="submit" class="btn-submit">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function openModal(modalId) { document.getElementById(modalId).classList.add('show'); }
    function closeModal(modalId) { document.getElementById(modalId).classList.remove('show'); }

    function openEditModal(id, name, price, stock, type) {
        document.getElementById('edit-form').action = '/admin/products/' + id;
        document.getElementById('edit-name').value = name;
        document.getElementById('edit-price').value = price;
        document.getElementById('edit-stock').value = stock;
        document.getElementById('edit-type').value = type;
        openModal('editModal');
    }

    window.onclick = function(event) {
        if (event.target.classList.contains('modal')) { event.target.classList.remove('show'); }
    }
</script>
@endpush