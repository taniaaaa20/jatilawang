
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaksi Rental | Jatilawang Adventure</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            margin: 0;
            background: #f6f7f4;
            font-family: 'Poppins', sans-serif;
            color: #303b2d;
        }

        .main {
            margin-left: 260px;
            padding: 32px;
            min-height: 100vh;
        }

        .page-title {
            font-size: 26px;
            font-weight: 700;
            margin-bottom: 6px;
        }

        .page-subtitle {
            color: #777;
            font-size: 14px;
        }

        .card {
            border: none;
            border-radius: 14px;
            box-shadow: 0 3px 15px rgba(0, 0, 0, .05);
            margin-bottom: 24px;
        }

        .card-header {
            padding: 18px 22px;
            border-bottom: 1px solid #eee;
            border-radius: 14px 14px 0 0 !important;
        }

        .card-body {
            padding: 22px;
        }

        .form-label {
            font-size: 13px;
            font-weight: 600;
        }

        .form-control, .form-select {
            min-height: 42px;
            font-size: 13px;
        }

        .btn-success {
            background: #2f5738;
            border-color: #2f5738;
        }

        .btn-success:hover {
            background: #24452c;
            border-color: #24452c;
        }

        .item-row {
            padding: 14px 0;
            border-bottom: 1px solid #eee;
        }

        .item-number {
            display: inline-flex;
            width: 30px;
            height: 30px;
            align-items: center;
            justify-content: center;
            background: #e8eee5;
            border-radius: 50%;
            font-weight: 600;
            margin-top: 32px;
        }

        .table th {
            font-size: 12px;
            white-space: nowrap;
            background: #f8f9f7;
        }

        .table td {
            font-size: 12px;
            vertical-align: middle;
        }

        .action-group {
            display: flex;
            gap: 6px;
            flex-wrap: wrap;
        }

        .select2-container {
            width: 100% !important;
        }

        .select2-container .select2-selection--single {
            height: 42px;
            border: 1px solid #dee2e6;
            border-radius: 6px;
            padding: 6px;
        }

        @media (max-width: 768px) {
            .main {
                margin-left: 0;
                padding: 18px;
            }
        }
    </style>
</head>
<body>

@include('layouts.sidebar')

<div class="main">
    <div class="mb-4">
        <h2 class="page-title">
            <i class="bi bi-cart-check-fill"></i> Transaksi Rental
        </h2>
        <p class="page-subtitle">
            Satu transaksi dapat berisi beberapa barang sewa sekaligus.
        </p>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card">
        <div class="card-header bg-white">
            <h5 class="mb-0">
                <i class="bi bi-cart-plus-fill text-success"></i>
                Form Transaksi Baru
            </h5>
        </div>

        <div class="card-body">
            <form action="{{ route('transaksi.store') }}" method="POST">
                @csrf

                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Nama Penyewa</label>
                        <select name="id_customer" class="form-select" required>
                            <option value="">-- Pilih Pelanggan --</option>
                            @foreach ($data_customer as $customer)
                                <option value="{{ $customer->id_customer }}"
                                    @selected(old('id_customer') == $customer->id_customer)>
                                    {{ $customer->nama_customer }} |
                                    {{ $customer->noHP_customer }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Tanggal Sewa</label>
                        <input type="date" name="tanggal_sewa"
                               class="form-control"
                               value="{{ old('tanggal_sewa', date('Y-m-d')) }}"
                               required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Lama Sewa</label>
                        <div class="input-group">
                            <input type="number" name="lama_sewa"
                                   class="form-control"
                                   min="1" value="{{ old('lama_sewa', 1) }}"
                                   required>
                            <span class="input-group-text">hari</span>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Tujuan Penyewaan</label>
                        <input type="text" name="tujuan"
                               class="form-control" maxlength="50"
                               placeholder="Contoh: Gunung Lawu"
                               value="{{ old('tujuan') }}" required>
                    </div>
                </div>

                <div class="d-flex justify-content-between align-items-center mt-4 mb-2">
                    <label class="form-label mb-0">Daftar Barang</label>
                    <button type="button" id="add-item" class="btn btn-outline-success btn-sm">
                        <i class="bi bi-plus-circle"></i> Tambah Barang
                    </button>
                </div>

                <div id="item-container">
                    <div class="row item-row g-3">
                        <div class="col-md-1 col-2 text-center">
                            <span class="item-number">1</span>
                        </div>

                        <div class="col-md-8 col-10">
                            <label class="form-label">Barang</label>
                            <select name="id_barang[]" class="form-select barang-select" required>
                                <option value="">-- Pilih Barang --</option>
                                @foreach ($data_barang as $barang)
                                    <option value="{{ $barang->id_barang }}"
                                        data-stok="{{ $barang->stok }}"
                                        @selected(old('id_barang.0') == $barang->id_barang)>
                                        {{ $barang->nama_barang }}
                                        | Stok: {{ $barang->stok }}
                                        | Rp {{ number_format($barang->harga, 0, ',', '.') }}/hari
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-2 col-8">
                            <label class="form-label">Jumlah</label>
                            <input type="number" name="jumlah[]" class="form-control"
                                   placeholder="Qty" min="1"
                                   value="{{ old('jumlah.0') }}" required>
                        </div>

                        <div class="col-md-1 col-4">
                            <label class="form-label d-none d-md-block">&nbsp;</label>
                            <button type="button"
                                    class="btn btn-outline-danger remove-item w-100"
                                    title="Hapus barang">
                                <i class="bi bi-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="d-flex flex-wrap gap-2 mt-4">
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-save"></i> Simpan Transaksi
                    </button>
                    <button type="reset" class="btn btn-secondary">
                        <i class="bi bi-arrow-counterclockwise"></i> Reset
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-header bg-white">
            <h5 class="mb-0">
                <i class="bi bi-clock-history text-success"></i>
                Data Transaksi
            </h5>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th>No. Nota</th>
                            <th>Pelanggan</th>
                            <th>Barang</th>
                            <th>Tanggal Sewa</th>
                            <th>Tanggal Kembali</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($data_transaksi as $row)
                            <tr>
                                <td><strong>{{ $row->no_nota }}</strong></td>

                                <td>
                                    {{ $row->nama_customer }}
                                    <br>
                                    <small class="text-muted">
                                        {{ $row->noHP_customer }}
                                    </small>
                                </td>

                                <td>{{ $row->daftar_barang ?: '-' }}</td>
                                <td>{{ $row->tanggal_sewa }}</td>
                                <td>{{ $row->tanggal_kembali }}</td>

                                <td>
                                    <strong>
                                        Rp {{ number_format($row->total_transaksi, 0, ',', '.') }}
                                    </strong>
                                </td>

                                <td>
                                    @if ($row->status_tampilan === 'Dikembalikan')
                                        <span class="badge bg-primary">Dikembalikan</span>
                                    @elseif ($row->status_tampilan === 'Terlambat')
                                        <span class="badge bg-danger">Terlambat</span>
                                    @else
                                        <span class="badge bg-success">Dipinjam</span>
                                    @endif
                                </td>

                                <td>
                                    <div class="action-group">
                                        @if ($row->tanggal_dikembalikan)
                                            <a href="{{ route('transaksi.nota', $row->no_nota) }}"
                                               class="btn btn-success btn-sm">
                                                <i class="bi bi-receipt"></i> Nota
                                            </a>
                                        @else
                                            <form action="{{ route('transaksi.kembalikan', $row->no_nota) }}"
                                                  method="POST"
                                                  onsubmit="return confirm('Catat pengembalian semua barang pada transaksi ini?')">
                                                @csrf
                                                <button type="submit" class="btn btn-warning btn-sm">
                                                    <i class="bi bi-arrow-return-left"></i>
                                                    Kembalikan
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted py-4">
                                    Belum ada transaksi.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    function initSelect2(scope) {
        $(scope).find('.barang-select').select2({
            width: '100%',
            placeholder: '-- Pilih Barang --'
        });
    }

    function updateNumber() {
        $('.item-row').each(function (index) {
            $(this).find('.item-number').text(index + 1);
        });
    }

    $(document).ready(function () {
        initSelect2(document);

        $('#add-item').on('click', function () {
            let newItem = $('.item-row:first').clone();

            newItem.find('.select2-container').remove();
            newItem.find('input').val('');
            newItem.find('select')
                .removeClass('select2-hidden-accessible')
                .removeAttr('data-select2-id tabindex aria-hidden')
                .val('');

            newItem.find('option').removeAttr('data-select2-id');

            $('#item-container').append(newItem);
            initSelect2(newItem);
            updateNumber();
        });

        $(document).on('click', '.remove-item', function () {
            if ($('.item-row').length > 1) {
                $(this).closest('.item-row').remove();
                updateNumber();
            }
        });
    });
</script>
</body>
</html>
