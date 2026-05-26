@extends('layouts.user')

@section('title', 'Katalog Buku - Bookify')
@section('pageTitle', 'Katalog Buku')
@section('backUrl', route('dashboard'))

@section('content')

@push('styles')
<style>
.page-title { font-size:22px; font-weight:700; color:white; margin-bottom:18px; text-shadow:0 1px 3px rgba(0,0,0,0.2); }
.search-bar { position:relative; margin-bottom:18px; }
.search-bar i { position:absolute; left:14px; top:50%; transform:translateY(-50%); color:#999; font-size:14px; }
.search-bar input { width:100%; background:white; border:none; outline:none; border-radius:24px; padding:11px 18px 11px 40px; font-size:14px; font-family:'Poppins',sans-serif; color:#333; box-shadow:0 2px 8px rgba(0,0,0,0.1); }
.filter-bar { display:flex; gap:8px; margin-bottom:18px; flex-wrap:wrap; }
.filter-btn { padding:7px 16px; border-radius:20px; border:1.5px solid rgba(255,255,255,0.5); background:rgba(255,255,255,0.2); color:white; font-size:13px; font-weight:500; cursor:pointer; font-family:'Poppins',sans-serif; transition:all 0.15s; }
.filter-btn:hover, .filter-btn.active { background:white; color:#1a3a5c; border-color:white; }
.books-grid { display:grid; grid-template-columns:repeat(4,1fr); gap:16px; }
.book-card { background:white; border-radius:14px; padding:14px; box-shadow:0 2px 10px rgba(0,0,0,0.08); display:flex; flex-direction:column; transition:transform 0.15s; }
.book-card:hover { transform:translateY(-3px); }
.book-cover { width:100%; height:200px; object-fit:cover; border-radius:10px; margin-bottom:10px; }
.book-cover-placeholder { width:100%; height:200px; border-radius:10px; margin-bottom:10px; background:linear-gradient(135deg,#3a6ea5,#5a8fa8); display:flex; align-items:center; justify-content:center; color:white; font-size:13px; font-weight:600; text-align:center; padding:12px; }
.book-title { font-size:13px; font-weight:700; color:#1a3a5c; line-height:1.3; margin-bottom:3px; }
.book-author { font-size:12px; color:#3a6ea5; margin-bottom:5px; }
.book-cat { font-size:11px; background:#dbeafe; color:#1e40af; padding:2px 8px; border-radius:10px; display:inline-block; margin-bottom:8px; }
.book-stock { font-size:11px; color:#888; margin-bottom:8px; }
.btn-pinjam { width:100%; background:#2ecc71; color:white; border:none; border-radius:20px; padding:9px; font-size:13px; font-weight:600; cursor:pointer; font-family:'Poppins',sans-serif; transition:background 0.15s; text-decoration:none; display:block; text-align:center; margin-top:auto; }
.btn-pinjam:hover { background:#27ae60; color:white; }
.btn-pinjam-disabled { background:#ccc; cursor:not-allowed; }
.btn-detail { width:100%; background:transparent; color:#3a6ea5; border:1.5px solid #3a6ea5; border-radius:20px; padding:7px; font-size:12px; font-weight:600; cursor:pointer; font-family:'Poppins',sans-serif; text-decoration:none; display:block; text-align:center; margin-bottom:6px; transition:all 0.15s; }
.btn-detail:hover { background:#3a6ea5; color:white; }
.empty-state { text-align:center; padding:60px 20px; color:rgba(255,255,255,0.7); }
.empty-state i { font-size:48px; display:block; margin-bottom:14px; opacity:0.6; }
@media(max-width:900px){ .books-grid{ grid-template-columns:repeat(2,1fr); } }
</style>
@endpush

<div class="page-title">Katalog Buku</div>

<!-- SEARCH -->
<div class="search-bar">
    <i class="fas fa-search"></i>
    <input type="text" id="searchInput" placeholder="Cari judul atau penulis..." oninput="filterBooks()">
</div>

<!-- FILTER KATEGORI -->
<div class="filter-bar">
    <button class="filter-btn active" onclick="filterKat('semua',this)">Semua</button>
    @foreach($categories as $cat)
        <button class="filter-btn" onclick="filterKat('{{ $cat->id }}',this)">{{ $cat->name }}</button>
    @endforeach
</div>

<!-- GRID BUKU -->
@if($books->count() > 0)
<div class="books-grid" id="books-grid">
    @foreach($books as $book)
    <div class="book-card" data-title="{{ strtolower($book->title) }} {{ strtolower($book->author ?? '') }}" data-cat="{{ $book->category_id }}">
        @if($book->cover)
            <img src="{{ asset('storage/'.$book->cover) }}" class="book-cover" alt="{{ $book->title }}">
        @else
            <div class="book-cover-placeholder">{{ $book->title }}</div>
        @endif
        <div class="book-title">{{ $book->title }}</div>
        <div class="book-author">{{ $book->author ?? '-' }}</div>
        <span class="book-cat">{{ $book->category->name ?? 'Umum' }}</span>
        <div class="book-stock">
            @if($book->stock > 0)
                <span style="color:#16a34a;"><i class="fas fa-check-circle"></i> Tersedia ({{ $book->stock }})</span>
            @else
                <span style="color:#dc2626;"><i class="fas fa-times-circle"></i> Stok Habis</span>
            @endif
        </div>
        <a href="{{ route('books.show', $book) }}" class="btn-detail">
            <i class="fas fa-eye"></i> Detail
        </a>
        @auth
            @if($book->stock > 0)
                <a href="{{ route('books.borrow', $book) }}" class="btn-pinjam">
                    <i class="fas fa-book-reader"></i> Pinjam
                </a>
            @else
                <span class="btn-pinjam btn-pinjam-disabled">Stok Habis</span>
            @endif
        @else
            <a href="{{ route('login') }}" class="btn-pinjam">
                <i class="fas fa-sign-in-alt"></i> Login untuk Pinjam
            </a>
        @endauth
    </div>
    @endforeach
</div>
@else
<div class="empty-state">
    <i class="fas fa-book"></i>
    <p>Belum ada buku di katalog.</p>
</div>
@endif

@push('scripts')
<script>
function filterBooks() {
    var q = document.getElementById('searchInput').value.toLowerCase().trim();
    document.querySelectorAll('#books-grid .book-card').forEach(function(card) {
        var txt = card.dataset.title || '';
        card.style.display = txt.includes(q) ? 'flex' : 'none';
    });
}
function filterKat(catId, btn) {
    document.querySelectorAll('.filter-btn').forEach(function(b){ b.classList.remove('active'); });
    btn.classList.add('active');
    document.querySelectorAll('#books-grid .book-card').forEach(function(card) {
        card.style.display = (catId === 'semua' || card.dataset.cat == catId) ? 'flex' : 'none';
    });
}
</script>
@endpush

@endsection
