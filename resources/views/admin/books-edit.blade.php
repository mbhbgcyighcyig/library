@extends('layouts.admin')

@section('title', 'Edit Buku - Admin Bookify')

@section('content')

<div class="page-header">
    <h1>Edit Buku</h1>
</div>

<div class="card-box">
    <div class="card-title">Edit Data Buku</div>

    <form action="{{ route('admin.books.update', $book) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PATCH')

        <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:12px;margin-bottom:12px;">

            <select name="category_id" class="form-field" required>
                <option value="">Pilih Kategori</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ $book->category_id == $cat->id ? 'selected' : '' }}>
                        {{ $cat->name }}
                    </option>
                @endforeach
            </select>

            <input type="text" name="title" class="form-field" placeholder="Judul Buku" value="{{ old('title', $book->title) }}" required>

            <input type="text" name="author" class="form-field" placeholder="Penulis" value="{{ old('author', $book->author) }}" required>

            <input type="text" name="publisher" class="form-field" placeholder="Penerbit" value="{{ old('publisher', $book->publisher) }}" required>

            <input type="number"
                   name="published_year"
                   class="form-field"
                   placeholder="Tahun Terbit"
                   min="1900"
                   max="2099"
                   value="{{ old('published_year', $book->published_year) }}">

            <input type="number"
                   name="stock"
                   class="form-field"
                   placeholder="Stok"
                   min="0"
                   value="{{ old('stock', $book->stock) }}"
                   required>

            {{-- COVER UPLOAD --}}
            <input type="file"
                   name="cover"
                   class="form-field"
                   accept="image/*">

            <div style="grid-column:1/-1;">
                <textarea name="summary"
                          class="form-field"
                          placeholder="Ringkasan buku (opsional)"
                          rows="3">{{ old('summary', $book->summary) }}</textarea>
            </div>

        </div>

        @if($book->cover)
        <div style="margin-bottom:16px;">
            <label style="display:block;margin-bottom:8px;font-weight:600;font-size:14px;">Cover Saat Ini:</label>
            <img src="{{ asset('storage/'.$book->cover) }}"
                 width="150"
                 height="200"
                 style="object-fit:cover;border-radius:12px;border:1px solid #ddd;box-shadow:0 4px 12px rgba(0,0,0,0.1);">
            <p style="margin-top:8px;font-size:12px;color:#888;">Upload file baru untuk mengganti cover</p>
        </div>
        @endif

        <div style="display:flex;gap:12px;">
            <button type="submit" class="btn-primary">
                <i class="fas fa-save"></i>
                Update Buku
            </button>
            
            <a href="{{ route('admin.books') }}" class="btn-secondary">
                <i class="fas fa-arrow-left"></i>
                Kembali
            </a>
        </div>

    </form>
</div>

@endsection