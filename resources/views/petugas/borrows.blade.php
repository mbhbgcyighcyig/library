@extends('layouts.petugas')

@section('title', 'Peminjaman - Petugas Bookify')

@section('content')

<div class="page-header">
    <h1>Peminjaman &amp; Pengembalian</h1>
</div>

<!-- STAT MINI -->
<div style="display:grid;grid-template-columns:repeat(2,1fr);gap:14px;margin-bottom:20px;">
    <div class="stat-card" style="background:#fff3cd;border-radius:12px;padding:16px 20px;box-shadow:0 2px 8px rgba(0,0,0,0.07);">
        <div style="font-size:12px;color:#856404;margin-bottom:4px;font-weight:600;">⏳ Menunggu Persetujuan</div>
        <div style="font-size:28px;font-weight:700;color:#856404;">{{ $totalMenunggu }}</div>
    </div>
    <div class="stat-card" style="background:#dbeafe;border-radius:12px;padding:16px 20px;box-shadow:0 2px 8px rgba(0,0,0,0.07);">
        <div style="font-size:12px;color:#1e40af;margin-bottom:4px;font-weight:600;">🔄 Menunggu Konfirmasi Kembali</div>
        <div style="font-size:28px;font-weight:700;color:#1e40af;">{{ $totalMenungguKembali }}</div>
    </div>
</div>

<div class="card-box">
    <div class="card-title">Semua Data Peminjaman</div>
    <div style="overflow-x:auto;">
        <table class="tbl">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Pengguna</th>
                    <th>Buku</th>
                    <th>Tgl Pinjam</th>
                    <th>Jatuh Tempo</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($borrows as $i => $borrow)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td style="font-weight:600;">{{ $borrow->user->name ?? '-' }}</td>
                    <td>{{ $borrow->book->title ?? '-' }}</td>
                    <td>{{ $borrow->borrowed_at }}</td>
                    <td>{{ $borrow->return_date ?? '-' }}</td>
                    <td><span class="{{ $borrow->statusColor() }}">{{ $borrow->statusLabel() }}</span></td>
                    <td>
                        @if($borrow->status === 'menunggu')
                            {{-- Approve --}}
                            <form action="{{ route('petugas.borrows.approve', $borrow) }}" method="POST" style="display:inline;" onsubmit="return confirm('Setujui peminjaman ini?')">
                                @csrf
                                <button type="submit" class="btn-success" style="padding:5px 12px;font-size:12px;border-radius:6px;border:none;cursor:pointer;font-family:inherit;">
                                    ✓ Setujui
                                </button>
                            </form>
                            {{-- Tolak --}}
                            <button onclick="showRejectModal({{ $borrow->id }})" class="btn-danger" style="padding:5px 12px;font-size:12px;border-radius:6px;border:none;cursor:pointer;font-family:inherit;margin-left:4px;">
                                ✗ Tolak
                            </button>

                        @elseif($borrow->status === 'menunggu_kembali')
                            {{-- Konfirmasi kembali --}}
                            <form action="{{ route('petugas.borrows.confirm.return', $borrow) }}" method="POST" style="display:inline;" onsubmit="return confirm('Konfirmasi pengembalian buku ini?')">
                                @csrf
                                <button type="submit" class="btn-success" style="padding:5px 12px;font-size:12px;border-radius:6px;border:none;cursor:pointer;font-family:inherit;">
                                    ✓ Konfirmasi Kembali
                                </button>
                            </form>

                        @elseif($borrow->status === 'dipinjam')
                            <span class="badge-green">Sedang Dipinjam</span>

                        @elseif($borrow->status === 'dikembalikan')
                            <span class="badge-gray">Selesai</span>

                        @elseif($borrow->status === 'ditolak')
                            <span class="badge-red">Ditolak</span>
                            @if($borrow->catatan)
                                <div style="font-size:11px;color:#999;margin-top:2px;">{{ $borrow->catatan }}</div>
                            @endif
                        @endif
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" style="text-align:center;color:#aaa;padding:30px;">Tidak ada data peminjaman.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- MODAL TOLAK --}}
<div id="reject-modal" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,0.5);z-index:999;align-items:center;justify-content:center;">
    <div style="background:white;border-radius:16px;padding:28px;width:420px;box-shadow:0 8px 32px rgba(0,0,0,0.2);">
        <div style="font-size:17px;font-weight:700;color:#1a3a5c;margin-bottom:16px;">Tolak Pengajuan</div>
        <form id="reject-form" method="POST">
            @csrf
            <div style="margin-bottom:14px;">
                <label style="font-size:13px;font-weight:600;color:#555;display:block;margin-bottom:6px;">Alasan Penolakan (opsional)</label>
                <textarea name="catatan" rows="3" style="width:100%;padding:10px 14px;border:1.5px solid #c8e0d4;border-radius:8px;font-size:13px;font-family:inherit;outline:none;resize:vertical;" placeholder="Contoh: Stok sedang dalam perbaikan..."></textarea>
            </div>
            <div style="display:flex;gap:10px;justify-content:flex-end;">
                <button type="button" onclick="closeRejectModal()" style="padding:9px 20px;border-radius:8px;border:1.5px solid #ccc;background:white;font-size:13px;font-weight:600;cursor:pointer;font-family:inherit;">Batal</button>
                <button type="submit" class="btn-danger" style="padding:9px 20px;border-radius:8px;border:none;font-size:13px;font-weight:600;cursor:pointer;font-family:inherit;">Tolak</button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
function showRejectModal(id) {
    document.getElementById('reject-form').action = '/petugas/borrows/' + id + '/reject';
    var modal = document.getElementById('reject-modal');
    modal.style.display = 'flex';
}
function closeRejectModal() {
    document.getElementById('reject-modal').style.display = 'none';
}
</script>
@endpush

@endsection
