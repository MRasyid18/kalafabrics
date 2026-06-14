@extends('layouts.admin')
@section('title', 'Manajemen Pengguna')
@section('page-title', 'Manajemen Pengguna')

@section('content')
<div class="page-header" style="display:flex; justify-content:space-between; align-items:center;">
    <div>
        <h1>Daftar Pengguna</h1>
        <p>Kelola data akun Mitra Perusahaan (B2B) dan Pengguna Biasa (B2C).</p>
    </div>
    <a href="{{ route('admin.users.create') }}" style="background:#2d3a1e; color:white; padding:10px 20px; border-radius:8px; font-size:14px; display:inline-block;">+ Tambah Akun</a>
</div>

<div class="card">
    <div class="card-body">
        <table>
            <thead>
                <tr>
                    <th>Nama Pengguna</th>
                    <th>Email</th>
                    <th>Tipe Akun (Role)</th>
                    <th>Tgl Mendaftar</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $u)
                <tr>
                    <td style="font-weight:500; color:#1e2318;">{{ $u->name }}</td>
                    <td>{{ $u->email }}</td>
                    <td>
                        @if($u->role === 'b2b')
                            <span style="background:#e8eef8; color:#2b5496; padding:4px 10px; border-radius:999px; font-size:11px; font-weight:600; letter-spacing:0.04em;">🏢 Mitra B2B</span>
                        @else
                            <span style="background:#e8e5dd; color:#6b6b5a; padding:4px 10px; border-radius:999px; font-size:11px; font-weight:600; letter-spacing:0.04em;">👤 Pengguna (B2C)</span>
                        @endif
                    </td>
                    <td>{{ $u->created_at->format('d M Y') }}</td>
                    <td style="display:flex; gap:12px;">
                        <a href="{{ route('admin.users.edit', $u->id) }}" style="color:#c9a85c; font-weight:600; font-size:13px;">Edit</a>
                        <form action="{{ route('admin.users.destroy', $u->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus akun ini?');">
                            @csrf @method('DELETE')
                            <button type="submit" style="color:#e07070; font-weight:600; font-size:13px;">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="empty-state">
                        <div class="icon">👥</div>
                        <p>Belum ada data pengguna B2B maupun B2C.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection