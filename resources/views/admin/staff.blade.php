@extends('layouts.admin')

@section('title', 'Petugas - Admin Bookify')

@section('content')

<div class="page-header">
    <h1>Data Petugas</h1>
</div>

<div class="card-box">
    <div class="card-title">Tambah Petugas Baru</div>
    <form action="{{ route('admin.staff.store') }}" method="POST">
        @csrf
        <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:12px;margin-bottom:12px;">
            <input type="text" name="name" class="form-field" placeholder="Nama Lengkap" required>
            <input type="text" name="username" class="form-field" placeholder="Username" required>
            <input type="text" name="phone" class="form-field" placeholder="No. HP">
            <input type="email" name="email" class="form-field" placeholder="Email" required>
            <input type="password" name="password" class="form-field" placeholder="Password (min 8 karakter)" required>
        </div>
        <button type="submit" class="btn-primary"><i class="fas fa-user-plus"></i> Tambah Petugas</button>
    </form>
</div>

<div class="card-box">
    <div class="card-title">Daftar Petugas ({{ $staff->count() }} petugas)</div>
    <table class="tbl">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Username</th>
                <th>Email</th>
                <th>No. HP</th>
                <th>Role</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($staff as $i => $user)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td style="font-weight:600;">{{ $user->name }}</td>
                <td>{{ $user->username ?? '-' }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->phone ?? '-' }}</td>
                <td><span class="badge-blue">Petugas</span></td>
                <td>
                    <form action="{{ route('admin.staff.destroy', $user) }}" method="POST" style="display:inline;" onsubmit="return confirm('Hapus petugas ini?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn-danger"><i class="fas fa-trash"></i></button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="7" style="text-align:center;color:#aaa;padding:30px;">Belum ada petugas.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection
