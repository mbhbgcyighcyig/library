<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class BookController extends Controller
{
    // Katalog publik
    public function catalog()
    {
        $books      = Book::with('category')->where('stock', '>', 0)->orderBy('title')->get();
        $categories = Category::orderBy('name')->get();
        return view('books.catalog', compact('books', 'categories'));
    }

    // Katalog untuk user yang login (sama, tapi bisa pinjam)
    public function catalogUser()
    {
        $books      = Book::with('category')->where('stock', '>', 0)->orderBy('title')->get();
        $categories = Category::orderBy('name')->get();
        return view('books.catalog', compact('books', 'categories'));
    }

    // Detail buku
    public function show(Book $book)
    {
        $reviews = $book->reviews()->with('user')->orderByDesc('created_at')->get();
        
        // Cek apakah user sudah pernah mengembalikan buku ini
        $canReview = false;
        if (auth()->check()) {
            $canReview = \App\Models\Borrow::where('user_id', auth()->id())
                ->where('book_id', $book->id)
                ->where('status', 'dikembalikan')
                ->exists();
        }
        
        return view('books.show', compact('book', 'reviews', 'canReview'));
    }

    // Halaman pilih kategori
    public function kategori()
    {
        $categories = Category::withCount('books')->orderBy('name')->get();
        return view('books.kategori', compact('categories'));
    }

    // Buku berdasarkan kategori
    public function showByCategory($jenis)
    {
        $category = Category::where('name', 'like', "%{$jenis}%")->first();
        $books    = $category
            ? Book::with('category')->where('category_id', $category->id)->where('stock', '>', 0)->get()
            : collect();
        return view('books.kategori-detail', compact('books', 'jenis', 'category'));
    }
}
