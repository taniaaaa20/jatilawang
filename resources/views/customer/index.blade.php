<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Pelanggan | Jatilawang Adventure</title>

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

    .main {
        margin-left: 260px;
        padding: 35px;
        min-height: 100vh;
    }

    .header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 15px;
        margin-bottom: 25px;
        flex-wrap: wrap;
    }

    .header h2 {
        color: #2f3e2c;
        font-size: 26px;
        font-weight: 700;
        margin: 0;
    }

    .header p {
        color: #64748b;
        font-size: 13px;
        margin: 7px 0 0;
    }

    .card-data {
        background: white;
        border-radius: 16px;
        padding: 25px;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
    }

    .btn-tambah {
        background: #2f3e2c;
        color: white;
        border: none;
        border-radius: 9px;
        padding: 11px 16px;
        font-family: inherit;
        font-size: 13px;
        text-decoration: none;
    }

    .btn-tambah:hover {
        background: #394a39;
        color: white;
    }

    .table {
        font-size: 13px;
        vertical-align: middle;
    }

    .table thead th {
        background: #2f3e2c;
        color: white;
        padding: 14px;
        white-space: nowrap;
    }

    .table tbody td {
        padding: 14px;
    }

    .btn-edit,
    .btn-hapus {
        border: none;
        border-radius: 7px;
        padding: 7px 10px;
        font-size: 12px;
        text-decoration: none;
        display: inline-block;
        cursor: pointer;
    }

    .btn-edit {
        background: #eab308;
        color: #222;
    }

    .btn-hapus {
        background: #dc2626;
        color: white;
    }

    .btn-edit:hover {
        background: #ca8a04;
        color: white;
    }

    .btn-hapus:hover {
        background: #b91c1c;
    }

    .form-control {
        font-size: 13px;
    }

    @media (max-width: 768px) {
        .main {
            margin-left: 0;
            padding: 18px;
        }

        .card-data {
            padding: 15px;
        }

        .header h2 {
            font-size: 22px;
        }
    }
    </style>
</head>

<body>

    @include('layouts.sidebar')

    <main class="main">

        <div class="header">
            <div>
                <h2>Data Pelanggan</h2>
                <p>Kelola data pelanggan Jatilawang Adventure</p>
            </div>

            <button type="button" class="btn-tambah" data-bs-toggle="modal" data-bs-target="#modalTambah">
                <i class="bi bi-person-plus-fill me-1"></i>
                Tambah Pelanggan
            </button>
        </div>

        @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Data belum berhasil disimpan.</strong>
            <ul class="mb-0 mt-2">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <section class="card-data">

            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
                <h5 class="fw-bold mb-0" style="color:#2f3e2c">
                    <i class="bi bi-people-fill me-2"></i>Daftar Pelanggan
                </h5>

                <span class="badge text-bg-secondary">
                    Total: {{ $data_customer->count() }} pelanggan
                </span>
            </div>

            <div class="table-responsive">
                <table class="table table-hover table-bordered mb-0">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>ID Pelanggan</th>
                            <th>Nama Pelanggan</th>
                            <th>Nomor HP</th>
                            <th style="width: 150px">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($data_customer as $customer)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $customer->id_customer }}</td>
                            <td>{{ $customer->nama_customer }}</td>
                            <td>{{ $customer->noHP_customer }}</td>
                            <td>
                                <button type="button" class="btn-edit" data-bs-toggle="modal"
                                    data-bs-target="#modalEdit{{ $loop->index }}">
                                    <i class="bi bi-pencil-fill"></i> Edit
                                </button>

                                <form action="{{ route('customer.destroy', $customer->id_customer) }}" method="POST"
                                    class="d-inline" onsubmit="return confirm('Yakin ingin menghapus pelanggan ini?')">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" class="btn-hapus">
                                        <i class="bi bi-trash-fill"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">
                                Belum ada data pelanggan.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </section>

        {{-- MODAL TAMBAH PELANGGAN --}}
        <div class="modal fade" id="modalTambah" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <form action="{{ route('customer.store') }}" method="POST">
                        @csrf

                        <div class="modal-header">
                            <h5 class="modal-title fw-bold">Tambah Pelanggan</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>

                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label">Nama Pelanggan</label>
                                <input type="text" name="nama_customer" class="form-control" maxlength="50"
                                    value="{{ old('nama_customer') }}" placeholder="Masukkan nama pelanggan" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Nomor HP</label>
                                <input type="tel" name="noHP_customer" class="form-control" maxlength="15"
                                    value="{{ old('noHP_customer') }}" placeholder="Masukkan nomor HP" required>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                Batal
                            </button>
                            <button type="submit" class="btn btn-success">
                                <i class="bi bi-save me-1"></i> Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- MODAL EDIT PELANGGAN --}}
        @foreach ($data_customer as $customer)
        <div class="modal fade" id="modalEdit{{ $loop->index }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <form action="{{ route('customer.update', $customer->id_customer) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="modal-header">
                            <h5 class="modal-title fw-bold">Edit Data Pelanggan</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>

                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label">ID Pelanggan</label>
                                <input type="text" class="form-control" value="{{ $customer->id_customer }}" readonly>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Nama Pelanggan</label>
                                <input type="text" name="nama_customer" class="form-control" maxlength="50"
                                    value="{{ $customer->nama_customer }}" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Nomor HP</label>
                                <input type="tel" name="noHP_customer" class="form-control" maxlength="15"
                                    value="{{ $customer->noHP_customer }}" required>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                Batal
                            </button>
                            <button type="submit" class="btn btn-success">
                                <i class="bi bi-save me-1"></i> Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @endforeach

    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>