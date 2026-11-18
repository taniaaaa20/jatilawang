<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Laporan Stok | Jatilawang Adventure</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        * {
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            margin: 0;
            background: #f4f6f3;
            color: #26332b;
        }

        /* KONTEN UTAMA */
        .main {
            margin-left: 250px;
            min-height: 100vh;
            padding: 30px;
            width: calc(100% - 250px);
        }

        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 28px;
            gap: 15px;
        }

        .page-title {
            font-size: 25px;
            font-weight: 700;
            color: #183226;
            margin-bottom: 6px;
        }

        .page-subtitle {
            color: #6c757d;
            font-size: 14px;
            margin-bottom: 0;
        }

        /* KARTU STATISTIK */
        .stat-card {
            padding: 24px;
            border-radius: 18px;
            color: white;
            min-height: 150px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, .08);
        }

        .stat-card i {
            font-size: 28px;
            margin-bottom: 12px;
            display: block;
        }

        .stat-card h3 {
            font-size: 30px;
            font-weight: 700;
            margin-bottom: 5px;
        }

        .stat-card p {
            font-size: 13px;
            margin-bottom: 0;
        }

        .stat-green {
            background: linear-gradient(135deg, #365314, #4d7c0f);
        }

        .stat-blue {
            background: linear-gradient(135deg, #1e3a8a, #2563eb);
        }

        .stat-yellow {
            background: linear-gradient(135deg, #b45309, #f59e0b);
        }

        /* TABEL */
        .table-card {
            border: none;
            border-radius: 18px;
            overflow: hidden;
            background: white;
            box-shadow: 0 5px 20px rgba(0, 0, 0, .06);
        }

        .table-card .card-header {
            background: white;
            padding: 22px 24px;
            border-bottom: 1px solid #eee;
        }

        .table-card .card-header h5 {
            color: #183226;
            font-size: 17px;
            font-weight: 600;
            margin: 0;
        }

        .table-card .card-body {
            padding: 24px;
        }

        .table {
            font-size: 13px;
            margin-bottom: 0;
        }

        .table thead th {
            background: #183226;
            color: white;
            font-weight: 500;
            padding: 14px;
            white-space: nowrap;
        }

        .table tbody td {
            padding: 13px 14px;
            vertical-align: middle;
        }

        .badge {
            padding: 7px 12px;
            font-size: 11px;
            font-weight: 500;
            border-radius: 20px;
        }

        /* TOMBOL CETAK */
        .btn-cetak {
            background: #183226;
            color: white;
            border: none;
            border-radius: 9px;
            padding: 10px 17px;
            font-size: 13px;
        }

        .btn-cetak:hover {
            background: #294b37;
            color: white;
        }

        /* RESPONSIF */
        @media (max-width: 768px) {
            .main {
                margin-left: 0;
                width: 100%;
                padding: 20px 15px;
            }

            .page-header {
                align-items: flex-start;
                flex-direction: column;
            }

            .page-title {
                font-size: 21px;
            }
        }

        /* CETAK LAPORAN */
        @media print {
            @page {
                size: landscape;
                margin: 15mm;
            }

            body {
                background: white;
            }

            .sidebar,
            .no-print {
                display: none !important;
            }

            .main {
                margin: 0;
                padding: 0;
                width: 100%;
            }

            .stat-card {
                box-shadow: none;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }

            .table-card {
                box-shadow: none;
            }

            .table thead th {
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
        }
    </style>
</head>

<body>

    @include('layouts.sidebar_pemilik')

    <main class="main">

        {{-- HEADER --}}
        <div class="page-header">

            <div>
                <h2 class="page-title">
                    <i class="bi bi-boxes"></i>
                    Laporan Stok Barang
                </h2>

                <p class="page-subtitle">
                    Monitoring stok perlengkapan rental Jatilawang Adventure.
                </p>
            </div>

            <div class="no-print">
                <button type="button" onclick="window.print()" class="btn btn-cetak">
                    <i class="bi bi-printer me-1"></i>
                    Cetak Laporan
                </button>
            </div>

        </div>

        {{-- STATISTIK --}}
        <div class="row g-4">

            <div class="col-md-4">
                <div class="stat-card stat-green">
                    <i class="bi bi-box-seam-fill"></i>

                    <h3>{{ $total_barang }}</h3>

                    <p>Total Jenis Barang</p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="stat-card stat-blue">
                    <i class="bi bi-stack"></i>

                    <h3>{{ $total_stok }}</h3>

                    <p>Total Stok Barang</p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="stat-card stat-yellow">
                    <i class="bi bi-exclamation-triangle-fill"></i>

                    <h3>{{ $stok_rendah }}</h3>

                    <p>Stok Rendah</p>
                </div>
            </div>

        </div>

        {{-- TABEL STOK --}}
        <div class="card table-card mt-4">

            <div class="card-header">
                <h5>
                    <i class="bi bi-list-ul me-2"></i>
                    Data Stok Barang
                </h5>
            </div>

            <div class="card-body">

                <div class="table-responsive">

                    <table class="table table-bordered table-hover align-middle">

                        <thead>
                            <tr>
                                <th>No</th>
                                <th>ID Barang</th>
                                <th>Nama Barang</th>
                                <th>Merk</th>
                                <th>Kategori</th>
                                <th>Harga Sewa</th>
                                <th>Stok</th>
                                <th>Status</th>
                            </tr>
                        </thead>

                        <tbody>

                            @forelse ($data_barang as $index => $barang)

                                <tr>
                                    <td>{{ $index + 1 }}</td>

                                    <td>{{ $barang->id_barang }}</td>

                                    <td>{{ $barang->nama_barang }}</td>

                                    <td>{{ $barang->merk }}</td>

                                    <td>{{ $barang->kategori }}</td>

                                    <td>
                                        Rp {{ number_format($barang->harga, 0, ',', '.') }}
                                    </td>

                                    <td>{{ $barang->stok }}</td>

                                    <td>
                                        @if ($barang->stok <= 3)
                                            <span class="badge bg-danger">
                                                Stok Rendah
                                            </span>
                                        @else
                                            <span class="badge bg-success">
                                                Aman
                                            </span>
                                        @endif
                                    </td>
                                </tr>

                            @empty

                                <tr>
                                    <td colspan="8" class="text-center text-muted py-4">
                                        Belum ada data barang.
                                    </td>
                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
