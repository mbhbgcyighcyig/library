@extends('layouts.user')

@section('title', $book->title . ' - Bookify')
@section('pageTitle', 'Detail Buku')
@section('backUrl', route('books.catalog'))

@section('content')

@push('styles')
<style>
.book-detail-card {
    background:white; border-radius:18px; padding:28px;
    margin-bottom:22px; box-shadow:0 4px 16px rgba(0,0,0,0.1);
    display:flex; gap:28px;
}
.book-cover-wrap { width:200px; flex-shrink:0; display:flex; flex-direction:column; align-items:center; gap:14px; }
.book-cover-img { width:180px; height:260px; object-fit:cover; border-radius:12px; box-shadow:0 4px 12px rgba(0,0,0,0.15); }
.book-cover-placeholder {
    width:180px; height:260px; border-radius:12px;
    background:linear-gradient(135deg,#3a6ea5,#5a8fa8);
    display:flex; flex-direction:column; align-items:center;
    justify-content:center; color:white; text-align:center; padding:18px;
    box-shadow:0 4px 12px rgba(0,0,0,0.15);
}
.book-cover-placeholder i { font-size:52px; margin-bottom:10px; opacity:0.8; }
.book-cover-placeholder span { font-size:13px; font-weight:600; line-height:1.4; }
.stock-badge { background:#f0f7f4; border-radius:10px; padding:12px 18px; text-align:center; width:100%; }
.stock-badge .stock-label { font-size:11px; color:#666; margin-bottom:3px; }
.stock-badge .stock-num { font-size:26px; font-weight:700; color:#1a3a5c; }
.stock-badge.habis .stock-num { color:#dc2626; }

.book-info { flex:1; }
.book-info h1 { font-size:24px; font-weight:700; color:#1a3a5c; margin-bottom:8px; line-height:1.3; }
.book-category { display:inline-block; background:#dbeafe; color:#1e40af; padding:4px 14px; border-radius:20px; font-size:12px; font-weight:600; margin-bottom:18px; }
.info-row { display:flex; gap:8px; margin-bottom:9px; font-size:14px; }
.info-label { color:#888; min-width:90px; }
.info-value { color:#333; font-weight:500; }
.book-summary { margin-top:18px; padding:14px; background:#f8fafc; border-radius:10px; border-left:4px solid #3a6ea5; font-size:13px; color:#555; line-height:1.7; }
.btn-pinjam-main {
    display:inline-flex; align-items:center; gap:8px;
    background:#2ecc71; color:white; border:none; border-radius:10px;
    padding:11px 24px; font-size:14px; font-weight:700; cursor:pointer;
    font-family:'Poppins',sans-serif; text-decoration:none; margin-top:20px;
    transition:background 0.15s;
}
.btn-pinjam-main:hover { background:#27ae60; color:white; }
.btn-pinjam-disabled { background:#ccc; cursor:not-allowed; }

/* REVIEWS */
.section-title { font-size:18px; font-weight:700; color:white; margin-bottom:14px; display:flex; align-items:center; gap:8px; }
.review-form-card { background:white; border-radius:14px; padding:20px; margin-bottom:14px; box-shadow:0 2px 10px rgba(0,0,0,0.08); }
.form-label { font-size:12px; font-weight:600; color:#666; text-transform:uppercase; letter-spacing:0.4px; margin-bottom:6px; display:block; }
.star-select { display:flex; gap:6px; margin-bottom:10px; }
.star-opt { font-size:26px; cursor:pointer; color:#ddd; transition:color 0.1s; user-select:none; }
.star-opt.active { color:#f59e0b; }
.form-field { width:100%; padding:10px 14px; border:1.5px solid #c8dff0; border-radius:8px; font-size:13px; font-family:'Poppins',sans-serif; color:#333; background:#f7fbff; outline:none; transition:border 0.15s; resize:vertical; }
.form-field:focus { border-color:#3a6ea5; background:white; }
.btn-submit { background:#3a6ea5; color:white; border:none; border-radius:8px; padding:9px 22px; font-size:13px; font-weight:600; cursor:pointer; font-family:'Poppins',sans-serif; transition:background 0.15s; display:inline-flex; align-items:center; gap:6px; }
.btn-submit:hover { background:#2a5a8a; }

.review-card { background:white; border-radius:14px; padding:16px 18px; margin-bottom:12px; box-shadow:0 2px 10px rgba(0,0,0,0.08); }
.reviewer-name { font-size:14px; font-weight:700; color:#1a3a5c; }
.review-date { font-size:12px; color:#999; }
.review-stars { color:#f59e0b; font-size:15px; margin:6px 0; }
.review-text { font-size:13px; color:#555; line-height:1.6; }
.review-actions { display:flex; gap:8px; margin-top:10px; }
.btn-edit-r { padding:4px 12px; border-radius:6px; font-size:12px; font-weight:600; cursor:pointer; border:1.5px solid #3a6ea5; color:#3a6ea5; background:transparent; font-family:'Poppins',sans-serif; text-decoration:none; display:inline-block; }
.btn-del-r { padding:4px 12px; border-radius:6px; font-size:12px; font-weight:600; cursor:pointer; border:none; color:#dc2626; background:#fee2e2; font-family:'Poppins',sans-serif; }
</style>
@endpush

<!-- DETAIL BUKU -->
<div class="book-detail-card">
    <div class="book-cover-wrap">
        @if($book->cover)
            <img src="{{ asset('storage/'.$book->cover) }}" class="book-cover-img" alt="{{ $book->title }}">
        @else
            <div class="book-cover-placeholder">
                <i class="fas fa-book"></i>
                <span>{{ $book->title }}</span>
            </div>
        @endif
        <div class="stock-badge {{ $book->stock == 0 ? 'habis' : '' }}">
            <div class="stock-label">Stok Tersedia</div>
            <div class="stock-num">{{ $book->stock }}</div>
        </div>
    </div>

    <div class="book-info">
        <h1>{{ $book->title }}</h1>
        <span class="book-category">{{ $book->category->name ?? 'Umum' }}</span>

        <div class="info-row">
            <span class="info-label"><i class="fas fa-pen"></i> Penulis</span>
            <span class="info-value">{{ $book->author ?? '-' }}</span>
        </div>
        <div class="info-row">
            <span class="info-label"><i class="fas fa-building"></i> Penerbit</span>
            <span class="info-value">{{ $book->publisher ?? '-' }}</span>
        </div>
        <div class="info-row">
            <span class="info-label"><i class="fas fa-calendar"></i> Tahun</span>
            <span class="info-value">{{ $book->published_year ?? '-' }}</span>
        </div>
        <div class="info-row">
            <span class="info-label"><i class="fas fa-box"></i> Stok</span>
            <span class="info-value" style="{{ $book->stock > 0 ? 'color:#16a34a;' : 'color:#dc2626;' }}font-weight:700;">
                {{ $book->stock > 0 ? $book->stock . ' tersedia' : 'Habis' }}
            </span>
        </div>

        @if($book->summary)
        <div class="book-summary">
            <strong style="color:#1a3a5c;display:block;margin-bottom:5px;">Ringkasan</strong>
            {{ $book->summary }}
        </div>
        @endif

        @auth
            @if($book->stock > 0)
            <a href="{{ route('books.borrow', $book) }}" class="btn-pinjam-main">
                <i class="fas fa-book-reader"></i> Pinjam Buku Ini
            </a>
            @else
            <span class="btn-pinjam-main btn-pinjam-disabled">
                <i class="fas fa-times-circle"></i> Stok Habis
            </span>
            @endif
        @else
        <a href="{{ route('login') }}" class="btn-pinjam-main">
            <i class="fas fa-sign-in-alt"></i> Login untuk Pinjam
        </a>
        @endauth
    </div>
</div>

<!-- ULASAN -->
<div id="ulasan">
    <div class="section-title">
        <i class="fas fa-star"></i> Ulasan Pembaca ({{ $reviews->count() }})
    </div>

    @auth
    @if($canReview)
    <div class="review-form-card">
        <div style="font-size:14px;font-weight:700;color:#1a3a5c;margin-bottom:12px;">Tulis Ulasan</div>
        <form action="{{ route('books.reviews.store', $book) }}" method="POST">
            @csrf
            <div style="margin-bottom:10px;">
                <label class="form-label">Rating</label>
                <div class="star-select" id="star-select">
                    @for($i=1;$i<=5;$i++)
                    <span class="star-opt" data-val="{{ $i }}" onclick="setStarRating({{ $i }})">★</span>
                    @endfor
                </div>
                <input type="hidden" name="rating" id="rating-input" value="5">
            </div>
            <div style="margin-bottom:10px;">
                <textarea name="comment" class="form-field" rows="3" placeholder="Tulis ulasan kamu..." required></textarea>
            </div>
            <button type="submit" class="btn-submit"><i class="fas fa-paper-plane"></i> Kirim Ulasan</button>
        </form>
    </div>
    @else
    <div class="review-form-card" style="text-align:center;padding:20px;">
        <p style="color:#666;font-size:13px;margin-bottom:10px;">
            <i class="fas fa-info-circle" style="color:#3a6ea5;margin-right:6px;"></i>
            Anda hanya bisa memberikan ulasan setelah mengembalikan buku ini
        </p>
    </div>
    @endif
    @else
    <div class="review-form-card" style="text-align:center;padding:20px;">
        <p style="color:#666;font-size:13px;margin-bottom:10px;">Login untuk menulis ulasan</p>
        <a href="{{ route('login') }}" class="btn-submit" style="text-decoration:none;display:inline-flex;">Login</a>
    </div>
    @endauth

    @forelse($reviews as $review)
    <div class="review-card">
        <div style="display:flex;justify-content:space-between;align-items:flex-start;">
            <div>
                <div class="reviewer-name">{{ $review->user->name ?? 'Anonim' }}</div>
                <div class="review-date">{{ $review->created_at->format('d M Y') }}</div>
            </div>
            <div class="review-stars">
                @for($s=1;$s<=5;$s++){{ $s<=$review->rating ? '★' : '☆' }}@endfor
                <span style="font-size:11px;color:#999;margin-left:3px;">({{ $review->rating }}/5)</span>
            </div>
        </div>
        <div class="review-text" style="margin-top:8px;">{{ $review->comment }}</div>
        @auth
            @if(auth()->id() === $review->user_id)
            <div class="review-actions">
                <a href="{{ route('books.reviews.edit', [$book, $review]) }}" class="btn-edit-r">
                    <i class="fas fa-edit"></i> Edit
                </a>
                <form action="{{ route('books.reviews.destroy', [$book, $review]) }}" method="POST" style="display:inline;" onsubmit="return confirm('Hapus ulasan ini?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn-del-r"><i class="fas fa-trash"></i> Hapus</button>
                </form>
            </div>
            @endif
        @endauth
    </div>
    @empty
    <div style="text-align:center;padding:36px;color:rgba(255,255,255,0.7);">
        <i class="fas fa-star" style="font-size:36px;display:block;margin-bottom:10px;opacity:0.5;"></i>
        <p style="font-size:13px;">Belum ada ulasan. Jadilah yang pertama!</p>
    </div>
    @endforelse
</div>

@push('scripts')
<script>
function setStarRating(val) {
    document.getElementById('rating-input').value = val;
    document.querySelectorAll('.star-opt').forEach(function(s, i) {
        s.style.color = i < val ? '#f59e0b' : '#ddd';
    });
}
setStarRating(5);
</script>
@endpush

@endsection
