@extends('layouts.admin')

@section('title', 'Kategori - Admin Bookify')

@section('content')

<div class="page-header">
    <h1>Kategori Buku</h1>
</div>

<div class="card-box">
    <div class="card-title">Tambah Kategori</div>
    <form action="{{ route('admin.categories.store') }}" method="POST">
        @csrf
        <div style="display:grid;grid-template-columns:1fr 2fr auto;gap:12px;align-items:end;">
            <input type="text" name="name" class="form-field" placeholder="Nama Kategori" required>
            <input type="text" name="description" class="form-field" placeholder="Deskripsi (opsional)">
            <button type="submit" class="btn-primary"><i class="fas fa-plus"></i> Tambah</button>
        </div>
    </form>
</div>

<div class="card-box">
    <div class="card-title">Daftar Kategori</div>
    <table class="tbl">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Kategori</th>
                <th>Deskripsi</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($categories as $i => $cat)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td style="font-weight:600;">{{ $cat->name }}</td>
                <td>{{ $cat->description ?? '-' }}</td>
                <td>
                    <form action="{{ route('admin.categories.destroy', $cat) }}" method="POST" style="display:inline;" onsubmit="return confirm('Hapus kategori ini?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn-danger"><i class="fas fa-trash"></i></button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="4" style="text-align:center;color:#aaa;padding:30px;">Belum ada kategori.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection
