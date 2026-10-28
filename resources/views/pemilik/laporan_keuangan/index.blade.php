<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Keuangan | Jatilawang Adventure</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <style>
        :root {
            --green: #2f3e2c;
            --green2: #4f6b4a;
            --yellow: #facc15;
            --bg: #f4f6f9;
            --text: #1f2937;
            --muted: #64748b;
            --line: #e5e7eb;
        }

        * {
            font-family: 'Poppins', sans-serif;
            box-sizing: border-box;
        }

        body {
            background: var(--bg);
            color: var(--text);
            margin: 0;
        }

        a {
            text-decoration: none;
        }

        /* AREA UTAMA */
        .main {
            margin-left: 260px;
            min-height: 100vh;
            padding: 32px;
        }

        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 18px;
            margin-bottom: 24px;
        }

        .page-title {
            font-weight: 700;
            color: var(--green);
            margin: 0;
            font-size: 28px;
        }

        .page-subtitle {
            color: var(--muted);
            margin: 6px 0 0;
            font-size: 14px;
        }

        /* CARD */
        .card,
        .soft-card {
            border: none;
            border-radius: 22px;
            background: #fff;
            box-shadow: 0 10px 28px rgba(15, 23, 42, .08);
        }

        .card-header {
            background: #fff;
            border-radius: 22px 22px 0 0 !important;
            border-bottom: 1px solid var(--line);
            padding: 18px 22px;
        }

        .card-header h5 {
            color: var(--green);
            font-weight: 700;
            font-size: 17px;
        }

        .card-body {
            padding: 22px;
        }

        /* FILTER TANGGAL */
        .form-label,
        label {
            font-weight: 600;
            color: #334155;
            margin-bottom: 7px;
            font-size: 14px;
        }

        .form-control {
            border-radius: 14px;
            border: 1px solid #dbe1e8;
            min-height: 46px;
            font-size: 14px;
        }

        .form-control:focus {
            border-color: var(--green2);
            box-shadow: 0 0 0 3px rgba(79, 107, 74, .12);
        }

        .btn {
            border-radius: 12px;
            font-weight: 600;
            padding: 10px 16px;
            font-size: 14px;
        }

        .btn-success {
            background: var(--green) !important;
            border-color: var(--green) !important;
            color: #fff !important;
        }

        .btn-success:hover {
            background: var(--green2) !important;
            border-color: var(--green2) !important;
        }

        .btn-secondary {
            background: #e9edf0;
            color: #334155;
            border-color: #e9edf0;
        }

        .btn-secondary:hover {
            background: #dce2e7;
            color: #1f2937;
            border-color: #dce2e7;
        }

        /* KARTU RINGKASAN */
        .stat-card {
            border-radius: 22px;
            color: #fff;
            padding: 24px;
            box-shadow: 0 10px 24px rgba(15, 23, 42, .12);
            height: 100%;
            min-height: 160px;
        }

        .stat-icon {
            font-size: 30px;
            margin-bottom: 12px;
        }

        .stat-card h3 {
            font-weight: 700;
            font-size: 25px;
            margin: 8px 0 4px;
            overflow-wrap: anywhere;
        }

        .stat-card p {
            margin: 0;
            opacity: .92;
            font-size: 14px;
        }

        .stat-green {
            background: linear-gradient(135deg, #0f766e, #14b8a6);

        }

        .stat-blue {
            background: linear-gradient(135deg, #1e3a8a, #2563eb);
        }

        .stat-yellow {
            background: linear-gradient(135deg, #b45309, #f59e0b);
            color: #fff;
        }

        /* TABEL */
        .table-card {
            overflow: hidden;
        }

        .table {
            margin-bottom: 0;
            font-size: 13px;
        }

        .table th {
            background: var(--green) !important;
            color: white !important;
            white-space: nowrap;
            vertical-align: middle;
            padding: 14px 12px;
            font-weight: 600;
        }

        .table td {
            vertical-align: middle;
            padding: 13px 12px;
        }

        .table-responsive {
            border-radius: 16px;
            border: 1px solid var(--line);
            overflow-x: auto;
        }

        .table-hover tbody tr:hover td {
            background: #f8faf8;
        }

        .empty-state {
            text-align: center;
            color: #64748b;
            padding: 32px;
        }

        .section-spacing {
            margin-top: 24px;
        }

        /* RESPONSIVE */
        @media (max-width: 900px) {
            .main {
                margin-left: 0;
                padding: 22px;
            }

            .page-header {
                flex-direction: column;
            }
        }

        @media (max-width: 576px) {
            .main {
                padding: 16px;
            }

            .page-title {
                font-size: 23px;
            }

            .stat-card {
                padding: 20px;
            }

            .stat-card h3 {
                font-size: 22px;
            }

            .card-body {
                padding: 16px;
            }
        }
    </style>
</head>

<body>

    {{-- SIDEBAR --}}
    @include('layouts.sidebar_pemilik')

    <main class="main">

        {{-- HEADER --}}
        <div class="page-header">
            <div>
                <h2 class="page-title">
                    <i class="bi bi-cash-stack"></i>
                    Laporan Keuangan
                </h2>

                <p class="page-subtitle">
                    Rekap transaksi dan pendapatan rental
                </p>
            </div>
        </div>

        {{-- FILTER TANGGAL --}}
        <div class="card mb-4">
            <div class="card-body">
                <form method="GET" action="{{ route('pemilik.laporan-keuangan.index') }}">
                    <div class="row g-3 align-items-end">

                        <div class="col-md-4">
                            <label for="tanggal_awal" class="form-label">
                                Tanggal Awal
                            </label>

                            <input type="date" name="tanggal_awal" id="tanggal_awal" class="form-control"
                                value="{{ $tanggalAwal }}">
                        </div>

                        <div class="col-md-4">
                            <label for="tanggal_akhir" class="form-label">
                                Tanggal Akhir
                            </label>

                            <input type="date" name="tanggal_akhir" id="tanggal_akhir" class="form-control"
                                value="{{ $tanggalAkhir }}">
                        </div>

                        <div class="col-md-4 d-flex gap-2">
                            <button type="submit" class="btn btn-success">
                                <i class="bi bi-funnel-fill"></i>
                                Filter
                            </button>

                            <a href="{{ route('pemilik.laporan-keuangan.index') }}" class="btn btn-secondary">
                                Reset
                            </a>
                        </div>

                    </div>
                </form>
            </div>
        </div>

        {{-- RINGKASAN KEUANGAN --}}
        <div class="row g-4">

            <div class="col-md-4">
                <div class="stat-card stat-green">
                    <div class="stat-icon">
                        <i class="bi bi-receipt-cutoff"></i>
                    </div>

                    <h3>
                        {{ number_format($ringkasan->total_transaksi ?? 0, 0, ',', '.') }}
                    </h3>

                    <p>Total Transaksi</p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="stat-card stat-blue">
                    <div class="stat-icon">
                        <i class="bi bi-cash-coin"></i>
                    </div>

                    <h3>
                        Rp {{ number_format($ringkasan->total_pendapatan ?? 0, 0, ',', '.') }}
                    </h3>

                    <p>Total Pendapatan</p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="stat-card stat-yellow">
                    <div class="stat-icon">
                        <i class="bi bi-exclamation-triangle-fill"></i>
                    </div>

                    <h3>
                        Rp {{ number_format($ringkasan->total_denda ?? 0, 0, ',', '.') }}
                    </h3>

                    <p>Total Denda</p>
                </div>
            </div>

        </div>

        {{-- BARANG TERLARIS --}}
        <div class="card section-spacing">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="bi bi-trophy"></i>
                    5 Barang Paling Banyak Disewa
                </h5>
            </div>

            <div class="card-body">
                @if($barangTerlaris->isNotEmpty())

                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th style="width: 70px;">No.</th>
                                    <th>Nama Barang</th>
                                    <th class="text-center">Total Disewa</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach($barangTerlaris as $index => $barang)
                                    <tr>
                                        <td class="text-center">
                                            {{ $index + 1 }}
                                        </td>

                                        <td>{{ $barang->nama_barang }}</td>

                                        <td class="text-center">
                                            {{ number_format($barang->total_disewa ?? 0, 0, ',', '.') }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                @else
                    <div class="empty-state">
                        <i class="bi bi-box-seam fs-1"></i>
                        <p class="mt-2 mb-0">
                            Belum ada barang yang disewa pada tanggal tersebut.
                        </p>
                    </div>
                @endif
            </div>
        </div>

        {{-- DATA TRANSAKSI --}}
        <div class="card section-spacing table-card">
            <div class="card-header">
                <h5 class="mb-1">
                    <i class="bi bi-receipt"></i>
                    Data Transaksi
                </h5>

                <small class="text-secondary">
                    Daftar transaksi sesuai tanggal yang dipilih
                </small>
            </div>

            <div class="card-body">
                @if($dataTransaksi->isNotEmpty())

                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>No. Nota</th>
                                    <th>Pelanggan</th>
                                    <th>Tanggal Sewa</th>
                                    <th>Tanggal Kembali</th>
                                    <th>Total Bayar</th>
                                    <th>Total Denda</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach($dataTransaksi as $index => $transaksi)
                                                    <tr>
                                                        <td class="text-center">
                                                            {{ $index + 1 }}
                                                        </td>

                                                        <td>{{ $transaksi->no_nota }}</td>

                                                        <td>
                                                            {{ $transaksi->nama_customer ?? 'Pelanggan tidak ditemukan' }}
                                                        </td>

                                                        <td>
                                                            {{ $transaksi->tanggal_sewa
                                    ? \Carbon\Carbon::parse($transaksi->tanggal_sewa)->format('d/m/Y')
                                    : '-' }}
                                                        </td>

                                                        <td>
                                                            {{ $transaksi->tanggal_kembali
                                    ? \Carbon\Carbon::parse($transaksi->tanggal_kembali)->format('d/m/Y')
                                    : '-' }}
                                                        </td>

                                                        <td class="text-nowrap">
                                                            Rp {{ number_format($transaksi->total_transaksi ?? 0, 0, ',', '.') }}
                                                        </td>

                                                        <td class="text-nowrap">
                                                            Rp {{ number_format($transaksi->denda ?? 0, 0, ',', '.') }}
                                                        </td>
                                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                @else
                    <div class="empty-state">
                        <i class="bi bi-inbox fs-1"></i>
                        <p class="mt-2 mb-0">
                            Tidak ada transaksi pada tanggal yang dipilih.
                        </p>
                    </div>
                @endif
            </div>
        </div>

        <p class="text-center text-secondary mt-4 mb-0" style="font-size: 12px;">
            Jatilawang Adventure &copy; {{ date('Y') }} — Laporan Keuangan
        </p>

    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>