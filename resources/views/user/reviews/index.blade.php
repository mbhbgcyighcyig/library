@extends('layouts.user')

@section('title', 'Ulasan Saya - Bookify')
@section('pageTitle', 'Ulasan Saya')
@section('backUrl', route('dashboard'))

@section('content')

@push('styles')
<style>
.page-title { font-size:22px; font-weight:700; color:white; margin-bottom:18px; text-shadow:0 1px 3px rgba(0,0,0,0.2); }
.ulasan-card {
    background:white; border-radius:14px; padding:18px 20px;
    margin-bottom:14px; box-shadow:0 2px 10px rgba(0,0,0,0.08);
    display:flex; justify-content:space-between; align-items:flex-start;
}
.ulasan-book { font-size:15px; font-weight:700; color:#1a3a5c; margin-bottom:3px; }
.ulasan-date { font-size:12px; color:#999; margin-bottom:6px; }
.ulasan-stars { color:#f59e0b; font-size:18px; margin-bottom:6px; }
.ulasan-text { font-size:13px; color:#555; line-height:1.6; }
.ulasan-actions { display:flex; gap:8px; margin-left:16px; flex-shrink:0; }
.btn-sm { padding:6px 14px; border-radius:6px; font-size:12px; font-weight:600; cursor:pointer; font-family:'Poppins',sans-serif; text-decoration:none; display:inline-block; }
.btn-edit { background:transparent; border:1.5px solid #3a6ea5; color:#3a6ea5; }
.btn-edit:hover { background:#3a6ea5; color:white; }
.btn-del { background:#fee2e2; color:#dc2626; border:none; }
.btn-del:hover { background:#fca5a5; }
.empty-state { text-align:center; padding:60px 20px; color:rgba(255,255,255,0.75); }
.empty-state i { font-size:48px; margin-bottom:14px; display:block; opacity:0.6; }
.empty-state p { font-size:14px; margin-bottom:16px; }
.btn-catalog {
    background:white; color:#1a3a5c; border:none; border-radius:10px;
    padding:10px 24px; font-size:14px; font-weight:600; cursor:pointer;
    font-family:'Poppins',sans-serif; text-decoration:none; display:inline-block;
}
.btn-catalog:hover { background:#f0f5fa; color:#1a3a5c; }
</style>
@endpush

<div class="page-title">Ulasan Saya</div>

@if($reviews->count() > 0)
    @foreach($reviews as $review)
    <div class="ulasan-card">
        <div style="flex:1;">
            <div class="ulasan-book">{{ $review->book->title ?? '-' }}</div>
            <div class="ulasan-date">{{ $review->created_at->format('d M Y') }}</div>
            <div class="ulasan-stars">
                @for($s=1;$s<=5;$s++){{ $s<=$review->rating ? '★' : '☆' }}@endfor
                <span style="font-size:12px;color:#999;margin-left:4px;">({{ $review->rating }}/5)</span>
            </div>
            <div class="ulasan-text">{{ $review->comment }}</div>
        </div>
        <div class="ulasan-actions">
            <a href="{{ route('books.reviews.edit', [$review->book, $review]) }}" class="btn-sm btn-edit">
                <i class="fas fa-edit"></i> Edit
            </a>
            <form action="{{ route('books.reviews.destroy', [$review->book, $review]) }}" method="POST" onsubmit="return confirm('Hapus ulasan ini?')">
                @csrf @method('DELETE')
                <button type="submit" class="btn-sm btn-del">
                    <i class="fas fa-trash"></i> Hapus
                </button>
            </form>
        </div>
    </div>
    @endforeach
@else
    <div class="empty-state">
        <i class="fas fa-star"></i>
        <p>Belum ada ulasan. Pinjam buku dulu, lalu beri ulasan dari halaman detail buku.</p>
        <a href="{{ route('books.catalog') }}" class="btn-catalog">
            <i class="fas fa-book-open"></i> Lihat Katalog
        </a>
    </div>
@endif

@endsection
