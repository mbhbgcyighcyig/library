<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controller;

class ReviewController extends Controller
{
    // Lihat ulasan per buku (public)
    public function index(Book $book)
    {
        $reviews = Review::with('user')
            ->where('book_id', $book->id)
            ->orderByDesc('created_at')
            ->get();
        return view('books.reviews', compact('book', 'reviews'));
    }

    // Simpan ulasan baru
    public function store(Request $request, Book $book)
    {
        $request->validate([
            'rating'  => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:1000',
        ]);

        // Cek apakah user pernah meminjam dan mengembalikan buku ini
        $hasReturnedBook = \App\Models\Borrow::where('user_id', Auth::id())
            ->where('book_id', $book->id)
            ->where('status', 'dikembalikan')
            ->exists();

        if (!$hasReturnedBook) {
            return back()->with('error', 'Anda hanya bisa memberikan ulasan setelah mengembalikan buku ini.');
        }

        Review::updateOrCreate(
            ['user_id' => Auth::id(), 'book_id' => $book->id],
            ['rating' => $request->rating, 'comment' => $request->comment]
        );

        return back()->with('success', 'Ulasan berhasil disimpan.');
    }

    // Edit form
    public function edit(Book $book, Review $review)
    {
        if ($review->user_id !== Auth::id()) abort(403);
        
        // Cek apakah user pernah meminjam dan mengembalikan buku ini
        $hasReturnedBook = \App\Models\Borrow::where('user_id', Auth::id())
            ->where('book_id', $book->id)
            ->where('status', 'dikembalikan')
            ->exists();

        if (!$hasReturnedBook) {
            return redirect()->route('books.show', $book)
                ->with('error', 'Anda hanya bisa mengedit ulasan setelah mengembalikan buku ini.');
        }
        
        return view('books.reviews-edit', compact('book', 'review'));
    }

    // Update ulasan
    public function update(Request $request, Book $book, Review $review)
    {
        if ($review->user_id !== Auth::id()) abort(403);

        // Cek apakah user pernah meminjam dan mengembalikan buku ini
        $hasReturnedBook = \App\Models\Borrow::where('user_id', Auth::id())
            ->where('book_id', $book->id)
            ->where('status', 'dikembalikan')
            ->exists();

        if (!$hasReturnedBook) {
            return back()->with('error', 'Anda hanya bisa mengedit ulasan setelah mengembalikan buku ini.');
        }

        $request->validate([
            'rating'  => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:1000',
        ]);

        $review->update([
            'rating'  => $request->rating,
            'comment' => $request->comment,
        ]);

        return redirect()->route('books.reviews.index', $book)
            ->with('success', 'Ulasan berhasil diperbarui.');
    }

    // Hapus ulasan
    public function destroy(Book $book, Review $review)
    {
        if ($review->user_id !== Auth::id()) abort(403);
        $review->delete();
        return back()->with('success', 'Ulasan berhasil dihapus.');
    }

    // Ulasan milik user yang login (untuk dashboard)
    public function userReviews()
    {
        $reviews = Review::with('book')
            ->where('user_id', Auth::id())
            ->orderByDesc('created_at')
            ->get();
        return view('user.reviews.index', compact('reviews'));
    }
}
