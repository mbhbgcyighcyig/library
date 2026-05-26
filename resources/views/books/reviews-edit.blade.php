@extends('layouts.user')

@section('title', 'Edit Ulasan - Bookify')
@section('pageTitle', 'Edit Ulasan')
@section('backUrl', route('books.reviews.index', $book))

@section('content')

@push('styles')
<style>
.edit-wrap { display:flex; justify-content:center; padding:10px 0; }
.edit-box {
    background:#2b5a8a; border-radius:20px; padding:32px;
    width:100%; max-width:600px; box-shadow:0 8px 32px rgba(0,0,0,0.2);
}
.edit-title { font-size:22px; font-weight:700; color:white; margin-bottom:4px; }
.edit-sub { font-size:13px; color:#a8d0f0; margin-bottom:22px; }
.form-card { background:white; border-radius:14px; padding:24px; }
.form-group { margin-bottom:16px; }
.form-label { font-size:12px; font-weight:600; color:#666; text-transform:uppercase; letter-spacing:0.4px; margin-bottom:6px; display:block; }
.star-select { display:flex; gap:8px; margin-bottom:4px; }
.star-opt { font-size:28px; cursor:pointer; color:#ddd; transition:color 0.1s; user-select:none; }
.star-opt.active { color:#f59e0b; }
.form-field {
    width:100%; padding:11px 14px;
    border:1.5px solid #c8dff0; border-radius:8px;
    font-size:14px; font-family:'Poppins',sans-serif; color:#333;
    background:#f7fbff; outline:none; transition:border 0.15s; resize:vertical;
}
.form-field:focus { border-color:#3a6ea5; background:white; }
.form-actions { display:flex; gap:12px; justify-content:flex-end; margin-top:16px; }
.btn-save {
    background:#2ecc71; color:white; border:none; border-radius:24px;
    padding:11px 28px; font-size:14px; font-weight:700; cursor:pointer;
    font-family:'Poppins',sans-serif; transition:background 0.15s;
    display:flex; align-items:center; gap:7px;
}
.btn-save:hover { background:#27ae60; }
.btn-del {
    background:#e74c3c; color:white; border:none; border-radius:24px;
    padding:11px 28px; font-size:14px; font-weight:700; cursor:pointer;
    font-family:'Poppins',sans-serif; transition:background 0.15s;
    display:flex; align-items:center; gap:7px;
}
.btn-del:hover { background:#c0392b; }
</style>
@endpush

<div class="edit-wrap">
    <div class="edit-box">
        <div class="edit-title">Edit Ulasan</div>
        <div class="edit-sub">{{ $book->title }} &mdash; {{ $book->author ?? '' }}</div>

        <div class="form-card">
            <form action="{{ route('books.reviews.update', [$book, $review]) }}" method="POST">
                @csrf @method('PATCH')

                <div class="form-group">
                    <label class="form-label">Rating</label>
                    <div class="star-select" id="star-select">
                        @for($i=1;$i<=5;$i++)
                        <span class="star-opt {{ $review->rating >= $i ? 'active' : '' }}"
                              data-val="{{ $i }}"
                              onclick="setStarRating({{ $i }})">★</span>
                        @endfor
                    </div>
                    <input type="hidden" name="rating" id="rating-input" value="{{ old('rating', $review->rating) }}">
                </div>

                <div class="form-group">
                    <label class="form-label" for="comment">Komentar</label>
                    <textarea id="comment" name="comment" class="form-field" rows="5" required>{{ old('comment', $review->comment) }}</textarea>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn-save">
                        <i class="fas fa-save"></i> Simpan
                    </button>
                </div>
            </form>

            <form action="{{ route('books.reviews.destroy', [$book, $review]) }}" method="POST"
                  onsubmit="return confirm('Hapus ulasan ini?')"
                  style="margin-top:12px;display:flex;justify-content:flex-end;">
                @csrf @method('DELETE')
                <button type="submit" class="btn-del">
                    <i class="fas fa-trash"></i> Hapus Ulasan
                </button>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
function setStarRating(val) {
    document.getElementById('rating-input').value = val;
    document.querySelectorAll('.star-opt').forEach(function(s, i) {
        s.classList.toggle('active', i < val);
    });
}
</script>
@endpush

@endsection
