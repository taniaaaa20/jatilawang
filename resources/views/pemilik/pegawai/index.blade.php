<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Pegawai | Jatilawang Adventure</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            background: #f5f7f5;
            font-family: 'Poppins', sans-serif;
            color: #26352c;
        }

        /* SIDEBAR PEMILIK */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: 250px;
            height: 100vh;
            padding: 25px 16px;
            background: #183226;
            color: white;
            overflow-y: auto;
            z-index: 1000;
        }

        .sidebar .logo {
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 40px;
            padding: 0 10px;
        }

        .sidebar .logo i {
            font-size: 32px;
            color: #e2e8e2;
        }

        .sidebar .logo span {
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
            border-radius: 16px;
            color: #fff;
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.2s ease;
        }

        .sidebar a:hover,
        .sidebar a.active {
            background: #394a39;
            color: #fff;
        }

        .sidebar a i {
            font-size: 18px;
        }

        .sidebar a.logout {
            background: #4a3228;
            color: #fff;
            margin-top: 30px;
            font-weight: 600;
        }

        .sidebar a.logout:hover {
            background: #943530;
            color: #fff;
        }

        /* KONTEN UTAMA */
        .main-content {
            margin-left: 250px;
            padding: 30px;
            min-height: 100vh;
        }

        .page-title {
            font-size: 26px;
            font-weight: 700;
            color: #183226;
            margin-bottom: 6px;
        }

        .page-description {
            color: #7b867e;
            font-size: 14px;
            margin-bottom: 25px;
        }

        /* HEADER DAFTAR PEGAWAI */
        .table-card {
            background: #fff;
            border-radius: 16px;
            padding: 24px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.06);
        }

        .table-card-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 15px;
            flex-wrap: wrap;
            margin-bottom: 22px;
        }

        .table-card-title {
            font-size: 18px;
            font-weight: 700;
            color: #183226;
            margin: 0;
        }

        .btn-tambah {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: #183226;
            color: #fff;
            border: none;
            border-radius: 10px;
            padding: 10px 16px;
            font-size: 13px;
            font-weight: 600;
            text-decoration: none;
            transition: 0.2s;
        }

        .btn-tambah:hover {
            background: #394a39;
            color: #fff;
        }

        /* TABEL */
        .table-responsive {
            border-radius: 10px;
            overflow-x: auto;
        }

        .table {
            margin-bottom: 0;
            font-size: 13px;
            white-space: nowrap;
        }

        .table thead th {
            background: #183226;
            color: #fff;
            border: none;
            padding: 15px 14px;
            font-weight: 600;
            vertical-align: middle;
        }

        .table thead th:first-child {
            border-top-left-radius: 8px;
        }

        .table thead th:last-child {
            border-top-right-radius: 8px;
        }

        .table tbody td {
            padding: 14px;
            vertical-align: middle;
            border-color: #edf0ed;
            color: #39463d;
        }

        .table tbody tr:hover td {
            background: #f4f7f4;
        }

        .role-badge {
            display: inline-block;
            padding: 6px 11px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 600;
            text-transform: capitalize;
        }

        .role-pemilik {
            background: #fdf2c7;
            color: #765d08;
        }

        .role-pegawai {
            background: #e1eee5;
            color: #24583b;
        }

        /* TOMBOL AKSI */
        .action-buttons {
            display: flex;
            align-items: center;
            gap: 7px;
        }

        .btn-edit,
        .btn-hapus {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 5px;
            padding: 7px 11px;
            border: none;
            border-radius: 8px;
            font-size: 12px;
            font-weight: 600;
            text-decoration: none;
            cursor: pointer;
        }

        .btn-edit {
            background: #e7bc20;
            color: #183226;
        }

        .btn-edit:hover {
            background: #d5a900;
            color: #183226;
        }

        .btn-hapus {
            background: #943530;
            color: #fff;
        }

        .btn-hapus:hover {
            background: #762722;
            color: #fff;
        }

        .empty-data {
            padding: 35px 15px !important;
            text-align: center;
            color: #7b867e !important;
        }

        .empty-data i {
            display: block;
            font-size: 32px;
            margin-bottom: 8px;
        }

        /* RESPONSIVE */
        @media (max-width: 900px) {
            .main-content {
                padding: 22px;
            }

            .table-card {
                padding: 18px;
            }
        }

        @media (max-width: 600px) {
            .sidebar {
                position: relative;
                width: 100%;
                height: auto;
                padding: 20px 16px;
            }

            .sidebar .logo {
                margin-bottom: 20px;
            }

            .main-content {
                margin-left: 0;
                padding: 18px;
            }

            .page-title {
                font-size: 22px;
            }

            .table-card {
                padding: 15px;
            }
        }
    </style>
</head>

<body>

    {{-- SIDEBAR PEMILIK --}}
    @include('layouts.sidebar_pemilik')

    {{-- KONTEN UTAMA --}}
    <main class="main-content">

        <div class="d-flex justify-content-between align-items-start flex-wrap gap-3 mb-4">
            <div>
                <h1 class="page-title">Kelola Pegawai</h1>
                <p class="page-description">
                    Kelola data pegawai Jatilawang Adventure.
                </p>
            </div>

            <a href="{{ url('/pemilik/pegawai/tambah') }}" class="btn-tambah">
                <i class="bi bi-plus-lg"></i>
                Tambah Pegawai
            </a>
        </div>

        {{-- DAFTAR PEGAWAI --}}
        <section class="table-card">

            <div class="table-card-header">
                <h2 class="table-card-title">
                    <i class="bi bi-people-fill me-2"></i>
                    Daftar Pegawai
                </h2>

                <span class="text-secondary small">
                    Total: {{ $data_pegawai->count() }} pegawai
                </span>
            </div>

            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th style="width: 60px;">No</th>
                            <th>Nama Pegawai</th>
                            <th>Nomor HP</th>
                            <th>Username</th>
                            <th>Role</th>
                            <th style="width: 160px;">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($data_pegawai as $pegawai)
                            <tr>
                                <td>{{ $loop->iteration }}</td>

                                <td class="fw-semibold">
                                    {{ $pegawai->nama_pegawai }}
                                </td>

                                <td>{{ $pegawai->noHP_pegawai }}</td>

                                <td>{{ $pegawai->username }}</td>

                                <td>
                                    <span class="role-badge {{ $pegawai->role === 'pemilik' ? 'role-pemilik' : 'role-pegawai' }}">
                                        {{ $pegawai->role }}
                                    </span>
                                </td>

                                <td>
                                    <div class="action-buttons">
                                        <a href="{{ url('/pemilik/pegawai/' . $pegawai->id_pegawai . '/edit') }}"
                                           class="btn-edit">
                                            <i class="bi bi-pencil-square"></i>
                                            Edit
                                        </a>

                                        <form action="{{ url('/pemilik/pegawai/' . $pegawai->id_pegawai) }}"
                                              method="POST"
                                              onsubmit="return confirm('Yakin ingin menghapus data pegawai ini?');">
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit" class="btn-hapus">
                                                <i class="bi bi-trash"></i>
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="empty-data">
                                    <i class="bi bi-person-x"></i>
                                    Belum ada data pegawai.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </section>

    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>