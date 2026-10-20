<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Pegawai | Jatilawang Adventure</title>

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
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 22px;
            font-weight: 700;
            margin-bottom: 40px;
        }

        .logo > i {
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
            transition: 0.2s;
        }

        .sidebar a:hover,
        .sidebar a.active {
            background: rgba(255, 255, 255, 0.15);
        }

        .sidebar a i {
            margin-right: 10px;
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
            background: rgba(255, 255, 255, 0.15);
        }

        .main {
            margin-left: 280px;
            padding: 35px;
        }

        .welcome {
            padding: 35px;
            margin-bottom: 30px;
            border-radius: 25px;
            color: white;
            background: linear-gradient(135deg, #2f3e2c, #4f6b4a);
        }

        .welcome h2 {
            font-weight: 700;
        }

        .welcome p {
            margin-bottom: 0;
        }

        .card-stat {
            height: 100%;
            padding: 25px;
            border-radius: 20px;
            color: white;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            transition: 0.2s;
        }

        .card-stat:hover {
            transform: translateY(-5px);
        }

        .card-stat i {
            font-size: 35px;
        }

        .card-stat h2 {
            margin-top: 15px;
            font-weight: 700;
        }

        .barang {
            background: linear-gradient(135deg, #16a34a, #22c55e);
        }

        .transaksi {
            background: linear-gradient(135deg, #2563eb, #60a5fa);
        }

        .customer {
            background: linear-gradient(135deg, #d97706, #facc15);
        }

        .aktif {
            background: linear-gradient(135deg, #7c3aed, #a78bfa);
        }

        .table-card {
            padding: 25px;
            margin-top: 30px;
            border-radius: 20px;
            background: white;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }

        .table-card h5 {
            font-weight: 700;
            margin-bottom: 20px;
        }

        @media (max-width: 768px) {
            .sidebar {
                position: relative;
                width: 100%;
                height: auto;
            }

            .main {
                margin-left: 0;
                padding: 20px;
            }

            .welcome {
                padding: 25px;
            }
        }
    </style>
</head>

<body>
    @include('layouts.sidebar')

    <main class="main">
        <section class="welcome">
            <h2>Dashboard Pegawai</h2>
            <p>
                Selamat datang, {{ session('nama_pegawai') }}!
                Semoga aktivitas hari ini berjalan lancar.
            </p>
        </section>

        <div class="row g-4">
            <div class="col-md-6 col-xl-3">
                <div class="card-stat barang">
                    <i class="bi bi-box-seam-fill"></i>
                    <p class="mb-0 mt-3">Total Barang</p>
                    <h2>{{ $total_barang }}</h2>
                </div>
            </div>

            <div class="col-md-6 col-xl-3">
                <div class="card-stat transaksi">
                    <i class="bi bi-cart-check-fill"></i>
                    <p class="mb-0 mt-3">Total Transaksi</p>
                    <h2>{{ $total_transaksi }}</h2>
                </div>
            </div>

            <div class="col-md-6 col-xl-3">
                <div class="card-stat customer">
                    <i class="bi bi-people-fill"></i>
                    <p class="mb-0 mt-3">Total Customer</p>
                    <h2>{{ $total_customer }}</h2>
                </div>
            </div>

            <div class="col-md-6 col-xl-3">
                <div class="card-stat aktif">
                    <i class="bi bi-hourglass-split"></i>
                    <p class="mb-0 mt-3">Rental Aktif</p>
                    <h2>{{ $total_aktif }}</h2>
                </div>
            </div>
        </div>

        <section class="table-card">
            <h5>
                <i class="bi bi-box-seam-fill me-2"></i>
                Barang Terbaru
            </h5>

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Nama Barang</th>
                            <th>Merk</th>
                            <th>Kategori</th>
                            <th>Harga</th>
                            <th>Stok</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($data_barang as $barang)
                            <tr>
                                <td>{{ $barang->nama_barang }}</td>
                                <td>{{ $barang->merk }}</td>
                                <td>{{ $barang->kategori }}</td>
                                <td>Rp {{ number_format($barang->harga, 0, ',', '.') }}</td>
                                <td>{{ $barang->stok }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-4">
                                    Belum ada data barang.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>
    </main>
</body>
</html>
