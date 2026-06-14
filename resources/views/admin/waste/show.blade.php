@extends('layouts.admin')

@section('page-title', 'Detail Kurasi Limbah')

@push('styles')
<style>
    /* Custom Styling Khusus Halaman Detail */
    .detail-wrapper { display: flex; gap: 24px; align-items: flex-start; margin-top: 10px; }
    .detail-main { flex: 1.6; }
    .detail-sidebar { flex: 1; position: sticky; top: 84px; } /* Sticky mengikuti scroll */
    
    @media (max-width: 992px) {
        .detail-wrapper { flex-direction: column; }
        .detail-main, .detail-sidebar { width: 100%; }
        .detail-sidebar { position: static; }
    }

    /* Row Informasi */
    .info-row { display: flex; justify-content: space-between; align-items: center; padding: 16px 0; border-bottom: 1px dashed #e8e5dd; }
    .info-row:last-child { border-bottom: none; }
    .info-label { color: #9a9988; font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em; }
    .info-value { color: #1e2318; font-size: 14px; font-weight: 500; text-align: right; max-width: 60%; line-height: 1.4; }

    /* Badge Status Modern */
    .status-badge { display: inline-flex; align-items: center; padding: 6px 14px; border-radius: 999px; font-size: 12px; font-weight: 600; letter-spacing: 0.04em; }
    .status-diajukan { background: #fdf0dc; color: #8b6914; }
    .status-kurasi { background: #e8eef8; color: #2952a3; }
    .status-penjemputan { background: #f0e8f8; color: #6b29a3; }
    .status-diterima { background: #e8f5f0; color: #2d6a4f; }
    .status-selesai { background: #2d6a4f; color: #ffffff; }
    .status-ditolak { background: #fce8e8; color: #c0392b; }

    /* Form Customization */
    .form-group { margin-bottom: 20px; }
    .form-label { display: block; font-size: 13px; font-weight: 600; color: #1e2318; margin-bottom: 8px; }
    .form-control, .form-select { 
        width: 100%; padding: 12px 16px; border: 1px solid #d8d4c8; 
        border-radius: 10px; font-family: inherit; font-size: 14px; 
        background: #faf9f6; transition: all 0.2s; 
    }
    .form-control:focus, .form-select:focus { 
        outline: none; border-color: #c9a85c; box-shadow: 0 0 0 3px rgba(201,168,92,0.15); background: white; 
    }

    /* Buttons */
    .btn-primary-custom { 
        background: #2d3a1e; color: white; border: none; padding: 14px 24px; 
        border-radius: 10px; font-weight: 500; font-size: 14px; width: 100%; 
        cursor: pointer; transition: background 0.2s, transform 0.1s; 
    }
    .btn-primary-custom:hover { background: #1e2318; }
    .btn-primary-custom:active { transform: scale(0.98); }
    
    .btn-back { 
        display: inline-flex; align-items: center; gap: 8px; color: #9a9988; 
        font-size: 14px; font-weight: 500; margin-bottom: 12px; transition: color 0.2s; 
    }
    .btn-back:hover { color: #2d3a1e; }

    /* Photo Frame */
    .photo-frame { 
        width: 100%; border-radius: 12px; overflow: hidden; 
        border: 1px solid #e8e5dd; background: #faf9f6; margin-top: 8px; 
    }
    .photo-frame img { width: 100%; height: auto; display: block; object-fit: cover; max-height: 450px; }
    .photo-empty { padding: 50px 20px; text-align: center; color: #9a9988; font-size: 14px; }

    /* Conditional Weight Box */
    .weight-box { 
        background: #e8f5f0; border: 1px dashed #2d6a4f; padding: 16px; 
        border-radius: 12px; margin-bottom: 20px; display: none; 
    }
    .weight-box.active { display: block; animation: fadeIn 0.3s ease; }
    @keyframes fadeIn { from { opacity: 0; transform: translateY(-5px); } to { opacity: 1; transform: translateY(0); } }
</style>
@endpush

@section('content')
<a href="{{ route('admin.waste.index') }}" class="btn-back">
    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
    Kembali ke Daftar Kurasi
</a>

<div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 28px; flex-wrap: wrap; gap: 16px;">
    <div>
        <h1 style="font-family: 'Cormorant Garamond', serif; font-size: 2.2rem; font-weight: 400; color: #1e2318; margin: 0 0 4px 0;">Manajemen Kurasi</h1>
        <p style="font-size: 14px; color: #6b6b5a; margin: 0;">
            ID Transaksi: <span style="font-family: monospace; color: #c9a85c; font-weight: 600; font-size: 15px;">#KALA-{{ str_pad($donation->id, 5, '0', STR_PAD_LEFT) }}</span>
        </p>
    </div>
    <div>
        @php
            $statusClass = 'status-diajukan'; // default
            if($donation->status == 'kurasi') $statusClass = 'status-kurasi';
            if($donation->status == 'penjemputan') $statusClass = 'status-penjemputan';
            if($donation->status == 'diterima') $statusClass = 'status-diterima';
            if($donation->status == 'selesai') $statusClass = 'status-selesai';
            if($donation->status == 'ditolak') $statusClass = 'status-ditolak';
        @endphp
        <span class="status-badge {{ $statusClass }}">
            Status: {{ strtoupper($donation->status) }}
        </span>
    </div>
</div>

<div class="detail-wrapper">
    <div class="detail-main">
        <div class="card" style="padding: 32px; margin-bottom: 24px;">
            <h3 style="font-family: 'Cormorant Garamond', serif; font-size: 1.4rem; color: #1e2318; margin-bottom: 8px;">Informasi Pengajuan</h3>
            <p style="font-size: 13px; color: #9a9988; margin-bottom: 24px;">Rincian data limbah yang disetorkan oleh mitra B2B.</p>

            <div class="info-row">
                <div class="info-label">Nama Mitra (Perusahaan)</div>
                <div class="info-value">{{ $donation->user->name }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Komoditas Limbah</div>
                <div class="info-value">
                    <strong>{{ $donation->waste_type }}</strong><br>
                    <span style="color: #6b6b5a; font-size: 13px;">{{ $donation->condition }}</span>
                </div>
            </div>
            <div class="info-row">
                <div class="info-label">Estimasi Berat</div>
                <div class="info-value" style="font-size: 16px;">{{ $donation->weight }} Kg</div>
            </div>
            <div class="info-row">
                <div class="info-label">Metode Penyerahan</div>
                <div class="info-value">
                    @if($donation->delivery_method == 'self_delivery')
                        <span style="color: #c9a85c; font-weight: 600;">Kirim Mandiri ke Gudang</span>
                    @else
                        <span style="color: #2d6a4f; font-weight: 600;">Penjemputan Ranger KalaFabrics</span>
                    @endif
                    <br>
                    <span style="color: #6b6b5a; font-size: 13px;">Tgl Rencana: {{ \Carbon\Carbon::parse($donation->pickup_date)->format('d M Y') }}</span>
                </div>
            </div>
            @if($donation->delivery_method == 'ranger_pickup' && $donation->address)
            <div class="info-row">
                <div class="info-label">Alamat Penjemputan</div>
                <div class="info-value">{{ $donation->address }}</div>
            </div>
            @endif
        </div>

        <div class="card" style="padding: 32px;">
            <h3 style="font-family: 'Cormorant Garamond', serif; font-size: 1.4rem; color: #1e2318; margin-bottom: 8px;">Dokumentasi Visual</h3>
            <p style="font-size: 13px; color: #9a9988; margin-bottom: 16px;">Gunakan foto ini untuk pertimbangan awal sebelum menyetujui penjemputan.</p>
            
            <div class="photo-frame">
                @if($donation->photo_path)
                    <img src="{{ asset('storage/' . $donation->photo_path) }}" alt="Foto Limbah dari B2B">
                @else
                    <div class="photo-empty">
                        <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" style="margin-bottom: 16px; opacity: 0.3;"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><circle cx="8.5" cy="8.5" r="1.5"></circle><polyline points="21 15 16 10 5 21"></polyline></svg>
                        <br>Mitra tidak melampirkan foto dokumentasi.
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="detail-sidebar">
        <div class="card" style="padding: 32px; border-top: 4px solid #c9a85c;">
            <h3 style="font-family: 'Cormorant Garamond', serif; font-size: 1.4rem; color: #1e2318; margin-bottom: 24px; display: flex; align-items: center; gap: 8px;">
                Panel Tindakan
            </h3>

            <form action="{{ route('admin.waste.update_status', $donation->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label class="form-label">Ubah Status Tracking</label>
                    <select name="status" class="form-select" id="statusSelect" required>
                        <option value="diajukan" {{ $donation->status == 'diajukan' ? 'selected' : '' }}>1. Baru Diajukan</option>
                        <option value="kurasi" {{ $donation->status == 'kurasi' ? 'selected' : '' }}>2. Lolos Kurasi Awal</option>
                        <option value="penjemputan" {{ $donation->status == 'penjemputan' ? 'selected' : '' }}>3. Sedang Dijemput Ranger</option>
                        <option value="diterima" {{ $donation->status == 'diterima' ? 'selected' : '' }}>4. Tiba di Gudang</option>
                        <option value="selesai" {{ $donation->status == 'selesai' ? 'selected' : '' }}>5. Selesai (Cairkan Poin)</option>
                        <option value="ditolak" {{ $donation->status == 'ditolak' ? 'selected' : '' }}>X. Tolak Pengajuan</option>
                    </select>
                </div>

                <div class="weight-box" id="finalWeightBox" style="{{ $donation->status == 'selesai' ? 'display: block;' : '' }}">
                    <label class="form-label" style="color: #1e4b35;">⚖️ Konfirmasi Berat Final (Kg)</label>
                    <input type="number" step="0.1" name="final_weight" id="finalWeightInput" class="form-control mb-3" style="border-color: #2d6a4f; background: white;" placeholder="Contoh: 25.5" value="{{ $donation->weight }}">
                    
                    <label class="form-label" style="color: #b58500; margin-top: 12px;">🪙 Berikan Poin Digital</label>
                    <input type="number" name="awarded_points" id="awardedPointsInput" class="form-control" style="border-color: #c9a85c; background: white;" placeholder="Contoh: 250" value="{{ $donation->points_awarded > 0 ? $donation->points_awarded : '' }}">
                    
                    <p style="font-size: 11px; color: #1e4b35; margin: 8px 0 0 0; line-height: 1.4;">
                        Sistem otomatis merekomendasikan <strong>10 Poin per Kg</strong>. Admin dapat menyesuaikan angka ini secara manual jika diperlukan.
                    </p>
                </div>

                <div class="form-group">
                    <label class="form-label">Catatan Admin (Opsional)</label>
                    <textarea name="verification_notes" rows="4" class="form-control" placeholder="Tulis instruksi untuk ranger atau berikan alasan penolakan...">{{ $donation->verification_notes }}</textarea>
                </div>

                <button type="submit" class="btn-primary-custom">
                    Simpan Perubahan &rarr;
                </button>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const statusSelect = document.getElementById('statusSelect');
        const weightBox = document.getElementById('finalWeightBox');
        const finalWeightInput = document.getElementById('finalWeightInput');
        const awardedPointsInput = document.getElementById('awardedPointsInput');

        // Logika UI: Tampilkan/Sembunyikan box input saat status 'selesai'
        statusSelect.addEventListener('change', function() {
            if (this.value === 'selesai') {
                weightBox.classList.add('active');
            } else {
                weightBox.classList.remove('active');
            }
        });

        // Logika UI: Auto Kalkulasi Poin (1 Kg = 10 Poin) secara real-time
        finalWeightInput.addEventListener('input', function() {
            let weight = parseFloat(this.value);
            if(!isNaN(weight)) {
                // Kalikan berat dengan 10 dan bulatkan ke bawah untuk poin
                awardedPointsInput.value = Math.floor(weight * 10);
            } else {
                awardedPointsInput.value = '';
            }
        });
    });
</script>
@endpush