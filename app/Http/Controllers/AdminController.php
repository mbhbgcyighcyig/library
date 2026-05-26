<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Borrow;
use App\Models\Category;
use App\Models\Review;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Routing\Controller;

class AdminController extends Controller
{
    public function dashboard()
    {
        $data = [
            'totalBooks'    => Book::count(),
            'totalUsers'    => User::where('role', 'user')->count(),
            'totalStaff'    => User::where('role', 'petugas')->count(),
            'totalBorrow'   => Borrow::count(),
            'recentBorrows' => Borrow::with(['user', 'book'])->latest()->take(5)->get(),
            'lowStockBooks' => Book::where('stock', '<=', 3)->orderBy('stock')->take(5)->get(),
            'latestBooks'   => Book::with('category')->latest()->take(5)->get(),
        ];
        return view('admin.dashboard', $data);
    }

    // ===== KATEGORI =====
    public function categories()
    {
        return view('admin.categories', [
            'categories' => Category::orderBy('name')->get(),
        ]);
    }

    public function storeCategory(Request $request)
    {
        $request->validate(['name' => 'required|string|max:100']);
        Category::create($request->only('name', 'description'));
        return back()->with('success', 'Kategori berhasil disimpan.');
    }

    public function destroyCategory(Category $category)
    {
        $category->delete();
        return back()->with('success', 'Kategori berhasil dihapus.');
    }

    // ===== BUKU =====
    public function books()
    {
        return view('admin.books', [
            'books'      => Book::with('category')->orderByDesc('created_at')->get(),
            'categories' => Category::orderBy('name')->get(),
        ]);
    }

    public function storeBook(Request $request)
    {
        $request->validate([
            'category_id'    => 'required|exists:categories,id',
            'title'          => 'required|string|max:255',
            'author'         => 'required|string|max:255',
            'publisher'      => 'required|string|max:255',
            'stock'          => 'required|integer|min:0',
            'published_year' => 'nullable|integer|min:1900|max:2099',
            'cover'          => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $data = $request->only(['category_id', 'title', 'author', 'publisher', 'published_year', 'stock', 'summary', 'status']);

        if ($request->hasFile('cover')) {
            $data['cover'] = $request->file('cover')->store('covers', 'public');
        }

        Book::create($data);
        return back()->with('success', 'Buku berhasil ditambahkan.');
    }

    public function editBook(Book $book)
    {
        return view('admin.books-edit', [
            'book'       => $book,
            'categories' => Category::orderBy('name')->get(),
        ]);
    }

    public function updateBook(Request $request, Book $book)
    {
        $request->validate([
            'category_id'    => 'required|exists:categories,id',
            'title'          => 'required|string|max:255',
            'author'         => 'required|string|max:255',
            'publisher'      => 'required|string|max:255',
            'stock'          => 'required|integer|min:0',
            'published_year' => 'nullable|integer|min:1900|max:2099',
            'cover'          => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $data = $request->only(['category_id', 'title', 'author', 'publisher', 'published_year', 'stock', 'summary', 'status']);

        if ($request->hasFile('cover')) {
            // Delete old cover if exists
            if ($book->cover && \Storage::disk('public')->exists($book->cover)) {
                \Storage::disk('public')->delete($book->cover);
            }
            $data['cover'] = $request->file('cover')->store('covers', 'public');
        }

        $book->update($data);
        return redirect()->route('admin.books')->with('success', 'Buku berhasil diperbarui.');
    }

    public function destroyBook(Book $book)
    {
        $book->delete();
        return back()->with('success', 'Buku berhasil dihapus.');
    }

    // ===== PETUGAS =====
    public function staff()
    {
        return view('admin.staff', [
            'staff' => User::where('role', 'petugas')->orderBy('name')->get(),
        ]);
    }

    public function storeStaff(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:100',
            'username' => 'required|string|max:50|unique:users',
            'email'    => 'required|email|unique:users',
            'password' => 'required|min:8',
            'phone'    => 'nullable|string|max:20',
        ]);

        User::create([
            'name'     => $request->name,
            'username' => $request->username,
            'email'    => $request->email,
            'phone'    => $request->phone,
            'password' => Hash::make($request->password),
            'role'     => 'petugas',
        ]);

        return back()->with('success', 'Petugas berhasil ditambahkan.');
    }

    public function destroyStaff(User $user)
    {
        if ($user->role !== 'petugas') {
            return back()->with('error', 'Aksi tidak diizinkan.');
        }
        $user->delete();
        return back()->with('success', 'Petugas berhasil dihapus.');
    }

    // ===== PENGGUNA =====
    public function users()
    {
        return view('admin.users', [
            'users' => User::where('role', 'user')->orderBy('name')->get(),
        ]);
    }

    // ===== PEMINJAMAN =====
    public function borrows()
    {
        return view('admin.borrows', [
            'borrows'              => Borrow::with(['user', 'book'])->orderByDesc('created_at')->get(),
            'totalMenunggu'        => Borrow::where('status', Borrow::STATUS_MENUNGGU)->count(),
            'totalMenungguKembali' => Borrow::where('status', Borrow::STATUS_MENUNGGU_KEMBALI)->count(),
        ]);
    }

    // Approve pengajuan pinjam
    public function approveBorrow(Borrow $borrow)
    {
        if ($borrow->status !== Borrow::STATUS_MENUNGGU) {
            return back()->with('error', 'Status tidak valid untuk disetujui.');
        }
        if ($borrow->book->stock < 1) {
            return back()->with('error', 'Stok buku habis.');
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
            'catatan' => $request->catatan ?? 'Ditolak oleh admin.',
        ]);
        return back()->with('success', 'Pengajuan berhasil ditolak.');
    }

    // Konfirmasi pengembalian
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

    // ===== ULASAN =====
    public function reviews()
    {
        return view('admin.reviews', [
            'reviews' => Review::with(['user', 'book'])->orderByDesc('created_at')->get(),
        ]);
    }

    // ===== LAPORAN =====
    public function reportBooks()
    {
        return view('admin.reports.books', ['books' => Book::with('category')->orderBy('title')->get()]);
    }

    public function reportUsers()
    {
        return view('admin.reports.users', ['users' => User::where('role', 'user')->orderBy('name')->get()]);
    }

    public function reportBorrows()
    {
        return view('admin.reports.borrows', ['borrows' => Borrow::with(['user', 'book'])->orderByDesc('borrowed_at')->get()]);
    }

    public function reportStaff()
    {
        return view('admin.reports.staff', ['staff' => User::where('role', 'petugas')->orderBy('name')->get()]);
    }
}
