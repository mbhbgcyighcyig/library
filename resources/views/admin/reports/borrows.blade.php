@extends('layouts.admin')

@section('title', 'Laporan Peminjaman - Admin Bookify')

@section('content')

<div class="page-header">
    <h1>Laporan Peminjaman</h1>
</div>

<div style="display:flex;gap:10px;margin-bottom:18px;flex-wrap:wrap;">
    <a href="{{ route('admin.reports.books') }}" class="btn-secondary"><i class="fas fa-book"></i> Laporan Buku</a>
    <a href="{{ route('admin.reports.users') }}" class="btn-secondary"><i class="fas fa-users"></i> Laporan Pengguna</a>
    <a href="{{ route('admin.reports.staff') }}" class="btn-secondary"><i class="fas fa-user-tie"></i> Laporan Petugas</a>
</div>

<div class="card-box">
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:16px;">
        <div class="card-title" style="margin-bottom:0;">Laporan Peminjaman ({{ $borrows->count() }} data)</div>
        <button onclick="window.print()" class="btn-primary"><i class="fas fa-print"></i> Cetak</button>
    </div>
    <div style="overflow-x:auto;">
        <table class="tbl">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Pengguna</th>
                    <th>Buku</th>
                    <th>Tgl Pinjam</th>
                    <th>Jatuh Tempo</th>
                    <th>Tgl Kembali</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($borrows as $i => $borrow)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td style="font-weight:600;">{{ $borrow->user->name ?? '-' }}</td>
                    <td>{{ $borrow->book->title ?? '-' }}</td>
                    <td>{{ $borrow->borrowed_at }}</td>
                    <td>{{ $borrow->return_date ?? '-' }}</td>
                    <td>{{ $borrow->returned_at ?? '-' }}</td>
                    <td>
                        @if($borrow->status === 'dipinjam')
                            <span class="badge-green">Dipinjam</span>
                        @else
                            <span class="badge-yellow">Dikembalikan</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" style="text-align:center;color:#aaa;padding:30px;">Belum ada data.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection
