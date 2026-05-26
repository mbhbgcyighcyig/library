@extends('layouts.user')

@section('title', 'Bukti Peminjaman - Bookify')
@section('pageTitle', 'Bukti Peminjaman')
@section('backUrl', route('user.borrows'))

@section('content')

@push('styles')
<style>
.bukti-wrap { display:flex; justify-content:center; padding:10px 0; }
.bukti-outer {
    background: #2b5a8a; border-radius: 20px; padding: 28px;
    width: 100%; max-width: 620px;
    box-shadow: 0 8px 32px rgba(0,0,0,0.2);
}
.bukti-paper {
    background: white; border-radius: 14px; padding: 36px 40px;
}
.bukti-header { text-align:center; margin-bottom:24px; padding-bottom:18px; border-bottom:2px dashed #e0e0e0; }
.bukti-logo { font-size:28px; font-weight:700; color:#1a3a5c; margin-bottom:4px; }
.bukti-subtitle { font-size:12px; color:#888; }
.bukti-title { font-size:18px; font-weight:700; color:#1a3a5c; text-align:center; margin-bottom:22px; }
.bukti-section { margin-bottom:18px; }
.bukti-section-title { font-size:11px; font-weight:700; color:#3a6ea5; text-transform:uppercase; letter-spacing:0.5px; margin-bottom:8px; }
.bukti-row { display:flex; gap:8px; margin-bottom:7px; font-size:13px; }
.bukti-label { color:#888; min-width:130px; flex-shrink:0; }
.bukti-value { color:#333; font-weight:500; }
.status-badge { display:inline-block; padding:4px 14px; border-radius:20px; font-size:12px; font-weight:700; }
.status-menunggu { background:#fff3cd; color:#856404; }
.status-dipinjam { background:#d0f0e0; color:#1a6640; }
.status-menunggu_kembali { background:#dbeafe; color:#1e40af; }
.status-dikembalikan { background:#f3f4f6; color:#374151; }
.status-ditolak { background:#fee2e2; color:#991b1b; }
.bukti-footer { display:flex; justify-content:space-between; align-items:flex-end; margin-top:24px; padding-top:18px; border-top:2px dashed #e0e0e0; }
.bukti-approved { font-size:12px; color:#555; }
.bukti-approved strong { display:block; color:#1a3a5c; margin-bottom:3px; }
.bukti-sign { text-align:right; font-size:12px; color:#555; }
.bukti-sign strong { display:block; color:#1a3a5c; margin-bottom:3px; }
.btn-print {
    background:#2ecc71; color:white; border:none; border-radius:8px;
    padding:9px 20px; font-size:13px; font-weight:600; cursor:pointer;
    font-family:'Poppins',sans-serif; display:flex; align-items:center; gap:6px;
}
.btn-print:hover { background:#27ae60; }
@media print {
    .sidebar, .topbar, .btn-print { display:none !important; }
    body { background:white; }
    .main-wrapper { display:block; }
    .page-content { padding:0; }
    .bukti-outer { background:white; box-shadow:none; padding:0; }
    .bukti-paper { box-shadow:none; }
}
</style>
@endpush

<div class="bukti-wrap">
    <div style="width:100%;max-width:620px;">
        <div style="display:flex;justify-content:flex-end;margin-bottom:14px;">
            <button onclick="window.print()" class="btn-print">
                <i class="fas fa-print"></i> Cetak Bukti
            </button>
        </div>
        <div class="bukti-outer">
            <div class="bukti-paper">
                <div class="bukti-header">
                    <div class="bukti-logo">📚 Bookify</div>
                    <div class="bukti-subtitle">Perpustakaan Online</div>
                </div>
                <div class="bukti-title">Bukti Peminjaman Buku</div>

                <div class="bukti-section">
                    <div class="bukti-section-title">Data Peminjam</div>
                    <div class="bukti-row">
                        <span class="bukti-label">Nama</span>
                        <span class="bukti-value">{{ $borrow->user->name }}</span>
                    </div>
                    <div class="bukti-row">
                        <span class="bukti-label">Email</span>
                        <span class="bukti-value">{{ $borrow->user->email }}</span>
                    </div>
                </div>

                <div class="bukti-section">
                    <div class="bukti-section-title">Detail Buku</div>
                    <div class="bukti-row">
                        <span class="bukti-label">Judul Buku</span>
                        <span class="bukti-value">{{ $borrow->book->title }}</span>
                    </div>
                    <div class="bukti-row">
                        <span class="bukti-label">Penulis</span>
                        <span class="bukti-value">{{ $borrow->book->author ?? '-' }}</span>
                    </div>
                    <div class="bukti-row">
                        <span class="bukti-label">Penerbit</span>
                        <span class="bukti-value">{{ $borrow->book->publisher ?? '-' }}</span>
                    </div>
                </div>

                <div class="bukti-section">
                    <div class="bukti-section-title">Informasi Peminjaman</div>
                    <div class="bukti-row">
                        <span class="bukti-label">Tanggal Pinjam</span>
                        <span class="bukti-value">{{ $borrow->borrowed_at }}</span>
                    </div>
                    <div class="bukti-row">
                        <span class="bukti-label">Jatuh Tempo</span>
                        <span class="bukti-value">{{ $borrow->return_date ?? '-' }}</span>
                    </div>
                    @if($borrow->returned_at)
                    <div class="bukti-row">
                        <span class="bukti-label">Tgl Dikembalikan</span>
                        <span class="bukti-value">{{ $borrow->returned_at }}</span>
                    </div>
                    @endif
                    <div class="bukti-row">
                        <span class="bukti-label">Status</span>
                        <span class="bukti-value">
                            <span class="status-badge status-{{ $borrow->status }}">
                                {{ $borrow->statusLabel() }}
                            </span>
                        </span>
                    </div>
                    @if($borrow->catatan)
                    <div class="bukti-row">
                        <span class="bukti-label">Catatan</span>
                        <span class="bukti-value" style="color:#991b1b;">{{ $borrow->catatan }}</span>
                    </div>
                    @endif
                </div>

                <div class="bukti-footer">
                    <div class="bukti-approved">
                        <strong>Disetujui Oleh</strong>
                        {{ $borrow->approvedBy->name ?? 'Admin Bookify' }}
                    </div>
                    <div class="bukti-sign">
                        <strong>Tertanda</strong>
                        Petugas Bookify
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
