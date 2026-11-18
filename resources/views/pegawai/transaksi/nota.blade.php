<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nota Rental | Jatilawang Adventure</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f6f7f4;
            padding: 30px;
        }
        .nota {
            max-width: 750px;
            margin: auto;
            background: white;
            padding: 35px;
            border-radius: 12px;
        }
        @media print {
            body { background: white; padding: 0; }
            .nota { max-width: none; box-shadow: none; }
            .no-print { display: none !important; }
        }
    </style>
</head>
<body>
<div class="nota">
    <div class="text-center mb-4">
        <h3>Jatilawang Adventure</h3>
        <p>Nota Transaksi Rental</p>
        <hr>
    </div>

    <table class="table table-borderless">
        <tr>
            <td width="190">Nomor Nota</td>
            <td>: {{ $transaksi->no_nota }}</td>
        </tr>
        <tr>
            <td>Nama Penyewa</td>
            <td>: {{ $transaksi->nama_customer }}</td>
        </tr>
        <tr>
            <td>No. HP</td>
            <td>: {{ $transaksi->noHP_customer }}</td>
        </tr>
        <tr>
            <td>Tujuan</td>
            <td>: {{ $transaksi->tujuan }}</td>
        </tr>
        <tr>
            <td>Tanggal Sewa</td>
            <td>: {{ $transaksi->tanggal_sewa }}</td>
        </tr>
        <tr>
            <td>Batas Kembali</td>
            <td>: {{ $transaksi->tanggal_kembali }}</td>
        </tr>
        <tr>
            <td>Tanggal Dikembalikan</td>
            <td>: {{ $transaksi->tanggal_dikembalikan }}</td>
        </tr>
    </table>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nama Barang</th>
                <th>Jumlah</th>
                <th>Harga/Hari</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($detail as $item)
                <tr>
                    <td>{{ $item->nama_barang }}</td>
                    <td>{{ $item->jumlah_barang }}</td>
                    <td>Rp {{ number_format($item->harga, 0, ',', '.') }}</td>
                    <td>
                        Rp {{ number_format(
                            $item->harga * $item->jumlah_barang *
                            max(1, (int) \Carbon\Carbon::parse($transaksi->tanggal_sewa)
                                ->diffInDays(\Carbon\Carbon::parse($transaksi->tanggal_kembali)),
                            0),
                            0, ',', '.'
                        ) }}
                    </td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th colspan="3" class="text-end">Total Transaksi</th>
                <th>Rp {{ number_format($transaksi->total_transaksi, 0, ',', '.') }}</th>
            </tr>
            <tr>
                <th colspan="3" class="text-end">Denda</th>
                <th>Rp {{ number_format($transaksi->denda, 0, ',', '.') }}</th>
            </tr>
        </tfoot>
    </table>

    <p class="mt-4 text-center">Terima kasih telah menggunakan Jatilawang Adventure.</p>

    <div class="d-flex justify-content-between mt-4 no-print">
        <a href="{{ route('transaksi.index') }}" class="btn btn-secondary">Kembali</a>
        <button onclick="window.print()" class="btn btn-success">Cetak Nota</button>
    </div>
</div>
</body>
</html>
