@extends('layouts.app')
@section('title', 'Validasi & Grading Limbah')

@section('content')
<div class="container py-5" style="max-width: 800px;">
    
    <div class="mb-4">
        <a href="{{ route('ranger.dashboard') }}" style="color: #6b6b5a; text-decoration: none; font-size: 14px; font-weight: 600;">&larr; Kembali ke Dashboard</a>
    </div>

    <div style="background: white; border: 1px solid #e8e5dd; border-radius: 16px; overflow: hidden;">
        <div style="background: #faf9f6; border-bottom: 1px solid #e8e5dd; padding: 24px 32px;">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 style="font-family: 'Cormorant Garamond', serif; font-size: 2rem; margin: 0; font-weight: 600; color: #1e2318;">Form Validasi & Grading</h1>
                    <p style="font-size: 0.9rem; color: #9a9988; margin: 0; margin-top: 4px;">Penyortiran fisik Inbound Logistics dari Mitra B2B.</p>
                </div>
                <div style="text-align: right;">
                    <div style="font-size: 11px; font-weight: 600; color: #9a9988; text-transform: uppercase;">ID Transaksi</div>
                    <div style="font-family: monospace; font-size: 1.2rem; font-weight: 600; color: #c9a85c;">#KALA-{{ str_pad($donation->id, 5, '0', STR_PAD_LEFT) }}</div>
                </div>
            </div>
        </div>

        <div style="padding: 32px;">
            <div style="background: #fdfdfc; border: 1px dashed #d8d4c8; border-radius: 12px; padding: 20px; margin-bottom: 30px; display: flex; flex-wrap: wrap; gap: 20px;">
                <div style="flex: 1; min-width: 150px;">
                    <div style="font-size: 12px; color: #9a9988; font-weight: 600; text-transform: uppercase; margin-bottom: 4px;">Mitra / Pengirim</div>
                    <div style="font-weight: 600; color: #1e2318;">{{ $donation->user->name ?? 'Anonim' }}</div>
                </div>
                <div style="flex: 1; min-width: 150px;">
                    <div style="font-size: 12px; color: #9a9988; font-weight: 600; text-transform: uppercase; margin-bottom: 4px;">Tipe Limbah</div>
                    <div style="font-weight: 500; color: #1e2318;">{{ $donation->waste_type }}</div>
                </div>
                <div style="flex: 1; min-width: 150px;">
                    <div style="font-size: 12px; color: #9a9988; font-weight: 600; text-transform: uppercase; margin-bottom: 4px;">Estimasi Awal</div>
                    <div style="font-weight: 600; color: #c9a85c; font-size: 1.1rem;">{{ $donation->weight }} Kg</div>
                </div>
            </div>

            <form action="{{ route('ranger.waste.process', $donation->id) }}" method="POST">
                @csrf
                
                <div class="row mb-4">
                    <div class="col-md-6">
                        <label style="font-weight:600; display:block; margin-bottom:8px; font-size:13px; color:#6b6b5a;">Berat Aktual (Hasil Timbangan) *</label>
                        <div class="input-group">
                            <input type="number" step="0.1" name="actual_weight" value="{{ old('actual_weight', $donation->weight) }}" style="width:100%; padding:12px; border-radius:8px 0 0 8px; border:1px solid #e8e5dd; background:white; font-family:inherit;" required>
                            <span class="input-group-text" style="background:#faf9f6; border:1px solid #e8e5dd; border-left:none; border-radius:0 8px 8px 0; color:#9a9988; font-weight:600;">Kg</span>
                        </div>
                        @error('actual_weight') <span class="text-danger" style="font-size:12px;">{{ $message }}</span> @enderror
                    </div>
                    
                    <div class="col-md-6 mt-3 mt-md-0">
                        <label style="font-weight:600; display:block; margin-bottom:8px; font-size:13px; color:#6b6b5a;">Hasil Grading (Kelayakan) *</label>
                        <select name="grading" style="width:100%; padding:12px; border-radius:8px; border:1px solid #e8e5dd; background:white; font-family:inherit;" required>
                            <option value="">-- Pilih Kondisi Limbah --</option>
                            <option value="layak">🟢 Layak Didaur Ulang (100% Bersih)</option>
                            <option value="campur">🟡 Campur (Perlu sortir ulang ekstra)</option>
                            <option value="tidak_layak">🔴 Tidak Layak (Terkontaminasi berat)</option>
                        </select>
                        @error('grading') <span class="text-danger" style="font-size:12px;">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="mb-4">
                    <label style="font-weight:600; display:block; margin-bottom:8px; font-size:13px; color:#6b6b5a;">Catatan Lapangan (Opsional)</label>
                    <textarea name="notes" rows="3" placeholder="Misal: 'Terdapat 2kg kain yang terkena noda oli parah...'" style="width:100%; padding:12px; border-radius:8px; border:1px solid #e8e5dd; background:white; font-family:inherit;"></textarea>
                </div>

                <div style="background: #e8f5f0; border-left: 4px solid #2d6a4f; padding: 16px; border-radius: 4px; margin-bottom: 24px;">
                    <strong style="color: #2d6a4f; font-size: 13px;">Sistem Otomatis (Smart Contract):</strong>
                    <p style="color: #4a7c59; font-size: 12px; margin: 4px 0 0 0;">Menyimpan data ini akan memvalidasi transaksi dan secara otomatis menghitung serta mengirimkan poin digital ke akun Mitra.</p>
                </div>

                <div class="d-flex justify-content-end gap-2">
                    <button type="submit" class="btn" style="background:#2d3a1e; color:white; padding:12px 24px; border-radius:8px; font-weight:600; border:none; cursor:pointer;">
                        Simpan & Validasi Transaksi
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection