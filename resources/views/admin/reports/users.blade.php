@extends('layouts.admin')

@section('title', 'Laporan Pengguna - Admin Bookify')

@section('content')

<div class="page-header">
    <h1>Laporan Data Pengguna</h1>
</div>

<div style="display:flex;gap:10px;margin-bottom:18px;flex-wrap:wrap;">
    <a href="{{ route('admin.reports.books') }}" class="btn-secondary"><i class="fas fa-book"></i> Laporan Buku</a>
    <a href="{{ route('admin.reports.borrows') }}" class="btn-secondary"><i class="fas fa-exchange-alt"></i> Laporan Peminjaman</a>
    <a href="{{ route('admin.reports.staff') }}" class="btn-secondary"><i class="fas fa-user-tie"></i> Laporan Petugas</a>
</div>

<div class="card-box">
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:16px;">
        <div class="card-title" style="margin-bottom:0;">Laporan Pengguna ({{ $users->count() }} pengguna)</div>
        <button onclick="window.print()" class="btn-primary"><i class="fas fa-print"></i> Cetak</button>
    </div>
    <table class="tbl">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Username</th>
                <th>Email</th>
                <th>No. HP</th>
                <th>Terdaftar</th>
            </tr>
        </thead>
        <tbody>
            @forelse($users as $i => $user)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td style="font-weight:600;">{{ $user->name }}</td>
                <td>{{ $user->username ?? '-' }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->phone ?? '-' }}</td>
                <td style="font-size:12px;color:#999;">{{ $user->created_at->format('d M Y') }}</td>
            </tr>
            @empty
            <tr><td colspan="6" style="text-align:center;color:#aaa;padding:30px;">Belum ada pengguna.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection
