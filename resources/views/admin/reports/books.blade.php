@extends('layouts.admin')

@section('title', 'Laporan Buku - Admin Bookify')

@section('content')

<div class="page-header">
    <h1>Laporan Data Buku</h1>
</div>

<div style="display:flex;gap:10px;margin-bottom:18px;flex-wrap:wrap;">
    <a href="{{ route('admin.reports.users') }}" class="btn-secondary"><i class="fas fa-users"></i> Laporan Pengguna</a>
    <a href="{{ route('admin.reports.borrows') }}" class="btn-secondary"><i class="fas fa-exchange-alt"></i> Laporan Peminjaman</a>
    <a href="{{ route('admin.reports.staff') }}" class="btn-secondary"><i class="fas fa-user-tie"></i> Laporan Petugas</a>
</div>

<div class="card-box">
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:16px;">
        <div class="card-title" style="margin-bottom:0;">Laporan Buku ({{ $books->count() }} buku)</div>
        <button onclick="window.print()" class="btn-primary"><i class="fas fa-print"></i> Cetak</button>
    </div>
    <table class="tbl">
        <thead>
            <tr>
                <th>No</th>
                <th>Judul</th>
                <th>Penulis</th>
                <th>Kategori</th>
                <th>Penerbit</th>
                <th>Tahun</th>
                <th>Stok</th>
            </tr>
        </thead>
        <tbody>
            @forelse($books as $i => $book)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td style="font-weight:600;">{{ $book->title }}</td>
                <td>{{ $book->author }}</td>
                <td>{{ $book->category->name ?? '-' }}</td>
                <td>{{ $book->publisher }}</td>
                <td>{{ $book->published_year ?? '-' }}</td>
                <td>
                    @if($book->stock == 0)
                        <span class="badge-red">Habis</span>
                    @else
                        <span class="badge-green">{{ $book->stock }}</span>
                    @endif
                </td>
            </tr>
            @empty
            <tr><td colspan="7" style="text-align:center;color:#aaa;padding:30px;">Belum ada data buku.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection
