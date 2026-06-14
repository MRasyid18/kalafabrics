@extends('layouts.admin')
@section('title', isset($user) ? 'Edit Pengguna' : 'Tambah Pengguna')
@section('page-title', isset($user) ? 'Edit Pengguna' : 'Tambah Pengguna')

@section('content')
<div class="page-header">
    <h1>{{ isset($user) ? 'Edit Data Pengguna' : 'Tambah Akun Baru' }}</h1>
    <p>Silakan isi informasi akun di bawah ini.</p>
</div>

<div class="card" style="max-width:600px;">
    <div class="card-body" style="padding:24px;">
        <form action="{{ isset($user) ? route('admin.users.update', $user->id) : route('admin.users.store') }}" method="POST">
            @csrf
            @if(isset($user)) @method('PUT') @endif
            
            <div style="margin-bottom:16px;">
                <label style="display:block; font-size:13px; font-weight:600; margin-bottom:6px; color:#6b6b5a;">Tipe Akun (Role)</label>
                <select name="role" required style="width:100%; padding:12px; border:1px solid #e8e5dd; border-radius:8px; font-family:inherit; background:white;">
                    <option value="pengguna" {{ (old('role', $user->role ?? '') == 'pengguna' || old('role', $user->role ?? '') == 'b2c') ? 'selected' : '' }}>👤 Pengguna Biasa (B2C)</option>
                    <option value="b2b" {{ old('role', $user->role ?? '') == 'b2b' ? 'selected' : '' }}>🏢 Mitra Perusahaan (B2B)</option>
                </select>
                @error('role') <span style="color:#e07070; font-size:12px;">{{ $message }}</span> @enderror
            </div>

            <div style="margin-bottom:16px;">
                <label style="display:block; font-size:13px; font-weight:600; margin-bottom:6px; color:#6b6b5a;">Nama Lengkap / Instansi</label>
                <input type="text" name="name" value="{{ old('name', $user->name ?? '') }}" required style="width:100%; padding:12px; border:1px solid #e8e5dd; border-radius:8px; font-family:inherit;">
            </div>
            
            <div style="margin-bottom:16px;">
                <label style="display:block; font-size:13px; font-weight:600; margin-bottom:6px; color:#6b6b5a;">Alamat Email</label>
                <input type="email" name="email" value="{{ old('email', $user->email ?? '') }}" required style="width:100%; padding:12px; border:1px solid #e8e5dd; border-radius:8px; font-family:inherit;">
                @error('email') <span style="color:#e07070; font-size:12px;">{{ $message }}</span> @enderror
            </div>
            
            <div style="margin-bottom:24px;">
                <label style="display:block; font-size:13px; font-weight:600; margin-bottom:6px; color:#6b6b5a;">Password {{ isset($user) ? '(Kosongkan jika tidak ingin diubah)' : '' }}</label>
                <input type="password" name="password" {{ isset($user) ? '' : 'required' }} style="width:100%; padding:12px; border:1px solid #e8e5dd; border-radius:8px; font-family:inherit;">
                @error('password') <span style="color:#e07070; font-size:12px;">{{ $message }}</span> @enderror
            </div>
            
            <div style="display:flex; gap:12px;">
                <button type="submit" style="background:#2d3a1e; color:white; padding:12px 24px; border-radius:8px; font-weight:600;">Simpan Data</button>
                <a href="{{ route('admin.users.index') }}" style="background:#f0ede6; color:#1e2318; padding:12px 24px; border-radius:8px; font-weight:600;">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection