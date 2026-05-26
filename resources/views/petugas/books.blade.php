@extends('layouts.petugas')

@section('title', 'Data Buku - Petugas Bookify')

@section('content')

<div class="page-header">
    <h1>Data Buku</h1>
</div>

<div class="card-box">
    <div class="card-title">Daftar Buku ({{ $books->count() }} buku)</div>
    <div style="overflow-x:auto;">
        <table class="tbl">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Judul</th>
                    <th>Kategori</th>
                    <th>Penulis</th>
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
                    <td><span class="badge-blue">{{ $book->category->name ?? '-' }}</span></td>
                    <td>{{ $book->author }}</td>
                    <td>{{ $book->publisher }}</td>
                    <td>{{ $book->published_year ?? '-' }}</td>
                    <td>
                        @if($book->stock == 0)
                            <span class="badge-red">Habis</span>
                        @elseif($book->stock <= 3)
                            <span class="badge-yellow">{{ $book->stock }}</span>
                        @else
                            <span class="badge-green">{{ $book->stock }}</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" style="text-align:center;color:#aaa;padding:30px;">Tidak ada buku.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection
