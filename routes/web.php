<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\BorrowController;
use App\Http\Controllers\PetugasController;
use App\Http\Controllers\ReviewController;

// ================= LANDING =================
Route::get('/', function () {
    if (! auth()->check()) {
        return view('user.landingpage');
    }

    if (auth()->user()->role === 'admin') {
        return redirect()->route('admin.dashboard');
    }

    if (auth()->user()->role === 'petugas') {
        return redirect()->route('petugas.dashboard');
    }

    $user    = auth()->user();
    $borrows = \App\Models\Borrow::with('book')
                ->where('user_id', $user->id)
                ->orderByDesc('borrowed_at')
                ->get();
    $books   = \App\Models\Book::with('category')
                ->where('stock', '>', 0)
                ->latest()
                ->take(4)
                ->get();

    return view('dashboard', compact('user', 'borrows', 'books'));
})->name('dashboard');


// ================= AUTH =================
Route::middleware('guest')->group(function () {
    Route::get('/login',    [AuthController::class, 'login'])->name('login');
    Route::post('/login',   [AuthController::class, 'loginPost'])->name('login.post');
    Route::get('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/register',[AuthController::class, 'registerPost'])->name('register.post');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');


// ================= PUBLIC =================
Route::get('/catalog',          [BookController::class, 'catalog'])->name('books.catalog');
Route::get('/kategori',         [BookController::class, 'kategori'])->name('kategori');
Route::get('/kategori/{jenis}', [BookController::class, 'showByCategory'])->name('kategori.show');
Route::get('/books/{book}',     [BookController::class, 'show'])->name('books.show');

// Ulasan per buku (public bisa lihat)
Route::get('/books/{book}/reviews', [ReviewController::class, 'index'])->name('books.reviews.index');


// ================= USER =================
Route::middleware(['auth', 'role:user'])->group(function () {

    // Peminjaman
    Route::get('/books/{book}/borrow',  [BorrowController::class, 'create'])->name('books.borrow');
    Route::post('/books/{book}/borrow', [BorrowController::class, 'store'])->name('books.borrow.store');
    Route::get('/borrows',              [BorrowController::class, 'history'])->name('user.borrows');
    Route::post('/borrows/{borrow}/request-return', [BorrowController::class, 'requestReturn'])->name('borrows.request.return');
    Route::get('/borrows/{borrow}/print',           [BorrowController::class, 'print'])->name('borrows.print');

    // Ulasan — user bisa submit/edit/hapus
    Route::post('/books/{book}/reviews',              [ReviewController::class, 'store'])->name('books.reviews.store');
    Route::get('/books/{book}/reviews/{review}/edit', [ReviewController::class, 'edit'])->name('books.reviews.edit');
    Route::patch('/books/{book}/reviews/{review}',    [ReviewController::class, 'update'])->name('books.reviews.update');
    Route::delete('/books/{book}/reviews/{review}',   [ReviewController::class, 'destroy'])->name('books.reviews.destroy');

    // Ulasan milik user (untuk halaman dashboard)
    Route::get('/my-reviews', [ReviewController::class, 'userReviews'])->name('user.reviews.index');

    // Katalog (user juga bisa akses)
    Route::get('/katalog', [BookController::class, 'catalogUser'])->name('books.catalog.user');
});


// ================= ADMIN =================
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {

    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    Route::get('/categories',              [AdminController::class, 'categories'])->name('categories');
    Route::post('/categories',             [AdminController::class, 'storeCategory'])->name('categories.store');
    Route::delete('/categories/{category}',[AdminController::class, 'destroyCategory'])->name('categories.destroy');

    Route::get('/books',              [AdminController::class, 'books'])->name('books');
    Route::post('/books',             [AdminController::class, 'storeBook'])->name('books.store');
    Route::get('/books/{book}/edit',  [AdminController::class, 'editBook'])->name('books.edit');
    Route::patch('/books/{book}',     [AdminController::class, 'updateBook'])->name('books.update');
    Route::delete('/books/{book}',    [AdminController::class, 'destroyBook'])->name('books.destroy');

    Route::get('/staff',          [AdminController::class, 'staff'])->name('staff');
    Route::post('/staff',         [AdminController::class, 'storeStaff'])->name('staff.store');
    Route::delete('/staff/{user}',[AdminController::class, 'destroyStaff'])->name('staff.destroy');
    Route::get('/users',          [AdminController::class, 'users'])->name('users');
    Route::get('/borrows',        [AdminController::class, 'borrows'])->name('borrows');
    Route::post('/borrows/{borrow}/approve', [AdminController::class, 'approveBorrow'])->name('borrows.approve');
    Route::post('/borrows/{borrow}/reject',  [AdminController::class, 'rejectBorrow'])->name('borrows.reject');
    Route::post('/borrows/{borrow}/confirm-return', [AdminController::class, 'confirmReturn'])->name('borrows.confirm.return');
    Route::get('/reviews',        [AdminController::class, 'reviews'])->name('reviews');

    Route::prefix('reports')->name('reports.')->group(function () {
        Route::get('/books',   [AdminController::class, 'reportBooks'])->name('books');
        Route::get('/users',   [AdminController::class, 'reportUsers'])->name('users');
        Route::get('/borrows', [AdminController::class, 'reportBorrows'])->name('borrows');
        Route::get('/staff',   [AdminController::class, 'reportStaff'])->name('staff');
    });
});


// ================= PETUGAS =================
Route::middleware(['auth', 'role:petugas'])->prefix('petugas')->name('petugas.')->group(function () {

    Route::get('/dashboard', [PetugasController::class, 'dashboard'])->name('dashboard');
    Route::get('/books',     [PetugasController::class, 'books'])->name('books');
    Route::get('/borrows',   [PetugasController::class, 'borrows'])->name('borrows');
    Route::post('/borrows/{borrow}/approve',        [PetugasController::class, 'approveBorrow'])->name('borrows.approve');
    Route::post('/borrows/{borrow}/reject',         [PetugasController::class, 'rejectBorrow'])->name('borrows.reject');
    Route::post('/borrows/{borrow}/confirm-return', [PetugasController::class, 'confirmReturn'])->name('borrows.confirm.return');

    Route::prefix('reports')->name('reports.')->group(function () {
        Route::get('/books',   [PetugasController::class, 'reportBooks'])->name('books');
        Route::get('/borrows', [PetugasController::class, 'reportBorrows'])->name('borrows');
    });
});
