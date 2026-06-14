@extends('layouts.admin')
@section('title', 'Manajemen Ranger')
@section('page-title', 'Manajemen Ranger')

@section('content')
<div class="page-header" style="display:flex; justify-content:space-between; align-items:center;">
    <div>
        <h1>Daftar Ranger</h1>
        <p>Kelola data akun ranger.</p>
    </div>
    <a href="{{ route('admin.rangers.create') }}" style="background:#2d3a1e; color:white; padding:10px 20px; border-radius:8px; font-size:14px; display:inline-block;">+ Tambah Ranger</a>
</div>

<div class="card">
    <div class="card-body">
        <table>
            <thead>
                <tr>
                    <th>Ranger</th>
                    <th>Email</th>
                    <th>Tgl Mendaftar</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($rangers as $r)
                <tr>
                    <td style="font-weight:500; color:#1e2318;">{{ $r->name }}</td>
                    <td>{{ $r->email }}</td>
                    <td>{{ $r->created_at->format('d M Y') }}</td>
                    <td style="display:flex; gap:12px;">
                        <a href="{{ route('admin.rangers.edit', $r->id) }}" style="color:#c9a85c; font-weight:600; font-size:13px;">Edit</a>
                        <form action="{{ route('admin.rangers.destroy', $r->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus ranger ini?');">
                            @csrf @method('DELETE')
                            <button type="submit" style="color:#e07070; font-weight:600; font-size:13px;">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="empty-state">
                        <div class="icon">👥</div>
                        <p>Belum ada data ranger.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection