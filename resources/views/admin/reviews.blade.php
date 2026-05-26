@extends('layouts.admin')

@section('title', 'Ulasan - Admin Bookify')

@section('content')

<div class="page-header">
    <h1>Ulasan Buku</h1>
</div>

<div class="card-box">
    <div class="card-title">Daftar Ulasan ({{ $reviews->count() }} ulasan)</div>
    <table class="tbl">
        <thead>
            <tr>
                <th>No</th>
                <th>Buku</th>
                <th>Pengguna</th>
                <th>Rating</th>
                <th>Komentar</th>
                <th>Tanggal</th>
            </tr>
        </thead>
        <tbody>
            @forelse($reviews as $i => $review)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td style="font-weight:600;">{{ $review->book->title ?? '-' }}</td>
                <td>{{ $review->user->name ?? '-' }}</td>
                <td>
                    <span style="color:#f59e0b;font-weight:700;">
                        @for($s = 1; $s <= 5; $s++){{ $s <= $review->rating ? '★' : '☆' }}@endfor
                    </span>
                    <span style="color:#999;font-size:11px;">({{ $review->rating }}/5)</span>
                </td>
                <td style="max-width:200px;">{{ $review->comment ?? '-' }}</td>
                <td style="font-size:12px;color:#999;">{{ $review->created_at->format('d M Y') }}</td>
            </tr>
            @empty
            <tr><td colspan="6" style="text-align:center;color:#aaa;padding:30px;">Belum ada ulasan.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection
