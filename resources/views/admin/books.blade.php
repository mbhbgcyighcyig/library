@extends('layouts.admin')

@section('title', 'Data Buku - Admin Bookify')

@section('content')

<div class="page-header">
    <h1>Data Buku</h1>
</div>

<div class="card-box">
    <div class="card-title">Tambah Buku Baru</div>

    <form action="{{ route('admin.books.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:12px;margin-bottom:12px;">

            <select name="category_id" class="form-field" required>
                <option value="">Pilih Kategori</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}">
                        {{ $cat->name }}
                    </option>
                @endforeach
            </select>

            <input type="text" name="title" class="form-field" placeholder="Judul Buku" required>

            <input type="text" name="author" class="form-field" placeholder="Penulis" required>

            <input type="text" name="publisher" class="form-field" placeholder="Penerbit" required>

            <input type="number"
                   name="published_year"
                   class="form-field"
                   placeholder="Tahun Terbit"
                   min="1900"
                   max="2099">

            <input type="number"
                   name="stock"
                   class="form-field"
                   placeholder="Stok"
                   min="0"
                   required>

            {{-- TAMBAHAN COVER --}}
            <input type="file"
                   name="cover"
                   class="form-field"
                   accept="image/*">

            <div style="grid-column:1/-1;">
                <input type="text"
                       name="summary"
                       class="form-field"
                       placeholder="Ringkasan buku (opsional)">
            </div>

        </div>

        <button type="submit" class="btn-primary">
            <i class="fas fa-plus"></i>
            Tambah Buku
        </button>

    </form>
</div>


<div class="card-box">

<div class="card-title">
Daftar Buku ({{ $books->count() }} buku)
</div>

<div style="overflow-x:auto;">

<table class="tbl">

<thead>
<tr>
    <th>No</th>
    <th>Cover</th>
    <th>Judul</th>
    <th>Kategori</th>
    <th>Penulis</th>
    <th>Penerbit</th>
    <th>Tahun</th>
    <th>Stok</th>
    <th>Aksi</th>
</tr>
</thead>

<tbody>

@forelse($books as $i => $book)

<tr>

<td>{{ $i+1 }}</td>

<td>

@if($book->cover)

<img src="{{ asset('storage/'.$book->cover) }}"
     width="60"
     height="80"
     style="object-fit:cover;border-radius:8px;">

@else

<span style="color:#999">
Tidak ada
</span>

@endif

</td>

<td style="font-weight:600;">
{{ $book->title }}
</td>

<td>
<span class="badge-blue">
{{ $book->category->name ?? '-' }}
</span>
</td>

<td>{{ $book->author }}</td>

<td>{{ $book->publisher }}</td>

<td>{{ $book->published_year ?? '-' }}</td>

<td>

@if($book->stock==0)

<span class="badge-red">
Habis
</span>

@elseif($book->stock<=3)

<span class="badge-yellow">
{{ $book->stock }}
</span>

@else

<span class="badge-green">
{{ $book->stock }}
</span>

@endif

</td>

<td>

<form action="{{ route('admin.books.destroy',$book) }}"
method="POST"
style="display:inline;"
onsubmit="return confirm('Hapus buku ini?')">

@csrf
@method('DELETE')

<button type="submit" class="btn-danger">
<i class="fas fa-trash"></i>
</button>

</form>

</td>

</tr>

@empty

<tr>
<td colspan="9"
style="text-align:center;padding:30px;">
Belum ada buku
</td>
</tr>

@endforelse

</tbody>
</table>
</div>
</div>

@endsection