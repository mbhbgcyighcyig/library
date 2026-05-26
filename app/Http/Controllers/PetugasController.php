<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Borrow;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controller;

class PetugasController extends Controller
{
    public function dashboard()
    {
        return view('petugas.dashboard', [
            'books'              => Book::count(),
            'borrowed'           => Borrow::where('status', Borrow::STATUS_DIPINJAM)->count(),
            'returned'           => Borrow::where('status', Borrow::STATUS_DIKEMBALIKAN)->count(),
            'menunggu'           => Borrow::where('status', Borrow::STATUS_MENUNGGU)->count(),
            'menunggu_kembali'   => Borrow::where('status', Borrow::STATUS_MENUNGGU_KEMBALI)->count(),
            'recentBorrows'      => Borrow::with(['user', 'book'])->latest()->take(5)->get(),
            'lowStockBooks'      => Book::where('stock', '<=', 3)->orderBy('stock')->take(5)->get(),
            'latestBooks'        => Book::with('category')->latest()->take(5)->get(),
        ]);
    }

    public function books()
    {
        return view('petugas.books', [
            'books' => Book::with('category')->orderBy('title')->get(),
        ]);
    }

    public function borrows()
    {
        return view('petugas.borrows', [
            'borrows'            => Borrow::with(['user', 'book'])->orderByDesc('created_at')->get(),
            'totalMenunggu'      => Borrow::where('status', Borrow::STATUS_MENUNGGU)->count(),
            'totalMenungguKembali' => Borrow::where('status', Borrow::STATUS_MENUNGGU_KEMBALI)->count(),
        ]);
    }

    // Approve pengajuan pinjam → dipinjam, kurangi stok
    public function approveBorrow(Borrow $borrow)
    {
        if ($borrow->status !== Borrow::STATUS_MENUNGGU) {
            return back()->with('error', 'Status tidak valid untuk disetujui.');
        }

        if ($borrow->book->stock < 1) {
            return back()->with('error', 'Stok buku habis, tidak bisa disetujui.');
        }

        $borrow->update([
            'status'      => Borrow::STATUS_DIPINJAM,
            'approved_by' => Auth::id(),
            'approved_at' => now(),
        ]);
        $borrow->book->decrement('stock');

        return back()->with('success', 'Peminjaman berhasil disetujui.');
    }

    // Tolak pengajuan pinjam
    public function rejectBorrow(Request $request, Borrow $borrow)
    {
        if ($borrow->status !== Borrow::STATUS_MENUNGGU) {
            return back()->with('error', 'Status tidak valid untuk ditolak.');
        }

        $borrow->update([
            'status'  => Borrow::STATUS_DITOLAK,
            'catatan' => $request->catatan ?? 'Ditolak oleh petugas.',
        ]);

        return back()->with('success', 'Pengajuan berhasil ditolak.');
    }

    // Konfirmasi pengembalian → dikembalikan, tambah stok
    public function confirmReturn(Borrow $borrow)
    {
        if ($borrow->status !== Borrow::STATUS_MENUNGGU_KEMBALI) {
            return back()->with('error', 'Status tidak valid untuk dikonfirmasi.');
        }

        $borrow->update([
            'status'      => Borrow::STATUS_DIKEMBALIKAN,
            'returned_at' => now()->toDateString(),
            'approved_by' => Auth::id(),
            'approved_at' => now(),
        ]);
        $borrow->book->increment('stock');

        return back()->with('success', 'Pengembalian berhasil dikonfirmasi.');
    }

    public function reportBooks()
    {
        return view('petugas.reports.books', [
            'books' => Book::with('category')->orderBy('title')->get(),
        ]);
    }

    public function reportBorrows()
    {
        return view('petugas.reports.borrows', [
            'borrows' => Borrow::with(['user', 'book'])->orderByDesc('borrowed_at')->get(),
        ]);
    }
}
