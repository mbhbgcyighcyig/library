<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BOOKIFY Register</title>

    <link href="https://fonts.googleapis.com/css2?family=Newsreader:wght@400;600;700;800&display=swap" rel="stylesheet">

    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Newsreader', serif;
            height: 100vh;
            background: url('/asset/login.png') no-repeat center center/cover;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .register-container {
            width: 470px;
            background: rgba(201, 221, 235, 0.95);
            border-radius: 30px;
            padding: 35px;
            text-align: center;
            box-shadow: 0 8px 20px rgba(0,0,0,0.2);
        }

        .register-container h1 {
            font-size: 42px;
            font-weight: 800;
            margin-bottom: 30px;
            color: #000;
            letter-spacing: 1px;
        }

        .input-group { margin-bottom: 22px; }

        .input-group input {
            width: 100%;
            height: 50px;
            border: none;
            border-radius: 12px;
            padding: 0 20px;
            font-size: 18px;
            font-family: 'Newsreader', serif;
            background: #f8f8f8;
            outline: none;
        }

        .input-group input.is-invalid {
            border: 2px solid #e74c3c;
        }

        .error-text {
            color: #e74c3c;
            font-size: 13px;
            margin-top: 5px;
            text-align: left;
        }

        .register-btn {
            width: 160px;
            height: 48px;
            background: #4d76a1;
            border: none;
            border-radius: 12px;
            font-size: 22px;
            font-family: 'Newsreader', serif;
            color: white;
            cursor: pointer;
            margin-top: 8px;
            margin-bottom: 22px;
            transition: 0.3s;
        }

        .register-btn:hover {
            background: #3d648d;
        }

        .login-text {
            font-size: 16px;
            color: #111;
        }

        .login-text a {
            color: #2f5f8f;
            text-decoration: none;
            font-weight: 600;
        }

        .login-text a:hover {
            text-decoration: underline;
        }

        @media (max-width: 768px) {
            .register-container {
                width: 90%;
                padding: 28px 20px;
            }

            .register-container h1 {
                font-size: 34px;
            }

            .input-group input {
                height: 46px;
                font-size: 16px;
            }

            .register-btn {
                width: 145px;
                height: 44px;
                font-size: 18px;
            }

            .login-text {
                font-size: 14px;
            }
        }
    </style>
</head>

<body>

<div class="register-container">
    <h1>BOOKIFY</h1>

    <!-- ✅ SUDAH DIPERBAIKI -->
    <form action="{{ route('register.post') }}" method="POST">
        @csrf

        <div class="input-group">
            <input type="text" name="name" placeholder="NAMA"
                value="{{ old('name') }}"
                class="{{ $errors->has('name') ? 'is-invalid' : '' }}" required>
            @error('name') <div class="error-text">{{ $message }}</div> @enderror
        </div>

        <div class="input-group">
            <input type="text" name="username" placeholder="USERNAME"
                value="{{ old('username') }}"
                class="{{ $errors->has('username') ? 'is-invalid' : '' }}" required>
            @error('username') <div class="error-text">{{ $message }}</div> @enderror
        </div>

        <div class="input-group">
            <input type="text" name="phone" placeholder="NO HANDPHONE"
                value="{{ old('phone') }}"
                class="{{ $errors->has('phone') ? 'is-invalid' : '' }}" required>
            @error('phone') <div class="error-text">{{ $message }}</div> @enderror
        </div>

        <div class="input-group">
            <input type="email" name="email" placeholder="EMAIL"
                value="{{ old('email') }}"
                class="{{ $errors->has('email') ? 'is-invalid' : '' }}" required>
            @error('email') <div class="error-text">{{ $message }}</div> @enderror
        </div>

        <div class="input-group">
            <input type="password" name="password" placeholder="PASSWORD"
                class="{{ $errors->has('password') ? 'is-invalid' : '' }}" required>
            @error('password') <div class="error-text">{{ $message }}</div> @enderror
        </div>

        <button type="submit" class="register-btn">DAFTAR</button>

        <p class="login-text">
            Sudah memiliki akun?
            <a href="{{ route('login') }}">Login</a>
        </p>
    </form>

</div>

</body>
</html>