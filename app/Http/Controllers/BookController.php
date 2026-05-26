<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class BookController extends Controller
{
    // =======================
    // Katalog publik
    // =======================
    public function catalog()
    {
        $books = Book::with('category')
            ->where('stock', '>', 0)
            ->orderBy('title')
            ->get();

        $categories = Category::orderBy('name')->get();

        return view('books.catalog', compact(
            'books',
            'categories'
        ));
    }


    // =======================
    // Katalog user login
    // =======================
    public function catalogUser()
    {
        $books = Book::with('category')
            ->where('stock', '>', 0)
            ->orderBy('title')
            ->get();

        $categories = Category::orderBy('name')->get();

        return view('books.catalog', compact(
            'books',
            'categories'
        ));
    }


    // =======================
    // Detail buku
    // =======================
    public function show(Book $book)
    {
        $reviews = $book->reviews()
            ->with('user')
            ->orderByDesc('created_at')
            ->get();

        $canReview = false;

        if(auth()->check())
        {
            $canReview =
            \App\Models\Borrow::where(
                'user_id',
                auth()->id()
            )
            ->where(
                'book_id',
                $book->id
            )
            ->where(
                'status',
                'dikembalikan'
            )
            ->exists();
        }

        return view(
            'books.show',
            compact(
                'book',
                'reviews',
                'canReview'
            )
        );
    }


    // =======================
    // Halaman kategori
    // =======================
    public function kategori()
    {
        $categories =
        Category::withCount('books')
        ->orderBy('name')
        ->get();

        return view(
            'books.kategori',
            compact('categories')
        );
    }


    // =======================
    // Buku per kategori
    // =======================
    public function showByCategory($jenis)
    {
        $category =
        Category::where(
            'name',
            'like',
            "%{$jenis}%"
        )->first();

        $books = $category
            ? Book::with('category')
                ->where(
                    'category_id',
                    $category->id
                )
                ->where(
                    'stock',
                    '>',
                    0
                )
                ->get()

            : collect();

        return view(
            'books.kategori-detail',
            compact(
                'books',
                'jenis',
                'category'
            )
        );
    }



    // =======================
    // ADMIN TAMBAH BUKU
    // + COVER
    // =======================

    public function store(Request $request)
    {
        $data = $request->validate([

            'category_id' =>
            'required|exists:categories,id',

            'title' =>
            'required',

            'author' =>
            'required',

            'publisher' =>
            'required',

            'published_year' =>
            'nullable|numeric',

            'stock' =>
            'required|numeric',

            'summary' =>
            'nullable',

            'cover' =>
            'nullable|image|mimes:jpg,jpeg,png,webp|max:2048'

        ]);


        if($request->hasFile('cover'))
        {
            $data['cover'] =
            $request
            ->file('cover')
            ->store(
                'covers',
                'public'
            );
        }


        Book::create($data);

        return back()
            ->with(
                'success',
                'Buku berhasil ditambahkan'
            );
    }
}