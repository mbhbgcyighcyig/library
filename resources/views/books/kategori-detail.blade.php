<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Buku {{ ucfirst($jenis) }}</title>
  <style>
    * { box-sizing: border-box; margin: 0; padding: 0; }
    body { font-family: 'Segoe UI', sans-serif; background: #b8d4e8; }
    .navbar { background: #1e3a5c; padding: 10px 24px; display: flex; align-items: center; justify-content: space-between; }
    .search-wrap { position: relative; width: 420px; }
    .search-wrap input { width: 100%; padding: 10px 16px 10px 42px; border-radius: 24px; border: none; font-size: 15px; background: white; color: #333; outline: none; }
    .search-icon { position: absolute; left: 14px; top: 50%; transform: translateY(-50%); font-size: 16px; color: #888; }
    .user-info { display: flex; align-items: center; gap: 10px; color: white; font-weight: 600; font-size: 15px; }
    .avatar { width: 40px; height: 40px; border-radius: 50%; background: #4a90d9; border: 2px solid #6ab0f5; display: flex; align-items: center; justify-content: center; font-size: 13px; font-weight: 700; color: white; }
    .books-header { display: flex; align-items: center; margin: 20px 24px 16px; }
    .back-btn { background: #1e3a5c; color: white; border: none; border-radius: 10px; padding: 10px 16px; font-size: 13px; font-weight: 600; cursor: pointer; margin-right: 12px; text-decoration: none; }
    .back-btn:hover { background: #2a5080; }
    .section-title { background: #1e3a5c; color: white; font-size: 18px; font-weight: 700; padding: 12px 24px; border-radius: 12px; flex: 1; }
    .books-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 16px; padding: 0 24px 32px; }
    .book-card { background: white; border-radius: 16px; padding: 16px; display: flex; flex-direction: column; transition: transform 0.15s, box-shadow 0.15s; }
    .book-card:hover { transform: translateY(-3px); box-shadow: 0 8px 24px rgba(0,0,0,0.12); }
    .book-cover { width: 100%; aspect-ratio: 3/4; object-fit: cover; border-radius: 8px; margin-bottom: 10px; background: #ccc; }
    .book-title { font-size: 14px; font-weight: 700; color: #111; line-height: 1.3; }
    .book-author { font-size: 12px; color: #3a7cc1; font-weight: 500; margin-top: 2px; }
    .lihat-btn { margin-top: 10px; width: 100%; background: #2ecc71; color: white; border: none; border-radius: 20px; padding: 8px; font-size: 13px; font-weight: 700; cursor: pointer; text-decoration: none; display: block; text-align: center; }
    .lihat-btn:hover { background: #27ae60; }
    .no-results { text-align: center; color: #555; font-size: 16px; padding: 40px; grid-column: 1/-1; }
  </style>
</head>
<body>
  <div class="navbar">
    <div class="search-wrap">
      <span class="search-icon">&#128269;</span>
      <input type="text" id="searchInput" placeholder="Search" oninput="filterBooks()" />
    </div>
    <div class="user-info">
      Hai, {{ auth()->user()->name }}
      <div class="avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
    </div>
  </div>

  <div class="books-header">
    <a href="{{ route('kategori') }}" class="back-btn">&#8592; Kembali</a>
    <div class="section-title">Buku {{ ucfirst($jenis) }}</div>
  </div>

  <div class="books-grid" id="books-grid">
    @forelse($books as $book)
      <div class="book-card" data-title="{{ strtolower($book->title) }}" data-author="{{ strtolower($book->author ?? '') }}">
        @if($book->cover)
          <img src="{{ asset('storage/' . $book->cover) }}" class="book-cover" alt="{{ $book->title }}"/>
        @else
          <div class="book-cover" style="background:#5dade2; display:flex; align-items:center; justify-content:center; color:white; font-weight:700; font-size:13px; text-align:center; padding:8px;">{{ $book->title }}</div>
        @endif
        <div class="book-title">{{ $book->title }}</div>
        <div class="book-author">{{ $book->author ?? '-' }}</div>
        <a href="{{ route('books.show', $book->id) }}" class="lihat-btn">Lihat</a>
      </div>
    @empty
      <div class="no-results">Tidak ada buku ditemukan.</div>
    @endforelse
  </div>

  <script>
    function filterBooks() {
      const q = document.getElementById('searchInput').value.toLowerCase();
      document.querySelectorAll('.book-card').forEach(card => {
        const title = card.dataset.title || '';
        const author = card.dataset.author || '';
        card.style.display = (title.includes(q) || author.includes(q)) ? 'flex' : 'none';
      });
    }
  </script>
</body>
</html>