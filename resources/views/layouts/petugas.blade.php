<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>@yield('title', 'Petugas - Bookify')</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Poppins', sans-serif; background: #3d7a5c; min-height: 100vh; }

        .dash-wrap { display: flex; min-height: 100vh; }

        /* ===== SIDEBAR ===== */
        .sidebar {
            width: 210px;
            background: #2b5240;
            padding: 24px 0;
            display: flex;
            flex-direction: column;
            flex-shrink: 0;
            min-height: 100vh;
        }
        .sidebar-logo {
            display: flex; align-items: center; justify-content: center;
            margin-bottom: 32px; padding: 0 20px;
        }
        .logo-circle {
            width: 52px; height: 52px; border-radius: 50%;
            background: #4a9b7a; border: 3px solid #6abf9a;
            display: flex; align-items: center; justify-content: center;
            font-size: 24px; font-weight: 700; color: white;
        }

        .nav-item {
            display: flex; align-items: center; gap: 12px;
            padding: 12px 24px;
            color: #a8d5be; text-decoration: none;
            font-size: 14px; font-weight: 500;
            transition: all 0.15s;
            border-left: 3px solid transparent;
        }
        .nav-item:hover { background: rgba(255,255,255,0.08); color: #fff; border-left-color: #6abf9a; }
        .nav-item.active { background: rgba(255,255,255,0.12); color: #fff; border-left-color: #6abf9a; font-weight: 600; }
        .nav-item i { width: 18px; text-align: center; font-size: 15px; }

        .nav-logout { margin-top: auto; padding-top: 16px; border-top: 1px solid rgba(255,255,255,0.1); }
        .nav-logout form { margin: 0; }
        .nav-logout button {
            display: flex; align-items: center; gap: 12px;
            padding: 12px 24px; color: #a8d5be; background: none; border: none;
            font-size: 14px; font-weight: 500; cursor: pointer;
            width: 100%; text-align: left; font-family: 'Poppins', sans-serif;
            transition: all 0.15s;
        }
        .nav-logout button:hover { color: #fff; background: rgba(255,255,255,0.08); }
        .nav-logout button i { width: 18px; text-align: center; }

        /* ===== MAIN ===== */
        .main-content { flex: 1; padding: 24px 28px; overflow-x: hidden; }

        /* ===== TOPBAR ===== */
        .topbar { display: flex; align-items: center; justify-content: space-between; margin-bottom: 24px; }
        .search-wrap { position: relative; flex: 1; max-width: 400px; }
        .search-wrap i { position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: #999; font-size: 14px; }
        .search-wrap input {
            width: 100%; background: white; border: none; outline: none;
            border-radius: 24px; padding: 10px 18px 10px 40px;
            font-size: 14px; font-family: 'Poppins', sans-serif; color: #333;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        }
        .topbar-right { display: flex; align-items: center; gap: 10px; color: white; font-size: 14px; font-weight: 600; }
        .topbar-avatar {
            width: 38px; height: 38px; border-radius: 50%;
            background: #2b5240; border: 2px solid rgba(255,255,255,0.4);
            display: flex; align-items: center; justify-content: center;
            font-size: 15px; font-weight: 700; color: white;
        }

        /* ===== PAGE HEADER ===== */
        .page-header { text-align: center; margin-bottom: 24px; }
        .page-header h1 { font-size: 26px; font-weight: 700; color: #ffffff; text-shadow: 0 1px 3px rgba(0,0,0,0.2); }

        /* ===== STAT CARDS ===== */
        .stats-row { display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px; margin-bottom: 24px; }
        .stat-card {
            background: #4a9b7a; border-radius: 12px; padding: 18px 20px;
            text-align: center; box-shadow: 0 3px 10px rgba(0,0,0,0.15);
        }
        .stat-card .stat-label { font-size: 13px; color: rgba(255,255,255,0.85); margin-bottom: 8px; font-weight: 500; }
        .stat-card .stat-num { font-size: 32px; font-weight: 700; color: #ffffff; line-height: 1; }

        /* ===== CARD BOX ===== */
        .card-box {
            background: white; border-radius: 12px; padding: 20px 22px;
            margin-bottom: 18px; box-shadow: 0 2px 10px rgba(0,0,0,0.08);
        }
        .card-title { font-size: 15px; font-weight: 600; color: #2b5240; margin-bottom: 16px; }

        /* ===== TABLE ===== */
        .tbl { width: 100%; border-collapse: collapse; font-size: 13px; }
        .tbl thead tr { background: #f0f7f4; }
        .tbl th { padding: 10px 14px; text-align: left; color: #2b5240; font-weight: 600; font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px; }
        .tbl td { padding: 11px 14px; color: #333; border-bottom: 1px solid #f0f5f2; }
        .tbl tbody tr:hover { background: #f7fbf9; }
        .tbl tbody tr:last-child td { border-bottom: none; }

        /* ===== BADGE ===== */
        .badge-green  { background: #d0f0e0; color: #1a6640; padding: 4px 12px; border-radius: 20px; font-size: 11px; font-weight: 600; }
        .badge-yellow { background: #fff3cd; color: #856404; padding: 4px 12px; border-radius: 20px; font-size: 11px; font-weight: 600; }
        .badge-red    { background: #fde8e8; color: #9b1c1c; padding: 4px 12px; border-radius: 20px; font-size: 11px; font-weight: 600; }
        .badge-blue   { background: #dbeafe; color: #1e40af; padding: 4px 12px; border-radius: 20px; font-size: 11px; font-weight: 600; }
        .badge-gray   { background: #f3f4f6; color: #6b7280; padding: 4px 12px; border-radius: 20px; font-size: 11px; font-weight: 600; }

        /* ===== FORM ===== */
        .form-field {
            width: 100%; padding: 10px 14px;
            border: 1.5px solid #c8e0d4; border-radius: 8px;
            font-size: 13px; font-family: 'Poppins', sans-serif; color: #333;
            background: #f7fbf9; outline: none; transition: border 0.15s;
        }
        .form-field:focus { border-color: #4a9b7a; background: white; }

        /* ===== BUTTONS ===== */
        .btn-primary {
            background: #2b5240; color: white; border: none;
            border-radius: 8px; padding: 10px 20px;
            font-size: 13px; font-weight: 600; cursor: pointer;
            font-family: 'Poppins', sans-serif; transition: background 0.15s;
            display: inline-flex; align-items: center; gap: 6px;
        }
        .btn-primary:hover { background: #1e3d2e; }
        .btn-danger {
            background: #dc2626; color: white; border: none;
            border-radius: 6px; padding: 6px 14px;
            font-size: 12px; font-weight: 600; cursor: pointer;
            font-family: 'Poppins', sans-serif; transition: background 0.15s;
        }
        .btn-danger:hover { background: #b91c1c; }
        .btn-success {
            background: #16a34a; color: white; border: none;
            border-radius: 6px; padding: 6px 14px;
            font-size: 12px; font-weight: 600; cursor: pointer;
            font-family: 'Poppins', sans-serif; transition: background 0.15s;
        }
        .btn-success:hover { background: #15803d; }
        .btn-secondary {
            background: #4a9b7a; color: white; border: none;
            border-radius: 8px; padding: 10px 18px;
            font-size: 13px; font-weight: 600; cursor: pointer;
            font-family: 'Poppins', sans-serif; transition: background 0.15s;
            text-decoration: none; display: inline-flex; align-items: center; gap: 6px;
        }
        .btn-secondary:hover { background: #3d8a6a; color: white; }

        /* ===== ALERT ===== */
        .alert-success {
            background: #d1fae5; color: #065f46;
            border-radius: 8px; padding: 12px 16px;
            margin-bottom: 16px; font-size: 13px;
            border-left: 4px solid #10b981;
        }
        .alert-error {
            background: #fee2e2; color: #991b1b;
            border-radius: 8px; padding: 12px 16px;
            margin-bottom: 16px; font-size: 13px;
            border-left: 4px solid #ef4444;
        }

        .grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 18px; margin-bottom: 18px; }

        @media (max-width: 900px) {
            .stats-row { grid-template-columns: repeat(2,1fr); }
            .grid-2 { grid-template-columns: 1fr; }
        }
    </style>
    @stack('styles')
</head>
<body>
<div class="dash-wrap">

    <!-- SIDEBAR PETUGAS -->
    <div class="sidebar">
        <div class="sidebar-logo">
            <div class="logo-circle">B</div>
        </div>

        <a href="{{ route('petugas.dashboard') }}" class="nav-item {{ request()->routeIs('petugas.dashboard') ? 'active' : '' }}">
            <i class="fas fa-th-large"></i> Dashboard
        </a>
        <a href="{{ route('petugas.books') }}" class="nav-item {{ request()->routeIs('petugas.books*') ? 'active' : '' }}">
            <i class="fas fa-book"></i> Data Buku
        </a>
        <a href="{{ route('petugas.borrows') }}" class="nav-item {{ request()->routeIs('petugas.borrows*') ? 'active' : '' }}">
            <i class="fas fa-exchange-alt"></i> Peminjaman &amp; Pengembalian
        </a>
        <a href="{{ route('petugas.reports.books') }}" class="nav-item {{ request()->routeIs('petugas.reports.*') ? 'active' : '' }}">
            <i class="fas fa-chart-bar"></i> Generate Laporan
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
    <div class="main-content">
        <div class="topbar">
            <div class="search-wrap">
                <i class="fas fa-search"></i>
                <input type="text" placeholder="Search">
            </div>
            <div class="topbar-right">
                <div class="topbar-avatar">{{ strtoupper(substr(auth()->user()->name ?? 'P', 0, 1)) }}</div>
                <span>{{ auth()->user()->name ?? 'Petugas' }}</span>
            </div>
        </div>

        @if(session('success'))
            <div class="alert-success"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert-error"><i class="fas fa-exclamation-circle"></i> {{ session('error') }}</div>
        @endif

        @yield('content')
    </div>
</div>
@stack('scripts')
</body>
</html>
