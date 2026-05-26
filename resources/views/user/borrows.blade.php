@extends('layouts.user')

@section('title', 'Riwayat Peminjaman - Bookify')
@section('pageTitle', 'Riwayat Peminjaman')
@section('backUrl', route('dashboard'))

@section('content')

@push('styles')
<style>
.page-title { font-size:22px; font-weight:700; color:white; margin-bottom:14px; text-shadow:0 1px 3px rgba(0,0,0,0.2); }
.info-box { background:rgba(255,255,255,0.18); border-radius:10px; padding:12px 16px; margin-bottom:18px; color:white; font-size:12px; line-height:1.9; }
.card-box { background:white; border-radius:14px; padding:20px 22px; box-shadow:0 2px 10px rgba(0,0,0,0.08); margin-bottom:18px; }
.card-title { font-size:15px; font-weight:700; color:#1a3a5c; margin-bottom:16px; }
.tbl { width:100%; border-collapse:collapse; font-size:13px; }
.tbl thead tr { background:#eef5fb; }
.tbl th { padding:10px 14px; text-align:left; color:#3a6ea5; font-weight:600; font-size:12px; text-transform:uppercase; }
.tbl td { padding:11px 14px; color:#333; border-bottom:1px solid #f0f5fa; vertical-align:middle; }
.tbl tbody tr:hover { background:#f7fbff; }
.tbl tbody tr:last-child td { border-bottom:none; }
.badge-green  { background:#d0f0e0; color:#1a6640; padding:4px 12px; border-radius:20px; font-size:11px; font-weight:600; white-space:nowrap; }
.badge-yellow { background:#fff3cd; color:#856404; padding:4px 12px; border-radius:20px; font-size:11px; font-weight:600; white-space:nowrap; }
.badge-blue   { background:#dbeafe; color:#1e40af; padding:4px 12px; border-radius:20px; font-size:11px; font-weight:600; white-space:nowrap; }
.badge-red    { background:#fee2e2; color:#991b1b; padding:4px 12px; border-radius:20px; font-size:11px; font-weight:600; white-space:nowrap; }
.badge-gray   { background:#f3f4f6; color:#6b7280; padding:4px 12px; border-radius:20px; font-size:11px; font-weight:600; white-space:nowrap; }
.btn-sm { padding:5px 12px; border-radius:6px; font-size:12px; font-weight:600; cursor:pointer; border:none; font-family:'Poppins',sans-serif; text-decoration:none; display:inline-block; }
.btn-outline { background:transparent; border:1.5px solid #3a6ea5; color:#3a6ea5; }
.btn-outline:hover { background:#3a6ea5; color:white; }
.btn-return { background:#f59e0b; color:white; }
.btn-return:hover { background:#d97706; }
</style>
@endpush

<div class="page-title">Riwayat Peminjaman</div>

<div class="info-box">
    <i class="fas fa-info-circle"></i> <strong>Alur:</strong>
    Ajukan pinjam →
    <span style="background:rgba(255,255,255,0.25);padding:2px 8px;border-radius:10px;">Menunggu Persetujuan</span> →
    Disetujui petugas →
    <span style="background:rgba(255,255,255,0.25);padding:2px 8px;border-radius:10px;">Dipinjam</span> →
    Klik "Minta Kembalikan" →
    <span style="background:rgba(255,255,255,0.25);padding:2px 8px;border-radius:10px;">Menunggu Konfirmasi</span> →
    Dikonfirmasi →
    <span style="background:rgba(255,255,255,0.25);padding:2px 8px;border-radius:10px;">Selesai</span>
</div>

<div class="card-box">
    <div class="card-title">Semua Peminjaman Saya ({{ $borrows->count() }} data)</div>
    <div style="overflow-x:auto;">
        <table class="tbl">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Judul Buku</th>
                    <th>Tgl Pinjam</th>
                    <th>Jatuh Tempo</th>
                    <th>Status</th>
                    <th>Catatan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($borrows as $i => $borrow)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td style="font-weight:600;">{{ $borrow->book->title ?? '-' }}</td>
                    <td>{{ $borrow->borrowed_at }}</td>
                    <td>{{ $borrow->return_date ?? '-' }}</td>
                    <td><span class="{{ $borrow->statusColor() }}">{{ $borrow->statusLabel() }}</span></td>
                    <td style="font-size:12px;color:#888;">{{ $borrow->catatan ?? '-' }}</td>
                    <td>
                        @if($borrow->status === 'menunggu')
                            <span style="font-size:12px;color:#856404;"><i class="fas fa-clock"></i> Menunggu...</span>

                        @elseif($borrow->status === 'dipinjam')
                            <form action="{{ route('borrows.request.return', $borrow) }}" method="POST" style="display:inline;" onsubmit="return confirm('Ajukan pengembalian buku ini?')">
                                @csrf
                                <button type="submit" class="btn-sm btn-return">
                                    <i class="fas fa-undo"></i> Minta Kembalikan
                                </button>
                            </form>
                            <a href="{{ route('borrows.print', $borrow) }}" class="btn-sm btn-outline" target="_blank" style="margin-left:4px;">
                                <i class="fas fa-print"></i>
                            </a>

                        @elseif($borrow->status === 'menunggu_kembali')
                            <span style="font-size:12px;color:#1e40af;"><i class="fas fa-clock"></i> Menunggu konfirmasi</span>
                            <a href="{{ route('borrows.print', $borrow) }}" class="btn-sm btn-outline" target="_blank" style="margin-left:4px;">
                                <i class="fas fa-print"></i>
                            </a>

                        @elseif($borrow->status === 'dikembalikan')
                            <a href="{{ route('borrows.print', $borrow) }}" class="btn-sm btn-outline" target="_blank">
                                <i class="fas fa-print"></i> Cetak
                            </a>

                        @elseif($borrow->status === 'ditolak')
                            <span style="font-size:12px;color:#991b1b;"><i class="fas fa-times-circle"></i> Ditolak</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" style="text-align:center;color:#aaa;padding:30px;">
                        <i class="fas fa-inbox" style="font-size:36px;display:block;margin-bottom:10px;"></i>
                        Belum ada riwayat peminjaman.
                        <a href="{{ route('books.catalog') }}" style="display:block;margin-top:8px;color:#3a6ea5;font-weight:600;">
                            <i class="fas fa-book-open"></i> Lihat Katalog Buku
                        </a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection
