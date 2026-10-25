<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Barang | Jatilawang Adventure</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
    * {
        box-sizing: border-box;
    }

    body {
        margin: 0;
        background: #f4f6f9;
        font-family: 'Poppins', sans-serif;
    }

    /* KONTEN UTAMA */
    .main {
        margin-left: 280px;
        padding: 35px;
        min-height: 100vh;
    }

    /* FORM TAMBAH BARANG */
    .card-form {
        width: 100%;
        max-width: 900px;
        margin: 0 auto;
        padding: 35px;
        background: white;
        border-radius: 20px;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
    }

    .card-form h3 {
        color: #2f3e2c;
        font-size: 24px;
        font-weight: 700;
        margin-bottom: 30px;
    }

    .form-label {
        font-weight: 500;
        font-size: 14px;
        margin-bottom: 8px;
    }

    .form-control,
    .form-select {
        min-height: 48px;
        border-radius: 10px;
        font-family: 'Poppins', sans-serif;
        font-size: 14px;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: #4f6b4a;
        box-shadow: 0 0 0 0.2rem rgba(79, 107, 74, 0.15);
    }

    .form-text {
        font-size: 12px;
    }

    /* TOMBOL */
    .btn-simpan,
    .btn-kembali {
        padding: 10px 18px;
        border: none;
        border-radius: 8px;
        font-family: 'Poppins', sans-serif;
        font-size: 14px;
        text-decoration: none;
        display: inline-block;
    }

    .btn-simpan {
        background: #16a34a;
        color: white;
    }

    .btn-simpan:hover {
        background: #15803d;
        color: white;
    }

    .btn-kembali {
        background: #64748b;
        color: white;
    }

    .btn-kembali:hover {
        background: #475569;
        color: white;
    }

    @media (max-width: 768px) {
        .main {
            margin-left: 0;
            padding: 18px;
        }

        .card-form {
            padding: 22px;
        }

        .card-form h3 {
            font-size: 20px;
        }
    }

    /* SIDEBAR */
    .sidebar {
        position: fixed;
        top: 0;
        left: 0;
        width: 260px;
        height: 100vh;
        padding: 25px;
        background: #2f3e2c;
        color: white;
        overflow-y: auto;
        z-index: 1000;
    }

    .logo {
        display: flex;
        align-items: center;
        gap: 12px;
        font-size: 22px;
        font-weight: 700;
        margin-bottom: 40px;
    }

    .logo>i {
        font-size: 30px;
    }

    .logo span {
        display: block;
        color: #facc15;
    }

    .sidebar a {
        display: block;
        padding: 12px;
        margin-bottom: 10px;
        border-radius: 12px;
        color: white;
        text-decoration: none;
        font-size: 14px;
        transition: 0.2s;
    }

    .sidebar a i {
        margin-right: 10px;
    }

    .sidebar a:hover,
    .sidebar a.active {
        background: rgba(255, 255, 255, 0.15);
        color: white;
    }

    .logout-form {
        margin-top: 35px;
    }

    .sidebar .logout {
        width: 100%;
        border: none;
        text-align: left;
        background: transparent;
        color: white;
        padding: 12px;
        border-radius: 12px;
        font-family: inherit;
        font-size: 14px;
    }

    .sidebar .logout:hover {
        background: rgba(255, 255, 255, 0.15);
    }

    @media (max-width: 768px) {
        .sidebar {
            position: relative;
            width: 100%;
            height: auto;
        }
    }
    </style>
</head>

<body>

    {{-- SIDEBAR YANG SAMA DENGAN HALAMAN LAIN --}}
    @include('layouts.sidebar')

    <main class="main">

        <section class="card-form">

            <h3>
                <i class="bi bi-plus-circle-fill me-2"></i>
                Tambah Barang Camping
            </h3>

            {{-- NOTIFIKASI ERROR --}}
            @if ($errors->any())
            <div class="alert alert-danger">
                <strong>Data belum berhasil disimpan.</strong>
                <ul class="mb-0 mt-2">
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
            @endif

            <form action="{{ route('barang.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-3">
                    <label for="nama_barang" class="form-label">Nama Barang</label>
                    <input type="text" id="nama_barang" name="nama_barang" class="form-control"
                        value="{{ old('nama_barang') }}" placeholder="Masukkan nama barang" required>
                </div>

                <div class="mb-3">
                    <label for="merk" class="form-label">Merk</label>
                    <input type="text" id="merk" name="merk" class="form-control" value="{{ old('merk') }}"
                        placeholder="Masukkan merk barang" required>
                </div>

                <div class="mb-3">
                    <label for="kategori" class="form-label">Kategori</label>
                    <select id="kategori" name="kategori" class="form-select" required>
                        <option value="">-- Pilih Kategori --</option>
                        @foreach ([
                        'Tenda',
                        'Carrier',
                        'Peralatan Masak',
                        'Peralatan Tidur',
                        'Peralatan Tracking',
                        'Penerangan',
                        'Peralatan Lainnya'
                        ] as $kategori)
                        <option value="{{ $kategori }}" {{ old('kategori') == $kategori ? 'selected' : '' }}>
                            {{ $kategori }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="harga" class="form-label">Harga Sewa / Hari (Rp)</label>
                    <input type="number" id="harga" name="harga" class="form-control" value="{{ old('harga') }}" min="0"
                        placeholder="Masukkan harga sewa" required>
                </div>

                <div class="mb-3">
                    <label for="stok" class="form-label">Stok</label>
                    <input type="number" id="stok" name="stok" class="form-control" value="{{ old('stok') }}" min="0"
                        placeholder="Masukkan jumlah stok" required>
                </div>

                <div class="mb-4">
                    <label for="gambar" class="form-label">Gambar Barang</label>
                    <input type="file" id="gambar" name="gambar" class="form-control" accept=".jpg,.jpeg,.png,.webp"
                        required>
                    <div class="form-text">
                        Format gambar: JPG, JPEG, PNG, atau WEBP. Maksimal 2 MB.
                    </div>
                </div>

                <div class="d-flex flex-wrap gap-2">
                    <button type="submit" class="btn-simpan">
                        <i class="bi bi-save me-1"></i>
                        Simpan
                    </button>

                    <a href="{{ route('barang.index') }}" class="btn-kembali">
                        <i class="bi bi-arrow-left me-1"></i>
                        Kembali
                    </a>
                </div>

            </form>

        </section>

    </main>

</body>

</html> ini taro mana