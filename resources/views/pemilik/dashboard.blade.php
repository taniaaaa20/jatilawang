<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Dashboard Pemilik | Jatilawang Adventure</title>

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

        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: 250px;
            height: 100vh;
            padding: 25px 16px;
            background: #183226;
            color: white;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 40px;
            padding: 0 10px;
        }

        .logo i {
            font-size: 32px;
            color: #e2e8e2;
        }

        .logo span {
            display: block;
            font-size: 24px;
            font-weight: 700;
            color: #e7bc20;
        }

        .sidebar a {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 18px;
            margin-bottom: 8px;
            border-radius: 16px; /* Membuat sudut kotak sangat membulat persis seperti di gambar */
            color: #ffffff;
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.2s ease;
        }

        .sidebar a:hover,
        .sidebar a.active {
            background: #394a39; /* Warna hijau abu/olive persis seperti kotak Kelola Pegawai di gambar */
            color: #ffffff;
        }

        .sidebar a i {
            font-size: 18px;
        }

        .sidebar .logout {
            background-color: #4a3228;
            color: #ffffff;
            padding: 10px 16px;
            border-radius: 12px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
            font-size: 14px;
            font-weight: 600;
            transition: background-color 0.2s ease;
        }

        .sidebar .logout:hover {
            background-color: #943530;
            color: #ffffff;
        }

        .main {
            margin-left: 250px;
            padding: 30px;
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
        }

        .welcome p {
            margin: 10px 0 0;
            color: #e5e7eb;
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
            /* Hijau Zaitun Alami (Olive) */
        }

        .transaksi {
            background: linear-gradient(135deg, #0f766e, #14b8a6);
            /* Hijau Toska Mewah */
        }

        .pegawai {
            background: linear-gradient(135deg, #1e3a8a, #2563eb);
            /* Biru Royal yang Elegan */
        }

        .pendapatan {
            background: linear-gradient(135deg, #b45309, #f59e0b);
            /* Oranye Keemasan (Kesan Uang/Pendapatan) */
            color: #fff;
        }

        .table-card {
            background: white;
            padding: 24px;
            border-radius: 18px;
            margin-top: 28px;
            box-shadow: 0 5px 18px rgba(0, 0, 0, .05);
        }

        .table-card h4 {
            font-size: 18px;
            font-weight: 600;
        }

        .table thead th {
            background: #f1f5f1;
            color: #405348;
            font-size: 12px;
            white-space: nowrap;
        }

        .table tbody td {
            font-size: 12px;
            vertical-align: middle;
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
        }
    </style>
</head>

<body>

    @include('layouts.sidebar_pemilik')

    <div class="main">

        <div class="welcome">
            <h2>
                Selamat Datang,
                {{ session('nama_pegawai', session('pegawai')) }} 👑
            </h2>

            <p>
                Login sebagai:
                <strong>{{ ucfirst(session('role')) }}</strong>
            </p>
        </div>

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
                <div class="card-stat pegawai">
                    <i class="bi bi-person-badge-fill"></i>
                    <h2>{{ $total_pegawai }}</h2>
                    <p>Total Pegawai</p>
                </div>
            </div>

            <div class="col-6 col-xl-3">
                <div class="card-stat pendapatan">
                    <i class="bi bi-cash-coin"></i>
                    <h2 style="font-size: 21px">
                        Rp {{ number_format($total_pendapatan, 0, ',', '.') }}
                    </h2>
                    <p>Total Pendapatan</p>
                </div>
            </div>

        </div>

        <div class="table-card">
            <h4 class="mb-4">
                <i class="bi bi-clock-history"></i>
                Transaksi Terbaru
            </h4>

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th>No. Nota</th>
                            <th>ID Customer</th>
                            <th>Tanggal Sewa</th>
                            <th>Total</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($data_transaksi as $transaksi)
                                            <tr>
                                                <td>{{ $transaksi->no_nota }}</td>
                                                <td>{{ $transaksi->id_customer }}</td>
                                                <td>
                                                    {{ $transaksi->tanggal_sewa
                            ? \Carbon\Carbon::parse($transaksi->tanggal_sewa)->format('d-m-Y')
                            : '-' }}
                                                </td>
                                                <td>
                                                    Rp {{ number_format($transaksi->total_transaksi, 0, ',', '.') }}
                                                </td>
                                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted py-4">
                                    Belum ada transaksi.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>

</body>

</html>