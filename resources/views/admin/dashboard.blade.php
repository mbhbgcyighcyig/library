@extends('layouts.admin')

@section('title', 'Dashboard Admin - Bookify')

@section('content')

<div class="page-header">
    <h1>Selamat Datang Di Dashboard Admin</h1>
</div>

<!-- STAT CARDS -->
<div class="stats-row">
    <div class="stat-card">
        <div class="stat-label">Total Buku</div>
        <div class="stat-num">{{ $totalBooks }}</div>
    </div>
    <div class="stat-card">
        <div class="stat-label">Total Pengguna</div>
        <div class="stat-num">{{ $totalUsers }}</div>
    </div>
    <div class="stat-card">
        <div class="stat-label">Total Petugas</div>
        <div class="stat-num">{{ $totalStaff }}</div>
    </div>
    <div class="stat-card">
        <div class="stat-label">Total Peminjaman</div>
        <div class="stat-num">{{ $totalBorrow }}</div>
    </div>
</div>

<!-- ROW: Peminjaman Terbaru + Stok Menipis -->
<div class="grid-2">
    <div class="card-box">
        <div class="card-title">Peminjaman Terbaru</div>
        <table class="tbl">
            <thead>
                <tr>
                    <th>Pengguna</th>
                    <th>Buku</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentBorrows as $borrow)
                <tr>
                    <td>{{ $borrow->user->name ?? '-' }}</td>
                    <td style="max-width:130px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">{{ $borrow->book->title ?? '-' }}</td>
                    <td>
                        @if($borrow->status === 'dipinjam')
                            <span class="badge-green">Dipinjam</span>
                        @elseif($borrow->status === 'dikembalikan')
                            <span class="badge-yellow">Dikembalikan</span>
                        @else
                            <span class="badge-gray">{{ ucfirst($borrow->status) }}</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr><td colspan="3" style="text-align:center;color:#aaa;padding:20px;">Belum ada peminjaman</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="card-box">
        <div class="card-title">Stok Menipis</div>
        <table class="tbl">
            <thead>
                <tr>
                    <th>Judul Buku</th>
                    <th>Stok</th>
                </tr>
            </thead>
            <tbody>
                @forelse($lowStockBooks as $book)
                <tr>
                    <td>{{ $book->title }}</td>
                    <td>
                        @if($book->stock == 0)
                            <span class="badge-red">Habis</span>
                        @else
                            <span class="badge-red">{{ $book->stock }}</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr><td colspan="2" style="text-align:center;color:#aaa;padding:20px;">Semua stok aman</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Laporan Data Buku -->
<div class="card-box">
    <div class="card-title">Laporan Data Buku</div>
    <table class="tbl">
        <thead>
            <tr>
                <th>No</th>
                <th>Judul</th>
                <th>Penulis</th>
                <th>Kategori</th>
                <th>Stok</th>
            </tr>
        </thead>
        <tbody>
            @forelse($latestBooks as $i => $book)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $book->title }}</td>
                <td>{{ $book->author }}</td>
                <td>{{ $book->category->name ?? '-' }}</td>
                <td>{{ $book->stock }}</td>
            </tr>
            @empty
            <tr><td colspan="5" style="text-align:center;color:#aaa;padding:20px;">Belum ada buku</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection
