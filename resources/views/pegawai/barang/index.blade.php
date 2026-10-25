<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Barang | Jatilawang Adventure</title>

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
        display: flex;
        align-items: center;
        padding: 12px;
        margin-bottom: 10px;
        border-radius: 12px;
        color: white;
        text-decoration: none;
        font-size: 14px;
        transition: .2s;
    }

    .sidebar a i {
        margin-right: 10px;
    }

    .sidebar a:hover,
    .sidebar a.active {
        background: rgba(255, 255, 255, .15);
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
    }

    .sidebar .logout:hover {
        background: rgba(255, 255, 255, .15);
    }

    /* KONTEN UTAMA */
    .main {
        margin-left: 260px;
        min-height: 100vh;
        padding: 30px;
    }

    .container-fluid {
        width: 100%;
        padding: 0;
        margin: 0;
    }

    /* KARTU DATA BARANG */
    .barang-card {
        width: 100%;
        padding: 24px;
        margin-top: 10px;
        border: none;
        border-radius: 20px;
        background: white;
        box-shadow: 0 5px 20px rgba(0, 0, 0, .08);
    }

    .barang-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 20px;
        margin-bottom: 24px;
    }

    .barang-header h3 {
        margin: 0;
        font-size: 25px;
        font-weight: 700;
    }

    /* TOMBOL TAMBAH */
    .btn-tambah {
        background: #16a34a;
        color: white;
        border: none;
    }

    .btn-tambah:hover {
        background: #15803d;
        color: white;
    }

    /* TABEL */
    .table-responsive {
        width: 100%;
        overflow-x: auto;
    }

    .table {
        width: 100%;
        margin-bottom: 0;
        font-size: 14px;
        vertical-align: middle;
    }

    .table thead th {
        background: #2f3e2c;
        color: white;
        font-weight: 600;
        padding: 12px 10px;
        white-space: nowrap;
        border-color: #dee2e6;
    }

    .table tbody td {
        padding: 10px;
        height: 58px;
        border-color: #dee2e6;
    }

    .table th:last-child {
        min-width: 180px;
    }

    /* GAMBAR BARANG */
    .gambar-barang {
        width: 80px;
        height: 65px;
        object-fit: contain;
        border-radius: 10px;
        display: block;
        margin: auto;
    }

    .table th:nth-child(2),
    .table td:nth-child(2) {
        min-width: 100px;
        text-align: center;
    }

    /* TOMBOL AKSI */
    .btn-edit {
        background: #f59e0b;
        color: white;
        border: none;
    }

    .btn-edit:hover {
        background: #d97706;
        color: white;
    }

    .btn-hapus {
        background: #dc2626;
        color: white;
        border: none;
    }

    .btn-hapus:hover {
        background: #b91c1c;
        color: white;
    }

    .aksi-wrapper {
        display: flex;
        align-items: center;
        gap: 6px;
        white-space: nowrap;
    }

    .aksi-wrapper form {
        margin: 0;
    }

    /* RESPONSIF */
    @media (max-width: 768px) {
        .sidebar {
            position: relative;
            width: 100%;
            height: auto;
        }

        .main {
            margin-left: 0;
            padding: 15px;
        }

        .barang-card {
            padding: 15px;
        }

        .barang-header {
            align-items: flex-start;
            flex-direction: column;
        }

        .barang-header h3 {
            font-size: 21px;
        }

        .table {
            font-size: 12px;
        }
    }
    </style>
</head>

<body>

    @include('layouts.sidebar')

    <main class="main">
        <div class="container-fluid">
            <section class="barang-card">

                <div class="barang-header">
                    <h3>
                        <i class="bi bi-box-seam-fill"></i>
                        Data Barang Camping
                    </h3>

                    <a href="{{ route('barang.create') }}" class="btn btn-tambah">
                        <i class="bi bi-plus-circle"></i>
                        Tambah Barang
                    </a>
                </div>

                {{-- PESAN BERHASIL --}}
                @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i>
                    {{ session('success') }}

                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
                </div>
                @endif

                {{-- PESAN GAGAL --}}
                @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    {{ session('error') }}

                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
                </div>
                @endif


                {{-- PESAN VALIDASI --}}
                @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Terjadi kesalahan:</strong>

                    <ul class="mb-0 mt-2">
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>

                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
                </div>
                @endif

                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Gambar</th>
                                <th>Nama Barang</th>
                                <th>Merk</th>
                                <th>Kategori</th>
                                <th>Harga</th>
                                <th>Stok</th>
                                <th width="180">Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($data_barang as $barang)
                            <tr>
                                <td>{{ $loop->iteration }}</td>

                                <td>
                                    @if (!empty($barang->gambar))
                                    <img src="{{ asset('gambar/' . $barang->gambar) }}" class="gambar-barang"
                                        alt="{{ $barang->nama_barang }}">
                                    @else
                                    <span class="text-muted">-</span>
                                    @endif
                                </td>

                                <td>{{ $barang->nama_barang }}</td>
                                <td>{{ $barang->merk }}</td>
                                <td>{{ $barang->kategori }}</td>

                                <td>
                                    Rp {{ number_format($barang->harga, 0, ',', '.') }}
                                </td>

                                <td>{{ $barang->stok }}</td>

                                <td>
                                    <div class="aksi-wrapper">
                                        <a href="{{ route('barang.edit', $barang->id_barang) }}"
                                            class="btn btn-sm btn-edit">
                                            <i class="bi bi-pencil-square"></i>
                                            Edit
                                        </a>

                                        <form action="{{ route('barang.destroy', $barang->id_barang) }}" method="POST"
                                            onsubmit="return confirm('Yakin ingin menghapus barang {{ $barang->nama_barang }}?')">

                                            @csrf
                                            @method('DELETE')

                                            <button type="submit" class="btn btn-sm btn-hapus">
                                                <i class="bi bi-trash"></i>
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="text-center py-4">
                                    Belum ada data barang.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </section>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html> in dmna