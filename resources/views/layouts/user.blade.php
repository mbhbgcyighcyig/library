<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>@yield('title', 'Bookify')</title>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<style>
* { margin:0; padding:0; box-sizing:border-box; }
body { font-family:'Poppins',sans-serif; background:#5a8fa8; min-height:100vh; display:flex; }

/* ===== SIDEBAR ===== */
.sidebar {
    width: 230px; background: #c9dff0;
    padding: 28px 0; display: flex;
    flex-direction: column; min-height: 100vh; flex-shrink: 0;
    position: sticky; top: 0; height: 100vh;
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
.profile-name { font-size: 16px; font-weight: 700; color: #111; line-height: 1.3; }
.profile-role { font-size: 11px; color: #666; }

.nav-item {
    display: flex; align-items: center; gap: 12px;
    padding: 11px 20px; color: #333; font-size: 14px;
    font-weight: 500; text-decoration: none;
    transition: background 0.15s; border-left: 3px solid transparent;
}
.nav-item:hover { background: rgba(0,0,0,0.06); color: #111; }
.nav-item.active {
    background: rgba(58,110,165,0.12); font-weight: 600;
    border-left-color: #3a6ea5; color: #1a3a5c;
}
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

/* ===== MAIN WRAPPER ===== */
.main-wrapper {
    flex: 1; display: flex; flex-direction: column;
    min-height: 100vh; overflow-x: hidden;
}

/* ===== TOPBAR ===== */
.topbar {
    background: #3a6ea5; padding: 13px 28px;
    display: flex; align-items: center; justify-content: space-between;
    box-shadow: 0 2px 8px rgba(0,0,0,0.15); flex-shrink: 0;
}
.topbar-left { display: flex; align-items: center; gap: 14px; }
.btn-back {
    display: flex; align-items: center; gap: 7px;
    background: rgba(255,255,255,0.15); color: white;
    border: none; border-radius: 8px; padding: 7px 14px;
    font-size: 13px; font-weight: 500; cursor: pointer;
    font-family: 'Poppins', sans-serif; text-decoration: none;
    transition: background 0.15s;
}
.btn-back:hover { background: rgba(255,255,255,0.25); color: white; }
.topbar-title { font-size: 16px; font-weight: 700; color: white; }
.topbar-user { display: flex; align-items: center; gap: 8px; color: white; font-size: 13px; font-weight: 600; }
.topbar-avatar {
    width: 34px; height: 34px; border-radius: 50%;
    background: rgba(255,255,255,0.2); border: 2px solid rgba(255,255,255,0.4);
    display: flex; align-items: center; justify-content: center;
    font-size: 14px; font-weight: 700; color: white;
}

/* ===== PAGE CONTENT ===== */
.page-content { flex: 1; padding: 28px 32px; overflow-x: hidden; }

/* ===== ALERT ===== */
.alert-success {
    background: #d1fae5; color: #065f46; border-radius: 8px;
    padding: 12px 16px; margin-bottom: 16px; font-size: 13px;
    border-left: 4px solid #10b981;
}
.alert-error {
    background: #fee2e2; color: #991b1b; border-radius: 8px;
    padding: 12px 16px; margin-bottom: 16px; font-size: 13px;
    border-left: 4px solid #ef4444;
}

@stack('styles')
</style>
@stack('head')
</head>
<body>

<!-- SIDEBAR -->
<div class="sidebar">
    <div class="profile">
        <div class="avatar">{{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}</div>
        <div>
            <div class="profile-name">{{ auth()->user()->name ?? 'User' }}</div>
            <div class="profile-role">Anggota</div>
        </div>
    </div>

    <a href="{{ route('dashboard') }}"
       class="nav-item {{ request()->is('/') || request()->routeIs('dashboard') ? 'active' : '' }}">
        <i class="fas fa-home"></i> Home
    </a>
    <a href="{{ route('user.borrows') }}"
       class="nav-item {{ request()->routeIs('user.borrows') || request()->routeIs('borrows.*') ? 'active' : '' }}">
        <i class="fas fa-history"></i> Riwayat Peminjaman
    </a>
    <a href="{{ route('books.catalog') }}"
       class="nav-item {{ request()->routeIs('books.catalog*') || request()->routeIs('books.catalog.user') ? 'active' : '' }}">
        <i class="fas fa-book-open"></i> Katalog Buku
    </a>
    <a href="{{ route('user.reviews.index') }}"
       class="nav-item {{ request()->routeIs('user.reviews.*') ? 'active' : '' }}">
        <i class="fas fa-star"></i> Ulasan Saya
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

<!-- MAIN WRAPPER -->
<div class="main-wrapper">

    <!-- TOPBAR -->
    <div class="topbar">
        <div class="topbar-left">
            @hasSection('backUrl')
                <a href="@yield('backUrl')" class="btn-back">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            @else
                <a href="{{ route('dashboard') }}" class="btn-back">
                    <i class="fas fa-home"></i> Home
                </a>
            @endif
            <div class="topbar-title">@yield('pageTitle', 'Bookify')</div>
        </div>
        <div class="topbar-user">
            <div class="topbar-avatar">{{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}</div>
            <span>{{ auth()->user()->name ?? 'User' }}</span>
        </div>
    </div>

    <!-- CONTENT -->
    <div class="page-content">
        @if(session('success'))
            <div class="alert-success"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert-error"><i class="fas fa-exclamation-circle"></i> {{ session('error') }}</div>
        @endif
        @if($errors->any())
            <div class="alert-error"><i class="fas fa-exclamation-circle"></i> {{ $errors->first() }}</div>
        @endif

        @yield('content')
    </div>

</div>

@stack('scripts')
</body>
</html>
