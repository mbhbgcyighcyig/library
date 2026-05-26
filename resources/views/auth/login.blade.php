<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BOOKIFY Login</title>

    <!-- Font -->
    <link href="https://fonts.googleapis.com/css2?family=Newsreader:wght@400;600;700;800&display=swap" rel="stylesheet">

    <style>
        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
        }

        body{
            font-family:'Newsreader',serif;
            height:100vh;
            background:url('/asset/login.png') no-repeat center center/cover;
            display:flex;
            justify-content:center;
            align-items:center;
        }

        .login-container{
            width:400px;
            background:rgba(201,221,235,.95);
            border-radius:25px;
            padding:30px;
            text-align:center;
            box-shadow:0 8px 20px rgba(0,0,0,.25);
            backdrop-filter: blur(10px);
        }

        .login-container h1{
            font-size:42px;
            font-weight:800;
            margin-bottom:30px;
            color:#000;
            letter-spacing:1px;
        }

        .input-group{
            margin-bottom:18px;
        }

        .input-group input{
            width:100%;
            height:48px;
            border-radius:12px;
            padding:0 18px;
            font-size:16px;
            border:none;
            background:#f8f8f8;
            outline:none;
            transition:.3s;
        }

        .input-group input:focus{
            transform:scale(1.02);
            box-shadow:0 0 10px rgba(77,118,161,.4);
        }

        .login-btn{
            width:150px;
            height:45px;
            background:#4d76a1;
            border:none;
            border-radius:12px;
            font-size:18px;
            color:white;
            cursor:pointer;
            margin-top:5px;
            margin-bottom:20px;
            transition:.3s;
        }

        .login-btn:hover{
            background:#35597d;
            transform:translateY(-2px);
        }

        .register-text{
            font-size:15px;
        }

        .register-text a{
            color:#2f5f8f;
            text-decoration:none;
            font-weight:700;
        }

        .register-text a:hover{
            text-decoration:underline;
        }

        .welcome-box{
            margin-top:20px;
            padding:16px;
            background:rgba(255,255,255,.45);
            backdrop-filter:blur(10px);
            border-radius:14px;
            color:#2c3e50;
            animation:fadeIn .8s ease;
        }

        .welcome-box h3{
            font-size:18px;
            margin-bottom:10px;
        }

        .welcome-box p{
            font-size:14px;
            line-height:1.6;
            opacity:.8;
        }

        @keyframes fadeIn{
            from{
                opacity:0;
                transform:translateY(15px);
            }
            to{
                opacity:1;
                transform:translateY(0);
            }
        }

    </style>
</head>

<body>

<div class="login-container">

    <h1>BOOKIFY</h1>

    <!-- FORM LOGIN -->
    <form action="{{ route('login.post') }}" method="POST">
        @csrf

        <div class="input-group">
            <input
                type="email"
                name="email"
                placeholder="EMAIL"
                required
            >
        </div>

        <div class="input-group">
            <input
                type="password"
                name="password"
                placeholder="PASSWORD"
                required
            >
        </div>

        <button type="submit" class="login-btn">
            LOGIN
        </button>

        <p class="register-text">
            Tidak punya akun?
            <a href="{{ route('register') }}">
                Daftar
            </a>
        </p>

        @if(session('success'))
            <p style="
                color:#27ae60;
                font-size:14px;
                margin-top:10px;
            ">
                {{ session('success') }}
            </p>
        @endif

        @if($errors->any())
            <p style="
                color:#e74c3c;
                font-size:14px;
                margin-top:10px;
            ">
                {{ $errors->first() }}
            </p>
        @endif

    </form>

    <!-- PENGGANTI AKUN DEMO -->

    <div class="welcome-box">

        <h3>
            📚 Welcome to BOOKIFY
        </h3>

        <p>
            Temukan, pinjam, dan kelola buku favoritmu dengan mudah.
            Membaca jadi lebih modern, cepat, dan nyaman bersama Bookify.
        </p>

    </div>

</div>

</body>
</html>