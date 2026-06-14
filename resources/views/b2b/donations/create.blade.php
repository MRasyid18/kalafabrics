@extends('layouts.app')

@section('content')
<div class="container py-5" style="background-color: #faf8f5; min-height: 85vh; border-radius: 12px;">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-7">
            
            <div class="mb-4">
                <a href="{{ route('b2b.dashboard') }}" class="text-decoration-none" style="color: #d4af37; font-weight: 600;">
                    <i class="bi bi-arrow-left me-1"></i> Kembali ke Dashboard
                </a>
            </div>

            <div class="card border-0 shadow-sm" style="border-radius: 12px; background-color: #ffffff;">
                <div class="card-body p-4 p-md-5">
                    <h3 class="mb-2" style="font-weight: 700; color: #2c2c2c;">Formulir Jadwal <span style="color: #d4af37;">Penyerahan Limbah</span></h3>
                    <p class="text-muted small mb-4">Isi rincian limbah kain/tekstil sisa produksi milik perusahaan Anda untuk dilakukan verifikasi dan penjemputan oleh staf lapangan (Ranger) atau dikirim secara mandiri.</p>
                    
                    <hr class="mb-4" style="color: #f1f1f1;">

                    <form action="{{ route('b2b.donations.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label class="form-label" style="font-weight: 600; color: #4a4a4a;">Jenis Komoditas Limbah</label>
                                <input type="text" class="form-control" name="waste_type" placeholder="Contoh: Denim, Katun" required style="border-radius: 6px; padding: 10px 12px;">
                            </div>
                            
                            <div class="col-md-6 mb-4">
                                <label class="form-label" style="font-weight: 600; color: #4a4a4a;">Kondisi Limbah</label>
                                <select class="form-select" name="condition" required style="border-radius: 6px; padding: 10px 12px;">
                                    <option value="">-- Pilih Kondisi --</option>
                                    <option value="Sisa Potongan (Perca)">Sisa Potongan (Perca)</option>
                                    <option value="Pakaian Reject Factory">Pakaian Reject Factory</option>
                                    <option value="Seragam Bekas Karyawan">Seragam Bekas Karyawan</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label" style="font-weight: 600; color: #4a4a4a;">Estimasi Berat Bersih (Kg)</label>
                            <div class="input-group">
                                <input type="number" step="0.1" class="form-control" name="weight" placeholder="Contoh: 25.5" required style="border-radius: 6px 0 0 6px; padding: 10px 12px;">
                                <span class="input-group-text bg-light text-muted" style="border-radius: 0 6px 6px 0; font-weight: 600;">Kg</span>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label" style="font-weight: 600; color: #4a4a4a;">Dokumentasi Foto Limbah</label>
                            <input type="file" class="form-control" name="photo" accept="image/png, image/jpeg" required style="border-radius: 6px; padding: 10px 12px;">
                            <small class="text-muted">Format JPG/PNG. Maksimal 2MB. Diperlukan untuk kurasi awal oleh tim admin.</small>
                        </div>

                        <div class="mb-4">
                            <label class="form-label" style="font-weight: 600; color: #4a4a4a;">Metode Penyerahan</label>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="delivery_method" id="self_delivery" value="self_delivery">
                                <label class="form-check-label" for="self_delivery">
                                    <strong>Kirim Mandiri</strong> (Kirim langsung ke Gudang KalaFabrics)
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="delivery_method" id="ranger_pickup" value="ranger_pickup" checked>
                                <label class="form-check-label" for="ranger_pickup">
                                    <strong>Request Penjemputan Ranger</strong> (Tim lapangan kami yang ambil)
                                </label>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label" style="font-weight: 600; color: #4a4a4a;">Tanggal Penyerahan / Penjemputan</label>
                            <input type="date" class="form-control" name="pickup_date" required style="border-radius: 6px; padding: 10px 12px;">
                        </div>

                        <div class="mb-4">
                            <label class="form-label" style="font-weight: 600; color: #4a4a4a;">Alamat Pengambilan (Wajib jika Request Ranger)</label>
                            <textarea class="form-control" name="address" rows="3" placeholder="Detail alamat gudang/kantor atau titik penjemputan limbah" style="border-radius: 6px;"></textarea>
                        </div>

                        <div class="d-grid mt-5">
                            <button type="submit" class="btn btn-lg" style="background-color: #d4af37; color: white; font-weight: 600; border-radius: 8px; border: none; padding: 12px 0; font-size: 1rem; transition: background 0.2s;">
                                Ajukan Limbah &rarr;
                            </button>
                        </div>
                    </form>

                </div>
            </div>

        </div>
    </div>
</div>
@endsection