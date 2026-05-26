<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Dashboard - Bookify</title>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<style>
* { margin:0; padding:0; box-sizing:border-box; }
body { font-family:'Poppins',sans-serif; background:#5a8fa8; min-height:100vh; display:flex; }

/* SIDEBAR */
.sidebar {
    width: 230px; background: #c9dff0;
    padding: 28px 0; display: flex;
    flex-direction: column; min-height: 100vh; flex-shrink: 0;
}
.profile {
    display: flex; align-items: center; gap: 12px;
    padding: 0 20px 24px;
    border-bottom: 1px solid rgba(0,0,0,0.08); margin-bottom: 8px;
}
.avatar {
    width: 50px; height: 50px; border-radius: 50%;
    background: #3a6ea5; display: flex; align-items: center;
    justify-content: center; font-size: 20px; font-weight: 700;
    color: white; flex-shrink: 0;
}
.profile-name { font-size: 17px; font-weight: 700; color: #111; }
.profile-role { font-size: 11px; color: #666; }

.nav-item {
    display: flex; align-items: center; gap: 12px;
    padding: 11px 20px; color: #333; font-size: 14px;
    font-weight: 500; cursor: pointer; text-decoration: none;
    transition: background 0.15s; border-left: 3px solid transparent;
}
.nav-item:hover { background: rgba(0,0,0,0.06); color: #111; }
.nav-item.active { background: rgba(58,110,165,0.12); font-weight: 600; border-left-color: #3a6ea5; color: #1a3a5c; }
.nav-item i { width: 20px; text-align: center; font-size: 15px; color: #3a6ea5; }

.nav-logout { margin-top: auto; padding-top: 12px; border-top: 1px solid rgba(0,0,0,0.08); }
.nav-logout form { margin: 0; }
.nav-logout button {
    display: flex; align-items: center; gap: 12px;
    padding: 11px 20px; color: #c0392b; background: none; border: none;
    font-size: 14px; font-weight: 500; cursor: pointer;
    width: 100%; text-align: left; font-family: 'Poppins', sans-serif;
    transition: background 0.15s;
}
.nav-logout button:hover { background: rgba(192,57,43,0.08); }
.nav-logout button i { width: 20px; text-align: center; }

/* MAIN */
.main { flex: 1; padding: 28px 32px; overflow-x: hidden; }

/* SEARCH */
.search-wrap { position: relative; margin-bottom: 28px; }
.search-wrap i { position: absolute; left: 16px; top: 50%; transform: translateY(-50%); color: #999; font-size: 14px; }
.search-wrap input {
    width: 100%; background: white; border: none; outline: none;
    border-radius: 28px; padding: 12px 20px 12px 44px;
    font-size: 14px; font-family: 'Poppins', sans-serif; color: #333;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}

/* PAGE TITLE */
.page-title { font-size: 24px; font-weight: 700; color: white; margin-bottom: 20px; text-shadow: 0 1px 3px rgba(0,0,0,0.2); }

/* STAT CARDS */
.stats-row { display: grid; grid-template-columns: repeat(3,1fr); gap: 16px; margin-bottom: 24px; }
.stat-card { background: white; border-radius: 14px; padding: 18px 22px; box-shadow: 0 2px 10px rgba(0,0,0,0.08); }
.stat-label { font-size: 12px; color: #777; margin-bottom: 6px; }
.stat-num { font-size: 30px; font-weight: 700; color: #1a3a5c; }

/* BOOKS GRID */
.books-grid { display: grid; grid-template-columns: repeat(4,1fr); gap: 16px; margin-bottom: 22px; }
.book-card { background: white; border-radius: 14px; padding: 14px; box-shadow: 0 2px 10px rgba(0,0,0,0.08); display: flex; flex-direction: column; }
.book-cover { width: 100%; height: 190px; object-fit: cover; border-radius: 10px; margin-bottom: 10px; }
.book-cover-placeholder {
    width: 100%; height: 190px; border-radius: 10px; margin-bottom: 10px;
    background: linear-gradient(135deg, #3a6ea5, #5a8fa8);
    display: flex; align-items: center; justify-content: center;
    color: white; font-size: 13px; font-weight: 600; text-align: center; padding: 12px;
}
.book-title { font-size: 13px; font-weight: 700; color: #1a3a5c; line-height: 1.3; margin-bottom: 3px; }
.book-author { font-size: 12px; color: #3a6ea5; margin-bottom: 6px; }
.book-stock { font-size: 11px; color: #888; margin-bottom: 8px; }
.btn-pinjam {
    width: 100%; background: #2ecc71; color: white; border: none;
    border-radius: 20px; padding: 9px; font-size: 13px; font-weight: 600;
    cursor: pointer; font-family: 'Poppins', sans-serif; transition: background 0.15s;
    text-decoration: none; display: block; text-align: center; margin-top: auto;
}
.btn-pinjam:hover { background: #27ae60; color: white; }
.btn-pinjam-disabled { background: #ccc; cursor: not-allowed; }

/* LIHAT KOLEKSI */
.lihat-koleksi-wrap { display: flex; justify-content: center; margin-bottom: 8px; }
.btn-lihat-koleksi {
    background: rgba(255,255,255,0.22); color: white;
    border: 2px solid rgba(255,255,255,0.45); border-radius: 12px;
    padding: 12px 48px; font-size: 15px; font-family: 'Poppins', sans-serif;
    font-weight: 600; cursor: pointer; text-decoration: none;
    display: inline-block; transition: background 0.15s;
}
.btn-lihat-koleksi:hover { background: rgba(255,255,255,0.32); color: white; }

/* CARD BOX */
.card-box { background: white; border-radius: 14px; padding: 20px 22px; box-shadow: 0 2px 10px rgba(0,0,0,0.08); }
.card-title { font-size: 15px; font-weight: 700; color: #1a3a5c; margin-bottom: 16px; }

/* TABLE */
.tbl { width: 100%; border-collapse: collapse; font-size: 13px; }
.tbl thead tr { background: #eef5fb; }
.tbl th { padding: 10px 14px; text-align: left; color: #3a6ea5; font-weight: 600; font-size: 12px; text-transform: uppercase; }
.tbl td { padding: 11px 14px; color: #333; border-bottom: 1px solid #f0f5fa; }
.tbl tbody tr:hover { background: #f7fbff; }
.tbl tbody tr:last-child td { border-bottom: none; }

/* BADGE */
.badge-green  { background: #d0f0e0; color: #1a6640; padding: 4px 12px; border-radius: 20px; font-size: 11px; font-weight: 600; }
.badge-yellow { background: #fff3cd; color: #856404; padding: 4px 12px; border-radius: 20px; font-size: 11px; font-weight: 600; }
.badge-gray   { background: #f3f4f6; color: #6b7280; padding: 4px 12px; border-radius: 20px; font-size: 11px; font-weight: 600; }

/* BUTTONS */
.btn-sm { padding: 5px 12px; border-radius: 6px; font-size: 12px; font-weight: 600; cursor: pointer; border: none; font-family: 'Poppins', sans-serif; text-decoration: none; display: inline-block; }
.btn-outline { background: transparent; border: 1.5px solid #3a6ea5; color: #3a6ea5; }
.btn-outline:hover { background: #3a6ea5; color: white; }
.btn-return { background: #2ecc71; color: white; }
.btn-return:hover { background: #27ae60; }

/* ALERT */
.alert-success { background: #d1fae5; color: #065f46; border-radius: 8px; padding: 12px 16px; margin-bottom: 16px; font-size: 13px; border-left: 4px solid #10b981; }

/* ULASAN */
.ulasan-card { background: white; border-radius: 14px; padding: 16px 18px; margin-bottom: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.06); display: flex; justify-content: space-between; align-items: flex-start; }
.ulasan-book { font-size: 14px; font-weight: 700; color: #1a3a5c; margin-bottom: 4px; }
.ulasan-date { font-size: 12px; color: #999; margin-bottom: 6px; }
.ulasan-stars { color: #f59e0b; font-size: 16px; margin-bottom: 6px; }
.ulasan-text { font-size: 13px; color: #555; }
.ulasan-actions { display: flex; gap: 8px; margin-left: 16px; flex-shrink: 0; }

/* KATALOG */
.katalog-grid { display: grid; grid-template-columns: repeat(4,1fr); gap: 16px; margin-bottom: 22px; }
.katalog-card { background: white; border-radius: 14px; padding: 14px; box-shadow: 0 2px 10px rgba(0,0,0,0.08); display: flex; flex-direction: column; }
.filter-bar { display: flex; gap: 10px; margin-bottom: 18px; flex-wrap: wrap; }
.filter-btn { padding: 7px 16px; border-radius: 20px; border: 1.5px solid rgba(255,255,255,0.5); background: rgba(255,255,255,0.2); color: white; font-size: 13px; font-weight: 500; cursor: pointer; font-family: 'Poppins', sans-serif; transition: all 0.15s; }
.filter-btn:hover, .filter-btn.active { background: white; color: #1a3a5c; border-color: white; }

/* EMPTY STATE */
.empty-state { text-align: center; padding: 40px 20px; color: rgba(255,255,255,0.75); }
.empty-state i { font-size: 44px; margin-bottom: 12px; display: block; }
.empty-state p { font-size: 14px; }
.empty-state a { color: white; font-weight: 600; text-decoration: underline; }
</style>
</head>
<body>

<!-- SIDEBAR -->
<div class="sidebar">
    <div class="profile">
        <div class="avatar">{{ strtoupper(substr($user->name, 0, 1)) }}</div>
        <div>
            <div class="profile-name">{{ $user->name }}</div>
            <div class="profile-role">Anggota</div>
        </div>
    </div>

    <a href="javascript:void(0)" onclick="showPage('riwayat')" class="nav-item active" id="nav-riwayat">
        <i class="fas fa-history"></i> Riwayat Peminjaman
    </a>
    <a href="javascript:void(0)" onclick="showPage('pengembalian')" class="nav-item" id="nav-pengembalian">
        <i class="fas fa-undo-alt"></i> Pengembalian
    </a>
    <a href="javascript:void(0)" onclick="showPage('katalog')" class="nav-item" id="nav-katalog">
        <i class="fas fa-book-open"></i> Katalog Buku
    </a>
    <a href="javascript:void(0)" onclick="showPage('ulasan')" class="nav-item" id="nav-ulasan">
        <i class="fas fa-star"></i> Ulasan
    </a>

    <div class="nav-logout">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit">
                <i class="fas fa-sign-out-alt"></i> Log out
            </button>
        </form>
    </div>
</div>

<!-- MAIN -->
<div class="main">
    <div class="search-wrap">
        <i class="fas fa-search"></i>
        <input type="text" id="searchInput" placeholder="Search" oninput="handleSearch()">
    </div>

    @if(session('success'))
        <div class="alert-success"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
    @endif

    <!-- ===== RIWAYAT PEMINJAMAN ===== -->
    <div id="page-riwayat">
        <div class="page-title">Riwayat Peminjaman</div>

        <div class="stats-row">
            <div class="stat-card">
                <div class="stat-label">Total Pengajuan</div>
                <div class="stat-num">{{ $borrows->count() }}</div>
            </div>
            <div class="stat-card">
                <div class="stat-label">Sedang Dipinjam</div>
                <div class="stat-num">{{ $borrows->where('status','dipinjam')->count() }}</div>
            </div>
            <div class="stat-card">
                <div class="stat-label">Selesai</div>
                <div class="stat-num">{{ $borrows->where('status','dikembalikan')->count() }}</div>
            </div>
        </div>

        <!-- INFO ALUR -->
        <div style="background:rgba(255,255,255,0.18);border-radius:10px;padding:12px 16px;margin-bottom:18px;color:white;font-size:12px;line-height:1.8;">
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

        @if($books->count() > 0)
        <div class="books-grid" id="books-grid">
            @foreach($books as $book)
            <div class="book-card" data-title="{{ strtolower($book->title) }}">
                @if($book->cover)
                    <img src="{{ asset('storage/'.$book->cover) }}" class="book-cover" alt="{{ $book->title }}">
                @else
                    <div class="book-cover-placeholder">{{ $book->title }}</div>
                @endif
                <div class="book-title">{{ $book->title }}</div>
                <div class="book-author">{{ $book->author ?? '-' }}</div>
                <div class="book-stock"><i class="fas fa-box"></i> Stok: {{ $book->stock }}</div>
                @if($book->stock > 0)
                    <a href="{{ route('books.borrow', $book) }}" class="btn-pinjam">Pinjam</a>
                @else
                    <span class="btn-pinjam btn-pinjam-disabled">Stok Habis</span>
                @endif
            </div>
            @endforeach
        </div>
        @else
        <div class="empty-state">
            <i class="fas fa-book-open"></i>
            <p>Belum ada buku tersedia. <a href="javascript:void(0)" onclick="showPage('katalog')">Lihat katalog lengkap</a></p>
        </div>
        @endif

        <div class="lihat-koleksi-wrap">
            <a href="javascript:void(0)" onclick="showPage('katalog')" class="btn-lihat-koleksi">
                <i class="fas fa-book"></i> Lihat Koleksi
            </a>
        </div>
    </div>

    <!-- ===== PENGEMBALIAN ===== -->
    <div id="page-pengembalian" style="display:none;">
        <div class="page-title">Pengembalian</div>
        <div class="card-box">
            <div class="card-title">Daftar Peminjaman Saya</div>
            @if($borrows->count() > 0)
            <div style="overflow-x:auto;">
                <table class="tbl">
                    <thead>
                        <tr>
                            <th>Judul Buku</th>
                            <th>Tgl Pinjam</th>
                            <th>Jatuh Tempo</th>
                            <th>Status</th>
                            <th>Catatan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($borrows as $borrow)
                        <tr>
                            <td style="font-weight:600;">{{ $borrow->book->title ?? '-' }}</td>
                            <td>{{ $borrow->borrowed_at }}</td>
                            <td>{{ $borrow->return_date ?? '-' }}</td>
                            <td><span class="{{ $borrow->statusColor() }}">{{ $borrow->statusLabel() }}</span></td>
                            <td style="font-size:12px;color:#888;">{{ $borrow->catatan ?? '-' }}</td>
                            <td>
                                @if($borrow->status === 'menunggu')
                                    <span style="font-size:12px;color:#856404;"><i class="fas fa-clock"></i> Menunggu persetujuan</span>

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
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <div style="text-align:center;padding:40px;color:#aaa;">
                <i class="fas fa-inbox" style="font-size:40px;margin-bottom:12px;display:block;"></i>
                Belum ada riwayat peminjaman.
            </div>
            @endif
        </div>
    </div>

    <!-- ===== KATALOG BUKU ===== -->
    <div id="page-katalog" style="display:none;">
        <div class="page-title">Katalog Buku</div>

        @php
            $allBooks = \App\Models\Book::with('category')->orderBy('title')->get();
            $allCategories = \App\Models\Category::orderBy('name')->get();
        @endphp

        <!-- Filter Kategori -->
        <div class="filter-bar">
            <button class="filter-btn active" onclick="filterKatalog('semua', this)">Semua</button>
            @foreach($allCategories as $cat)
                <button class="filter-btn" onclick="filterKatalog('{{ $cat->id }}', this)">{{ $cat->name }}</button>
            @endforeach
        </div>

        @if($allBooks->count() > 0)
        <div class="katalog-grid" id="katalog-grid">
            @foreach($allBooks as $book)
            <div class="katalog-card" data-category="{{ $book->category_id }}">
                @if($book->cover)
                    <img src="{{ asset('storage/'.$book->cover) }}" class="book-cover" alt="{{ $book->title }}">
                @else
                    <div class="book-cover-placeholder">{{ $book->title }}</div>
                @endif
                <div class="book-title">{{ $book->title }}</div>
                <div class="book-author">{{ $book->author ?? '-' }}</div>
                <div class="book-stock">
                    @if($book->stock > 0)
                        <span style="color:#16a34a;font-size:11px;"><i class="fas fa-check-circle"></i> Tersedia ({{ $book->stock }})</span>
                    @else
                        <span style="color:#dc2626;font-size:11px;"><i class="fas fa-times-circle"></i> Stok Habis</span>
                    @endif
                </div>
                @if($book->stock > 0)
                    <a href="{{ route('books.borrow', $book) }}" class="btn-pinjam" style="margin-top:8px;">Pinjam</a>
                @else
                    <span class="btn-pinjam btn-pinjam-disabled" style="margin-top:8px;">Stok Habis</span>
                @endif
            </div>
            @endforeach
        </div>
        @else
        <div class="empty-state">
            <i class="fas fa-book"></i>
            <p>Belum ada buku di katalog.</p>
        </div>
        @endif
    </div>

    <!-- ===== ULASAN ===== -->
    <div id="page-ulasan" style="display:none;">
        <div class="page-title">Ulasan Buku</div>

        @php
            $userReviews = \App\Models\Review::with('book')
                ->where('user_id', auth()->id())
                ->orderByDesc('created_at')
                ->get();
        @endphp

        @if($userReviews->count() > 0)
            @foreach($userReviews as $review)
            <div class="ulasan-card">
                <div style="flex:1;">
                    <div class="ulasan-book">{{ $review->book->title ?? '-' }}</div>
                    <div class="ulasan-date">{{ $review->created_at->format('d M Y') }}</div>
                    <div class="ulasan-stars">
                        @for($s=1;$s<=5;$s++){{ $s<=$review->rating ? '★' : '☆' }}@endfor
                        <span style="font-size:12px;color:#999;margin-left:4px;">({{ $review->rating }}/5)</span>
                    </div>
                    <div class="ulasan-text">{{ $review->comment }}</div>
                </div>
                <div class="ulasan-actions">
                    <a href="{{ route('books.reviews.edit', [$review->book, $review]) }}" class="btn-sm btn-outline">
                        <i class="fas fa-edit"></i>
                    </a>
                    <form action="{{ route('books.reviews.destroy', [$review->book, $review]) }}" method="POST" onsubmit="return confirm('Hapus ulasan ini?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn-sm" style="background:#fee2e2;color:#dc2626;border:none;cursor:pointer;">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                </div>
            </div>
            @endforeach
        @else
            <div class="empty-state">
                <i class="fas fa-star"></i>
                <p>Belum ada ulasan. Pinjam buku dulu, lalu beri ulasan dari halaman detail buku.</p>
            </div>
        @endif
    </div>

</div><!-- /main -->

<script>
var pages = ['riwayat','pengembalian','katalog','ulasan'];

function showPage(page) {
    pages.forEach(function(p) {
        document.getElementById('page-' + p).style.display = 'none';
        var nav = document.getElementById('nav-' + p);
        if (nav) nav.classList.remove('active');
    });
    document.getElementById('page-' + page).style.display = 'block';
    var activeNav = document.getElementById('nav-' + page);
    if (activeNav) activeNav.classList.add('active');
}

function handleSearch() {
    var q = document.getElementById('searchInput').value.toLowerCase().trim();

    // Filter di grid riwayat
    var grid = document.getElementById('books-grid');
    if (grid) {
        grid.querySelectorAll('.book-card').forEach(function(card) {
            var title = card.dataset.title || '';
            card.style.display = title.includes(q) ? 'flex' : 'none';
        });
    }

    // Filter di katalog
    var katalog = document.getElementById('katalog-grid');
    if (katalog) {
        katalog.querySelectorAll('.katalog-card').forEach(function(card) {
            var title = (card.querySelector('.book-title') || {}).textContent || '';
            card.style.display = title.toLowerCase().includes(q) ? 'flex' : 'none';
        });
    }
}

function filterKatalog(catId, btn) {
    // Update active button
    document.querySelectorAll('.filter-btn').forEach(function(b) { b.classList.remove('active'); });
    btn.classList.add('active');

    var katalog = document.getElementById('katalog-grid');
    if (!katalog) return;
    katalog.querySelectorAll('.katalog-card').forEach(function(card) {
        if (catId === 'semua') {
            card.style.display = 'flex';
        } else {
            card.style.display = (card.dataset.category == catId) ? 'flex' : 'none';
        }
    });
}

// Cek URL hash untuk auto-navigate
var hash = window.location.hash.replace('#','');
if (pages.indexOf(hash) !== -1) {
    showPage(hash);
}
</script>

</body>
</html>
