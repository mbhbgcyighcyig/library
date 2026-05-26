<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Borrow;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controller;

class BorrowController extends Controller
{
    // Riwayat peminjaman user
    public function history()
    {
        $borrows = Borrow::with('book')
            ->where('user_id', Auth::id())
            ->orderByDesc('created_at')
            ->get();
        return view('user.borrows', compact('borrows'));
    }

    // Form ajukan peminjaman
    public function create(Book $book)
    {
        return view('user.borrow-create', compact('book'));
    }

    // Simpan pengajuan — status: menunggu (belum kurangi stok)
    public function store(Request $request, Book $book)
    {
        $request->validate([
            'return_date' => 'required|date|after:today',
        ]);

        if ($book->stock < 1) {
            return back()->withErrors(['stock' => 'Stok buku tidak mencukupi.']);
        }

        // Cek apakah user sudah punya pengajuan aktif untuk buku ini
        $existing = Borrow::where('user_id', Auth::id())
            ->where('book_id', $book->id)
            ->whereIn('status', [Borrow::STATUS_MENUNGGU, Borrow::STATUS_DIPINJAM])
            ->first();

        if ($existing) {
            return back()->withErrors(['duplicate' => 'Kamu sudah memiliki pengajuan atau sedang meminjam buku ini.']);
        }

        Borrow::create([
            'user_id'     => Auth::id(),
            'book_id'     => $book->id,
            'borrowed_at' => now()->toDateString(),
            'return_date' => $request->return_date,
            'status'      => Borrow::STATUS_MENUNGGU,
        ]);

        return redirect()->route('user.borrows')
            ->with('success', 'Pengajuan peminjaman berhasil dikirim. Menunggu persetujuan petugas.');
    }

    // User minta kembalikan — status: menunggu_kembali
    public function requestReturn(Borrow $borrow)
    {
        if ($borrow->user_id !== Auth::id()) abort(403);

        if ($borrow->status !== Borrow::STATUS_DIPINJAM) {
            return back()->withErrors(['status' => 'Buku tidak dalam status dipinjam.']);
        }

        $borrow->update(['status' => Borrow::STATUS_MENUNGGU_KEMBALI]);

        return back()->with('success', 'Permintaan pengembalian dikirim. Menunggu konfirmasi petugas.');
    }

    // Cetak bukti
    public function print(Borrow $borrow)
    {
        if ($borrow->user_id !== Auth::id()) abort(403);
        return view('user.borrow-print', compact('borrow'));
    }
}
