@extends('layouts.app')

@section('title', 'Ulasan Buku - Perpustakaan Online')

@section('content')
<div class="row" style="padding: 40px 0;">
    <div class="col-md-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 style="color: #333;"><i class="fas fa-comments"></i> Ulasan untuk {{ $book->title }}</h2>
                <p style="color: #666;">Baca semua review dari pengguna perpustakaan.</p>
            </div>
            <a href="{{ route('books.show', $book) }}" class="btn btn-secondary-custom btn-custom">Kembali</a>
        </div>

        <div class="card card-custom mb-4">
            <div class="card-body p-4">
                @if(session('success'))
                    <div class="alert alert-success-custom alert-custom mb-4">
                        {{ session('success') }}
                    </div>
                @endif
                @if($errors->any())
                    <div class="alert alert-danger-custom alert-custom mb-4">
                        @foreach($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                    </div>
                @endif
                <form action="{{ route('books.reviews.store', $book) }}" method="POST">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-2">
                            <select name="rating" class="form-select form-control-custom" required>
                                <option value="">Rating</option>
                                @for($i = 1; $i <= 5; $i++)
                                    <option value="{{ $i }}">{{ $i }} bintang</option>
                                @endfor
                            </select>
                        </div>
                        <div class="col-md-8">
                            <textarea name="comment" class="form-control form-control-custom" rows="1" placeholder="Tulis komentar..." required></textarea>
                        </div>
                        <div class="col-md-2 d-grid">
                            <button class="btn btn-primary-custom btn-custom">Kirim Ulasan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        @forelse($reviews as $review)
            <div class="card card-custom mb-3">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <h5 style="color: #333; margin-bottom: 0;">{{ $review->user->name }}</h5>
                            <small style="color: #999;">{{ $review->created_at->format('d M Y') }}</small>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <span class="badge bg-primary">{{ $review->rating }}/5</span>
                            @auth
                                @if(Auth::id() === $review->user_id)
                                    <a href="{{ route('books.reviews.edit', [$book, $review]) }}" class="btn btn-outline-secondary btn-sm">Edit</a>
                                    <form action="{{ route('books.reviews.destroy', [$book, $review]) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger btn-sm">Hapus</button>
                                    </form>
                                @endif
                            @endauth
                        </div>
                    </div>
                    <p style="color: #555;">{{ $review->comment }}</p>
                </div>
            </div>
        @empty
            <div class="card card-custom">
                <div class="card-body p-4 text-center text-muted">
                    Belum ada ulasan untuk buku ini.
                </div>
            </div>
        @endforelse
    </div>
</div>
@endsection
