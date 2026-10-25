<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Barang | Jatilawang Adventure</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
    * {
        box-sizing: border-box;
        font-family: 'Poppins', sans-serif;
    }

    body {
        margin: 0;
        background: #f5f5f5;
        color: #212529;
    }

    /* KONTEN UTAMA */
    .main {
        margin-left: 260px;
        min-height: 100vh;
        padding: 30px;
        width: calc(100% - 260px);
    }

    .page-header {
        margin-bottom: 24px;
    }

    .page-header h3 {
        color: #2f3e2c;
        font-size: 25px;
        font-weight: 700;
        margin-bottom: 6px;
    }

    .page-header p {
        color: #6c757d;
        margin-bottom: 0;
        font-size: 14px;
    }

    /* KARTU FORM */
    .form-card {
        width: 100%;
        max-width: none;
        padding: 28px;
        border: none;
        border-radius: 20px;
        background: white;
        box-shadow: 0 5px 20px rgba(0, 0, 0, .08);
    }

    .form-card h5 {
        color: #2f3e2c;
        font-size: 18px;
        font-weight: 600;
        margin-bottom: 24px;
    }

    .form-label {
        font-size: 14px;
        font-weight: 500;
        margin-bottom: 8px;
    }

    .form-control,
    .form-select {
        border: 1px solid #dee2e6;
        border-radius: 10px;
        padding: 11px 13px;
        font-size: 14px;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: #2f3e2c;
        box-shadow: 0 0 0 .2rem rgba(47, 62, 44, .12);
    }

    .id-barang {
        background: #f1f3f1;
        color: #596357;
    }

    .form-text {
        font-size: 12px;
    }

    /* GAMBAR */
    .gambar-preview {
        width: 140px;
        height: 120px;
        object-fit: contain;
        padding: 6px;
        border: 1px solid #dee2e6;
        border-radius: 12px;
        background: #fff;
    }

    /* TOMBOL */
    .btn-simpan {
        background: #2f3e2c;
        color: white;
        border: none;
        border-radius: 9px;
        padding: 11px 18px;
        font-size: 14px;
    }

    .btn-simpan:hover {
        background: #43583e;
        color: white;
    }

    .btn-kembali {
        background: #f59e0b;
        color: white;
        border: none;
        border-radius: 9px;
        padding: 11px 18px;
        font-size: 14px;
    }

    .btn-kembali:hover {
        background: #d97706;
        color: white;
    }

    /* RESPONSIF */
    @media (max-width: 768px) {
        .main {
            margin-left: 0;
            width: 100%;
            padding: 20px 15px;
        }

        .form-card {
            padding: 20px;
        }

        .page-header h3 {
            font-size: 21px;
        }
    }
    </style>
</head>

<body>

    @include('layouts.sidebar')

    <main class="main">

        <div class="page-header">
            <h3>
                <i class="bi bi-pencil-square"></i>
                Edit Barang
            </h3>
            <p>Perbarui informasi barang camping yang tersimpan dalam sistem.</p>
        </div>

        <section class="form-card">

            <h5>
                <i class="bi bi-box-seam me-2"></i>
                Form Edit Barang
            </h5>

            {{-- PESAN ERROR --}}
            @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Data gagal diperbarui.</strong>
                <ul class="mb-0 mt-2">
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
            </div>
            @endif

            <form action="{{ route('barang.update', $data->id_barang) }}" method="POST" enctype="multipart/form-data">

                @csrf
                @method('PUT')

                {{-- ID BARANG --}}
                <div class="mb-4">
                    <label class="form-label">ID Barang</label>
                    <input type="text" class="form-control id-barang" value="{{ $data->id_barang }}" readonly>
                    <div class="form-text">ID barang tidak dapat diubah.</div>
                </div>

                {{-- NAMA BARANG --}}
                <div class="mb-4">
                    <label for="nama_barang" class="form-label">Nama Barang</label>
                    <input type="text" name="nama_barang" id="nama_barang" class="form-control"
                        value="{{ old('nama_barang', $data->nama_barang) }}" required>
                </div>

                {{-- MERK --}}
                <div class="mb-4">
                    <label for="merk" class="form-label">Merk</label>
                    <input type="text" name="merk" id="merk" class="form-control" value="{{ old('merk', $data->merk) }}"
                        required>
                </div>

                {{-- KATEGORI --}}
                <div class="mb-4">
                    <label for="kategori" class="form-label">Kategori</label>
                    <select name="kategori" id="kategori" class="form-select" required>
                        @foreach ([
                        'Carrier',
                        'Tenda',
                        'Sepatu',
                        'Jaket',
                        'Matras',
                        'Trekking Pole',
                        'Peralatan Masak'
                        ] as $kategori)
                        <option value="{{ $kategori }}"
                            {{ old('kategori', $data->kategori) == $kategori ? 'selected' : '' }}>
                            {{ $kategori }}
                        </option>
                        @endforeach
                    </select>
                </div>

                {{-- HARGA --}}
                <div class="mb-4">
                    <label for="harga" class="form-label">Harga</label>
                    <div class="input-group">
                        <span class="input-group-text">Rp</span>
                        <input type="number" name="harga" id="harga" class="form-control" min="0"
                            value="{{ old('harga', $data->harga) }}" required>
                    </div>
                </div>

                {{-- STOK --}}
                <div class="mb-4">
                    <label for="stok" class="form-label">Stok</label>
                    <input type="number" name="stok" id="stok" class="form-control" min="0"
                        value="{{ old('stok', $data->stok) }}" required>
                </div>

                {{-- GAMBAR --}}
                <div class="mb-4">
                    <label class="form-label d-block">Gambar Barang Saat Ini</label>

                    @if (
                    !empty($data->gambar) &&
                    file_exists(public_path('gambar/' . $data->gambar))
                    )
                    <img src="{{ asset('gambar/' . $data->gambar) }}" alt="{{ $data->nama_barang }}"
                        class="gambar-preview mb-3 d-block">
                    @else
                    <div class="text-muted small mb-3">
                        Belum ada gambar barang.
                    </div>
                    @endif

                    <label for="gambar" class="form-label">
                        Ganti Gambar
                    </label>

                    <input type="file" name="gambar" id="gambar" class="form-control" accept="image/*">

                    <div class="form-text">
                        Kosongkan jika gambar tidak ingin diganti.
                    </div>
                </div>

                <hr class="my-4">

                <div class="d-flex gap-2 flex-wrap">
                    <button type="submit" class="btn btn-simpan">
                        <i class="bi bi-check-circle me-1"></i>
                        Simpan Perubahan
                    </button>

                    <a href="{{ route('barang.index') }}" class="btn btn-kembali">
                        <i class="bi bi-arrow-left me-1"></i>
                        Kembali
                    </a>
                </div>

            </form>

        </section>

    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>