@extends('layouts.user')

@section('title', 'Ajukan Peminjaman - Bookify')
@section('pageTitle', 'Ajukan Peminjaman')
@section('backUrl', route('books.show', $book))

@section('content')

@push('styles')
<style>
.borrow-wrap {
    display: flex; align-items: flex-start; justify-content: center;
    padding: 10px 0;
}
.borrow-box {
    background: #2b5a8a; border-radius: 20px;
    padding: 32px; display: flex; gap: 32px;
    width: 100%; max-width: 820px;
    box-shadow: 0 8px 32px rgba(0,0,0,0.2);
}
.book-side {
    width: 200px; flex-shrink: 0;
    display: flex; flex-direction: column; align-items: center; gap: 12px;
}
.book-cover-img {
    width: 170px; height: 240px; object-fit: cover;
    border-radius: 12px; box-shadow: 0 4px 16px rgba(0,0,0,0.3);
}
.book-cover-placeholder {
    width: 170px; height: 240px; border-radius: 12px;
    background: linear-gradient(135deg, #4a7aaa, #6a9dc0);
    display: flex; flex-direction: column; align-items: center;
    justify-content: center; color: white; text-align: center; padding: 16px;
    box-shadow: 0 4px 16px rgba(0,0,0,0.3);
}
.book-cover-placeholder i { font-size: 48px; margin-bottom: 10px; opacity: 0.8; }
.book-cover-placeholder span { font-size: 13px; font-weight: 600; line-height: 1.4; }
.book-name { font-size: 15px; font-weight: 700; color: white; text-align: center; line-height: 1.4; }
.book-author-txt { font-size: 12px; color: #a8d0f0; text-align: center; }

.form-side { flex: 1; display: flex; flex-direction: column; }
.form-title { font-size: 24px; font-weight: 700; color: white; margin-bottom: 20px; }

.form-card {
    background: white; border-radius: 14px; padding: 22px;
    display: flex; flex-direction: column; gap: 14px;
}
.form-group { display: flex; flex-direction: column; gap: 5px; }
.form-label { font-size: 12px; font-weight: 600; color: #666; text-transform: uppercase; letter-spacing: 0.4px; }
.form-field-display {
    background: #eef5fb; border-radius: 8px; padding: 11px 14px;
    font-size: 14px; color: #333; font-weight: 500;
    border: 1.5px solid #c8dff0;
}
.form-field {
    width: 100%; padding: 11px 14px;
    border: 1.5px solid #c8dff0; border-radius: 8px;
    font-size: 14px; font-family: 'Poppins', sans-serif; color: #333;
    background: #f7fbff; outline: none; transition: border 0.15s;
}
.form-field:focus { border-color: #3a6ea5; background: white; }
.form-actions { display: flex; gap: 12px; justify-content: flex-end; margin-top: 4px; }
.btn-submit {
    background: #2ecc71; color: white; border: none;
    border-radius: 24px; padding: 11px 28px;
    font-size: 14px; font-weight: 700; cursor: pointer;
    font-family: 'Poppins', sans-serif; transition: background 0.15s;
    display: flex; align-items: center; gap: 7px;
}
.btn-submit:hover { background: #27ae60; }
.btn-cancel {
    background: #e74c3c; color: white; border: none;
    border-radius: 24px; padding: 11px 28px;
    font-size: 14px; font-weight: 700; cursor: pointer;
    font-family: 'Poppins', sans-serif; transition: background 0.15s;
    text-decoration: none; display: flex; align-items: center; gap: 7px;
}
.btn-cancel:hover { background: #c0392b; color: white; }
</style>
@endpush

<div class="borrow-wrap">
    <div class="borrow-box">
        <!-- BOOK SIDE -->
        <div class="book-side">
            @if($book->cover)
                <img src="{{ asset('storage/'.$book->cover) }}" class="book-cover-img" alt="{{ $book->title }}">
            @else
                <div class="book-cover-placeholder">
                    <i class="fas fa-book"></i>
                    <span>{{ $book->title }}</span>
                </div>
            @endif
            <div class="book-name">{{ $book->title }}</div>
            <div class="book-author-txt">{{ $book->author ?? '-' }}</div>
        </div>

        <!-- FORM SIDE -->
        <div class="form-side">
            <div class="form-title">Ajukan Peminjaman</div>
            <div class="form-card">
                <div class="form-group">
                    <div class="form-label">Nama Peminjam</div>
                    <div class="form-field-display">
                        <i class="fas fa-user" style="color:#3a6ea5;margin-right:6px;"></i>
                        {{ auth()->user()->name }}
                    </div>
                </div>
                <div class="form-group">
                    <div class="form-label">Buku yang Dipinjam</div>
                    <div class="form-field-display">
                        <i class="fas fa-book" style="color:#3a6ea5;margin-right:6px;"></i>
                        {{ $book->title }}
                        <span style="color:#888;font-size:12px;margin-left:8px;">(Stok: {{ $book->stock }})</span>
                    </div>
                </div>
                <div class="form-group">
                    <div class="form-label">Tanggal Pinjam</div>
                    <div class="form-field-display">
                        <i class="fas fa-calendar-check" style="color:#3a6ea5;margin-right:6px;"></i>
                        {{ now()->format('d M Y') }}
                    </div>
                </div>
                <form action="{{ route('books.borrow.store', $book) }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label class="form-label" for="return_date">
                            <i class="fas fa-calendar-times" style="color:#e74c3c;margin-right:4px;"></i>
                            Tanggal Kembali
                        </label>
                        <input type="date" id="return_date" name="return_date"
                            class="form-field"
                            value="{{ old('return_date') }}"
                            min="{{ now()->addDay()->format('Y-m-d') }}"
                            required>
                    </div>
                    <div class="form-actions">
                        <button type="submit" class="btn-submit">
                            <i class="fas fa-check"></i> Pinjam
                        </button>
                        <a href="{{ route('books.show', $book) }}" class="btn-cancel">
                            <i class="fas fa-times"></i> Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
