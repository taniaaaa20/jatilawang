<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Monitoring Transaksi | Jatilawang Adventure</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
    body {
        margin: 0;
        background: #f6f7f4;
        font-family: 'Poppins', sans-serif;
        color: #183226;
    }

    .main {
        margin-left: 250px;
        padding: 30px;
        min-height: 100vh;
    }

    .page-title {
        font-size: 27px;
        font-weight: 700;
        margin-bottom: 5px;
    }

    .page-subtitle {
        color: #788078;
        font-size: 14px;
    }

    .summary-card {
        border: none;
        border-radius: 22px;
        color: white;
        min-height: 160px;
        padding: 25px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, .07);
    }

    .summary-card i {
        font-size: 30px;
        margin-bottom: 15px;
        display: block;
    }

    .summary-card h2 {
        font-size: 34px;
        font-weight: 700;
        margin-bottom: 5px;
    }

    .summary-card p {
        font-size: 14px;
        margin: 0;
    }

    .card-total {
        background: linear-gradient(135deg, #315b17, #4d8010);
    }

    .card-aktif {
        background: linear-gradient(135deg, #193d94, #2864e8);
    }

    .card-terlambat {
        background: linear-gradient(135deg, #bb5b00, #f49b08);
    }

    .card-selesai {
        background: linear-gradient(135deg, #08794b, #16a36b);
    }

    .content-card {
        border: none;
        border-radius: 22px;
        box-shadow: 0 4px 18px rgba(0, 0, 0, .05);
        overflow: hidden;
    }

    .content-card .card-header {
        background: white;
        padding: 22px 25px;
        border-bottom: 1px solid #eee;
    }

    .content-card .card-body {
        padding: 25px;
    }

    .table {
        margin-bottom: 0;
    }

    .table thead th {
        background: #183226;
        color: white;
        font-size: 12px;
        font-weight: 600;
        padding: 15px 12px;
        white-space: nowrap;
        border-color: #dce2dc;
    }

    .table tbody td {
        font-size: 12px;
        padding: 15px 12px;
        vertical-align: middle;
        border-color: #e3e7e3;
    }

    .table tbody tr:hover {
        background: #f7faf6;
    }

    .badge-status {
        padding: 7px 12px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 600;
        white-space: nowrap;
    }

    .status-selesai {
        background: #dbeafe;
        color: #1d4ed8;
    }

    .status-aktif {
        background: #dcfce7;
        color: #15803d;
    }

    .status-terlambat {
        background: #fee2e2;
        color: #dc2626;
    }

    .btn-nota {
        background: #183226;
        color: white;
        border-radius: 8px;
        font-size: 11px;
        padding: 7px 12px;
        text-decoration: none;
        display: inline-block;
        white-space: nowrap;
    }

    .btn-nota:hover {
        background: #315b40;
        color: white;
    }

    .btn-disabled {
        background: #e5e7eb;
        color: #6b7280;
        border-radius: 8px;
        font-size: 11px;
        padding: 7px 12px;
        border: none;
        cursor: not-allowed;
    }

    .btn-print {
        background: #183226;
        color: white;
        border: none;
        padding: 12px 20px;
        border-radius: 12px;
        font-size: 13px;
        font-weight: 600;
    }

    .btn-print:hover {
        background: #315b40;
        color: white;
    }

    .customer-name {
        font-weight: 600;
        color: #183226;
    }

    .text-muted-small {
        font-size: 10px;
        color: #888;
    }

    @media (max-width: 768px) {
        .main {
            margin-left: 0;
            padding: 18px;
        }

        .page-title {
            font-size: 22px;
        }
    }

    @media print {

        .sidebar,
        .no-print {
            display: none !important;
        }

        .main {
            margin: 0;
            padding: 10px;
        }

        body {
            background: white;
        }

        .content-card,
        .summary-card {
            box-shadow: none;
        }

        .summary-card {
            color: black !important;
            background: white !important;
            border: 1px solid #ccc;
        }

        .summary-card h2,
        .summary-card p,
        .summary-card i {
            color: black !important;
        }

        .table thead th {
            background: #ddd !important;
            color: black !important;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }
    }
    </style>
</head>

<body>

    {{-- Sidebar Pemilik --}}
    @include('layouts.sidebar_pemilik')

    <div class="main">

        {{-- Judul Halaman --}}
        <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">

            <div>
                <h2 class="page-title">
                    <i class="bi bi-clipboard-data"></i>
                    Monitoring Transaksi
                </h2>

                <p class="page-subtitle mb-0">
                    Pemantauan seluruh transaksi penyewaan barang Jatilawang Adventure.
                </p>
            </div>

            <button onclick="window.print()" class="btn-print no-print">
                <i class="bi bi-printer-fill"></i>
                Cetak Laporan
            </button>

        </div>

        {{-- Pesan --}}
        @if(session('success'))
        <div class="alert alert-success no-print">
            {{ session('success') }}
        </div>
        @endif

        @if(session('error'))
        <div class="alert alert-danger no-print">
            {{ session('error') }}
        </div>
        @endif

        {{-- Ringkasan Transaksi --}}
        <div class="row g-4 mb-4">

            <div class="col-xl-3 col-md-6">
                <div class="summary-card card-total">
                    <i class="bi bi-receipt"></i>
                    <h2>{{ $total_transaksi }}</h2>
                    <p>Total Transaksi</p>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="summary-card card-aktif">
                    <i class="bi bi-arrow-repeat"></i>
                    <h2>{{ $transaksi_aktif }}</h2>
                    <p>Transaksi Aktif</p>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="summary-card card-terlambat">
                    <i class="bi bi-exclamation-triangle-fill"></i>
                    <h2>{{ $transaksi_terlambat }}</h2>
                    <p>Transaksi Terlambat</p>
                </div>
            </div>

            <div class="col-xl-3 col-md-6">
                <div class="summary-card card-selesai">
                    <i class="bi bi-check-circle-fill"></i>
                    <h2>{{ $transaksi_selesai }}</h2>
                    <p>Transaksi Selesai</p>
                </div>
            </div>

        </div>

        {{-- Tabel Data Transaksi --}}
        <div class="card content-card">

            <div class="card-header">

                <h5 class="mb-0 fw-bold">
                    <i class="bi bi-list-ul"></i>
                    Daftar Transaksi Rental
                </h5>

                <small class="text-muted">
                    Seluruh riwayat penyewaan yang tercatat dalam sistem.
                </small>

            </div>

            <div class="card-body">

                <div class="table-responsive">

                    <table class="table table-bordered table-hover align-middle">

                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Kode Transaksi</th>
                                <th>Pelanggan</th>
                                <th>Pegawai</th>
                                <th>Barang</th>
                                <th>Tanggal Sewa</th>
                                <th>Lama</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th class="no-print">Nota</th>
                            </tr>
                        </thead>

                        <tbody>

                            @forelse($data_transaksi as $index => $row)

                            <tr>

                                <td>{{ $index + 1 }}</td>

                                <td>
                                    <strong>{{ $row->no_nota }}</strong>
                                </td>

                                <td>
                                    <span class="customer-name">
                                        {{ $row->nama_customer }}
                                    </span>

                                    <br>

                                    <small class="text-muted-small">
                                        {{ $row->noHP_customer }}
                                    </small>
                                </td>

                                <td>
                                    {{ $row->nama_pegawai ?? '-' }}
                                </td>

                                <td style="min-width: 180px;">
                                    {{ $row->daftar_barang ?: '-' }}
                                </td>

                                <td style="white-space: nowrap;">
                                    {{ date('d-m-Y', strtotime($row->tanggal_sewa)) }}
                                </td>

                                <td>
                                    {{ $row->lama_sewa }} Hari
                                </td>

                                <td style="white-space: nowrap;">
                                    <strong>
                                        Rp {{ number_format($row->total_transaksi, 0, ',', '.') }}
                                    </strong>
                                </td>

                                <td>

                                    @if($row->status_tampilan === 'Dikembalikan')

                                    <span class="badge-status status-selesai">
                                        Selesai
                                    </span>

                                    @elseif($row->status_tampilan === 'Terlambat')

                                    <span class="badge-status status-terlambat">
                                        Terlambat
                                    </span>

                                    @else

                                    <span class="badge-status status-aktif">
                                        Dipinjam
                                    </span>

                                    @endif

                                </td>

                                <td class="no-print">

                                    @if($row->tanggal_dikembalikan)

                                    <a href="{{ route('transaksi.nota', $row->no_nota) }}" class="btn-nota"
                                        target="_blank">

                                        <i class="bi bi-receipt"></i>
                                        Nota

                                    </a>

                                    @else

                                    <button class="btn-disabled" disabled>
                                        Belum tersedia
                                    </button>

                                    @endif

                                </td>

                            </tr>

                            @empty

                            <tr>
                                <td colspan="10" class="text-center py-5">

                                    <i class="bi bi-inbox fs-1 text-muted"></i>

                                    <p class="text-muted mt-2 mb-0">
                                        Belum ada transaksi rental.
                                    </p>

                                </td>
                            </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

                {{-- Keterangan --}}
                <div class="mt-3 text-muted no-print">

                    <small>
                        <i class="bi bi-info-circle"></i>
                        Halaman ini digunakan untuk memantau seluruh transaksi penyewaan
                        yang dilakukan oleh pegawai.
                    </small>

                </div>

            </div>

        </div>

    </div>

</body>

</html>