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
            background: #f4f6f3;
            font-family: 'Poppins', sans-serif;
            color: #26332b;
        }

        .main {
            margin-left: 250px;
            padding: 30px;
            min-height: 100vh;
        }

        .welcome {
            background: linear-gradient(135deg, #183226, #374151);
            color: white;
            padding: 32px;
            border-radius: 22px;
            margin-bottom: 28px;
        }

        .welcome h2 {
            font-size: 25px;
            font-weight: 700;
            margin-bottom: 0;
        }

        .welcome p {
            margin: 10px 0 0;
            color: #e5e7eb;
            font-size: 14px;
        }

        .card-stat {
            border: none;
            border-radius: 18px;
            color: white;
            padding: 23px;
            min-height: 165px;
            height: 100%;
            box-shadow: 0 5px 18px rgba(0, 0, 0, .07);
        }

        .card-stat i {
            font-size: 32px;
        }

        .card-stat h2 {
            margin-top: 15px;
            font-size: 27px;
            font-weight: 700;
            overflow-wrap: anywhere;
        }

        .card-stat p {
            margin-bottom: 0;
            font-size: 13px;
        }

        .barang {
            background: linear-gradient(135deg, #365314, #4d7c0f);
        }

        .transaksi {
            background: linear-gradient(135deg, #0f766e, #14b8a6);
        }

        .customer {
            background: linear-gradient(135deg, #1e3a8a, #2563eb);
        }

        .aktif {
            background: linear-gradient(135deg, #b45309, #f59e0b);
            color: #fff;
        }

        .table-card {
            background: white;
            padding: 24px;
            border-radius: 18px;
            margin-top: 28px;
            box-shadow: 0 5px 18px rgba(0, 0, 0, .05);
        }

        .table-card h5 {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 20px;
        }

        .table {
            margin-bottom: 0;
        }

        .table thead th {
            background: #f1f5f1;
            color: #405348;
            font-size: 12px;
            white-space: nowrap;
            padding: 14px;
        }

        .table tbody td {
            font-size: 12px;
            vertical-align: middle;
            padding: 14px;
        }

        @media (max-width: 900px) {
            .sidebar {
                width: 200px;
            }

            .main {
                margin-left: 200px;
                padding: 20px;
            }
        }

        @media (max-width: 600px) {
            .sidebar {
                position: relative;
                width: 100%;
                height: auto;
            }

            .main {
                margin-left: 0;
                padding: 16px;
            }

            .welcome {
                padding: 24px;
            }

            .table-card {
                padding: 16px;
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

            <div class="col-6 col-xl-3">
                <div class="card-stat barang">
                    <i class="bi bi-box-seam-fill"></i>
                    <h2>{{ $total_barang }}</h2>
                    <p>Total Barang</p>
                </div>
            </div>

            <div class="col-6 col-xl-3">
                <div class="card-stat transaksi">
                    <i class="bi bi-cart-check-fill"></i>
                    <h2>{{ $total_transaksi }}</h2>
                    <p>Total Transaksi</p>
                </div>
            </div>

            <div class="col-6 col-xl-3">
                <div class="card-stat customer">
                    <i class="bi bi-people-fill"></i>
                    <h2>{{ $total_customer }}</h2>
                    <p>Total Customer</p>
                </div>
            </div>

            <div class="col-6 col-xl-3">
                <div class="card-stat aktif">
                    <i class="bi bi-hourglass-split"></i>
                    <h2>{{ $total_aktif }}</h2>
                    <p>Rental Aktif</p>
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

                    <thead>
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
                                <td>
                                    Rp {{ number_format($barang->harga, 0, ',', '.') }}
                                </td>
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
