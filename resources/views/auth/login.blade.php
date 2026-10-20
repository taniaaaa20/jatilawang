
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login | Jatilawang Adventure</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css"
          rel="stylesheet">

    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap');

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;

            background:
                linear-gradient(
                    rgba(47, 62, 44, .8),
                    rgba(47, 62, 44, .8)
                ),
                url('https://images.unsplash.com/photo-1500530855697-b586d89ba3ee?q=80&w=1600&auto=format&fit=crop');

            background-size: cover;
            background-position: center;
        }

        .login-box {
            width: 430px;
            max-width: 100%;
            background: white;
            border-radius: 25px;
            padding: 40px;

            box-shadow: 0 10px 30px rgba(0, 0, 0, .25);
        }

        .logo {
            text-align: center;
            margin-bottom: 25px;
        }

        .logo i {
            font-size: 60px;
            color: #2f3e2c;
        }

        .logo h2 {
            margin-top: 10px;
            font-weight: 700;
            color: #2f3e2c;
            font-size: 27px;
        }

        .logo span {
            color: #b45309;
        }

        .subtitle {
            text-align: center;
            color: #64748b;
            margin-bottom: 25px;
            font-size: 14px;
        }

        .form-control {
            height: 55px;
            border-radius: 15px;
            margin-bottom: 15px;
            font-size: 14px;
        }

        .form-control:focus {
            box-shadow: none;
            border: 2px solid #b45309;
        }

        .btn-login {
            width: 100%;
            height: 55px;
            border: none;
            border-radius: 15px;

            background: linear-gradient(
                to right,
                #8b5e34,
                #b45309
            );

            color: white;
            font-weight: 600;
            transition: .3s;
        }

        .btn-login:hover {
            transform: translateY(-3px);
            color: white;
            box-shadow: 0 5px 15px rgba(180, 83, 9, .25);
        }

        .alert {
            font-size: 13px;
            border-radius: 12px;
        }
    </style>
</head>

<body>

    <div class="login-box">

        <div class="logo">
            <i class="bi bi-tree-fill"></i>

            <h2>
                Jatilawang
                <span>Adventure</span>
            </h2>
        </div>

        <p class="subtitle">
            Sistem Rental Perlengkapan Gunung
        </p>

        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                Username dan password wajib diisi.
            </div>
        @endif

        <form action="{{ route('login.process') }}" method="POST">
            @csrf

            <input
                type="text"
                name="username"
                class="form-control"
                placeholder="Username"
                value="{{ old('username') }}"
                required
                autofocus
            >

            <input
                type="password"
                name="password"
                class="form-control"
                placeholder="Password"
                required
            >

            <button type="submit" class="btn-login">
                <i class="bi bi-box-arrow-in-right"></i>
                Login
            </button>

        </form>

    </div>

</body>

</html>
