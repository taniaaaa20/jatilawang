<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Tambah Pegawai | Jatilawang Adventure</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            background: #f4f6f3;
            font-family: 'Poppins', sans-serif;
            color: #26332b;
        }

        .main {
            margin-left: 250px;
            padding: 30px;
            min-height: 100vh;
            width: calc(100% - 250px);
        }

        .page-header {
            margin-bottom: 28px;
        }

        .page-header h2 {
            font-size: 25px;
            font-weight: 700;
            margin-bottom: 8px;
        }

        .page-header p {
            color: #6b756e;
            margin-bottom: 0;
            font-size: 14px;
        }

        .form-card {
            background: white;
            padding: 28px;
            border-radius: 18px;
            box-shadow: 0 5px 18px rgba(0, 0, 0, .05);
            width: 100%;
        }

        .form-card h4 {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 24px;
        }

        .form-label {
            font-size: 13px;
            font-weight: 600;
            margin-bottom: 8px;
        }

        .form-control,
        .form-select {
            padding: 11px 13px;
            border-radius: 10px;
            border: 1px solid #dce3dc;
            font-size: 13px;
            font-family: 'Poppins', sans-serif;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #526c59;
            box-shadow: 0 0 0 .2rem rgba(24, 50, 38, .10);
        }

        .form-text {
            font-size: 11px;
        }

        .btn-simpan {
            background: #183226;
            color: white;
            border: none;
            border-radius: 10px;
            padding: 10px 20px;
            font-size: 13px;
            font-weight: 500;
        }

        .btn-simpan:hover {
            background: #394a39;
            color: white;
        }

        .btn-batal {
            background: #e8ece7;
            color: #26332b;
            border: none;
            border-radius: 10px;
            padding: 10px 20px;
            font-size: 13px;
            font-weight: 500;
        }

        .btn-batal:hover {
            background: #dce3dc;
            color: #26332b;
        }

        .alert {
            border-radius: 12px;
            font-size: 13px;
        }

        @media (max-width: 900px) {
            .main {
                margin-left: 200px;
                padding: 20px;
                width: calc(100% - 200px);
            }
        }

        @media (max-width: 600px) {
            .main {
                margin-left: 0;
                padding: 16px;
                width: 100%;
            }

            .form-card {
                padding: 20px;
            }

            .page-header h2 {
                font-size: 21px;
            }
        }
    </style>
</head>

<body>

    @include('layouts.sidebar_pemilik')

    <main class="main">

        <div class="page-header">
            <h2>Tambah Pegawai</h2>
            <p>Dashboard / Kelola Pegawai / Tambah Pegawai</p>
        </div>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                <strong>Data belum bisa disimpan.</strong>
                <ul class="mb-0 mt-2">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="form-card">
            <h4>
                <i class="bi bi-person-plus-fill me-2"></i>
                Form Tambah Pegawai
            </h4>

            <form action="{{ route('pemilik.pegawai.store') }}" method="POST">
                @csrf

                <div class="row g-4">

                    <div class="col-md-6">
                        <label for="nama_pegawai" class="form-label">
                            Nama Pegawai
                        </label>
                        <input
                            type="text"
                            id="nama_pegawai"
                            name="nama_pegawai"
                            class="form-control"
                            maxlength="50"
                            value="{{ old('nama_pegawai') }}"
                            placeholder="Masukkan nama lengkap"
                            required
                        >
                    </div>

                    <div class="col-md-6">
                        <label for="noHP_pegawai" class="form-label">
                            Nomor HP
                        </label>
                        <input
                            type="text"
                            id="noHP_pegawai"
                            name="noHP_pegawai"
                            class="form-control"
                            maxlength="15"
                            value="{{ old('noHP_pegawai') }}"
                            placeholder="Masukkan nomor HP"
                            required
                        >
                    </div>

                    <div class="col-md-6">
                        <label for="username" class="form-label">
                            Username
                        </label>
                        <input
                            type="text"
                            id="username"
                            name="username"
                            class="form-control"
                            maxlength="30"
                            value="{{ old('username') }}"
                            placeholder="Masukkan username"
                            required
                        >
                    </div>

                    <div class="col-md-6">
                        <label for="password" class="form-label">
                            Password
                        </label>
                        <input
                            type="password"
                            id="password"
                            name="password"
                            class="form-control"
                            minlength="8"
                            placeholder="Minimal 8 karakter"
                            required
                        >
                        <div class="form-text">
                            Password akan disimpan dalam bentuk hash.
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label for="role" class="form-label">
                            Role
                        </label>
                        <select
                            id="role"
                            name="role"
                            class="form-select"
                            required
                        >
                            <option value="">Pilih role</option>
                            <option value="pegawai" {{ old('role') == 'pegawai' ? 'selected' : '' }}>
                                Pegawai
                            </option>
                            <option value="pemilik" {{ old('role') == 'pemilik' ? 'selected' : '' }}>
                                Pemilik
                            </option>
                        </select>
                    </div>

                </div>

                <hr class="my-4">

                <div class="d-flex flex-wrap gap-2">
                    <button type="submit" class="btn btn-simpan">
                        <i class="bi bi-check-circle me-1"></i>
                        Simpan Pegawai
                    </button>

                    <a href="{{ route('pemilik.pegawai.index') }}" class="btn btn-batal">
                        Batal
                    </a>
                </div>
            </form>
        </div>

    </main>

</body>
</html>
