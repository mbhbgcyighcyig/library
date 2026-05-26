<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>

    <!-- Font -->
    <link href="https://fonts.googleapis.com/css2?family=Georgia&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!-- Bootstrap (optional, tapi dipakai di grid rekomendasi kamu) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            margin: 0;
            padding: 0;
        }

        /* OPTIONAL GLOBAL FIX */
        a {
            text-decoration: none;
        }

        /* biar gak overflow */
        html, body {
            overflow-x: hidden;
        }
    </style>

    @stack('styles')
</head>
<body>

    {{-- Navbar bisa disembunyikan --}}
    @hasSection('hideNavbar')
        {{-- kosong --}}
    @else
       
    @endif

    {{-- CONTENT --}}
    @yield('content')

    <!-- Bootstrap JS (biar row/col aman) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    @stack('scripts')
</body>
</html>