<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jatilawang Adventure</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        * {
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            margin: 0;
            background: #f5f5f5;
            color: #2f3e2c;
        }

        .navbar {
            background: white;
            padding: 18px 0;
            box-shadow: 0 2px 15px rgba(0,0,0,.08);
        }

        .logo {
            color: #2f3e2c;
            font-size: 24px;
            font-weight: 800;
            text-decoration: none;
        }

        .logo span {
            color: #b45309;
        }

        .hero {
            margin-top: 35px;
            padding: 65px 45px;
            border-radius: 25px;
            color: white;
            background:
                linear-gradient(90deg, rgba(35,50,32,.93), rgba(90,60,35,.65)),
                url('https://media.istockphoto.com/id/1391293923/id/vektor/lanskap-gunung-vintage-gunung-dengan-hutan-dan-matahari-gaya-retro.jpg?s=170667a&w=0&k=20&c=KpcUOAEs-SfBNlqpmhgyZiIjaTDn3rakjJ4hwONsK98=');
            background-size: cover;
            background-position: center;
        }

        .hero h1 {
            font-size: clamp(32px, 5vw, 52px);
            font-weight: 800;
        }

        .hero p {
            max-width: 600px;
            line-height: 1.8;
            color: #f1f1f1;
        }

        .btn-wa {
            display: inline-block;
            margin-top: 15px;
            padding: 12px 22px;
            border-radius: 30px;
            background: #198754;
            color: white;
            font-weight: 600;
            text-decoration: none;
        }

        .section-title {
            margin-bottom: 25px;
            font-size: 28px;
            font-weight: 800;
        }

        .filter-box {
            padding: 20px;
            margin-bottom: 25px;
            border-radius: 18px;
            background: white;
        }

        .product-card {
            height: 100%;
            overflow: hidden;
            border-radius: 18px;
            background: white;
            box-shadow: 0 4px 15px rgba(0,0,0,.06);
            transition: .2s;
        }

        .product-card:hover {
            transform: translateY(-4px);
        }

        .product-img {
            width: 100%;
            height: 190px;
            object-fit: cover;
            background: #e5e7eb;
        }

        .product-info {
            padding: 18px;
        }

        .category {
            color: #b45309;
            font-size: 12px;
            font-weight: 600;
        }

        .product-name {
            margin-top: 7px;
            font-size: 17px;
            font-weight: 700;
        }

        .price {
            margin-top: 12px;
            color: #b45309;
            font-size: 19px;
            font-weight: 800;
        }

        .stock {
            margin-top: 8px;
            font-size: 13px;
        }

        footer {
            margin-top: 60px;
            padding: 25px 10px;
            background: #2f3e2c;
            color: white;
            text-align: center;
        }

        @media (max-width: 576px) {
            .hero {
                padding: 40px 25px;
            }
        }
    </style>
</head>

<body>
    <nav class="navbar">
        <div class="container d-flex justify-content-between align-items-center">
            <a href="{{ route('customer.dashboard') }}" class="logo">
                <i class="bi bi-tree-fill"></i>
                Jatilawang<span>Adventure</span>
            </a>

            <a href="#produk" class="btn btn-outline-success rounded-pill">
                Barang
            </a>
        </div>
    </nav>

    <main class="container">
        <section class="hero">
            <h1>Explore Nature<br>With Better Gear</h1>

            <p>
                Temukan berbagai perlengkapan camping premium
                untuk petualangan outdoor terbaikmu.
            </p>

            <a href="https://wa.me/6285240975464" target="_blank"
               class="btn-wa">
                <i class="bi bi-whatsapp"></i> WhatsApp
            </a>
        </section>

        <section class="mt-5" id="produk">
            <h2 class="section-title">Perlengkapan Camping</h2>

            <div class="filter-box">
                <div class="row g-3">
                    <div class="col-md-6">
                        <input type="text" id="cari"
                               class="form-control"
                               placeholder="Cari nama barang atau merek..."
                               oninput="filterProduk()">
                    </div>

                    <div class="col-md-6">
                        <select id="kategori" class="form-select"
                                onchange="filterProduk()">
                            <option value="">Semua Kategori</option>

                            @foreach ($kategoriList as $kategori)
                                <option value="{{ $kategori }}">
                                    {{ $kategori }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="row g-4" id="daftarProduk">
                @forelse ($dataBarang as $barang)
                    <div class="col-lg-3 col-md-4 col-sm-6 item-produk"
                         data-nama="{{ strtolower($barang->nama_barang . ' ' . ($barang->merk ?? '')) }}"
                         data-kategori="{{ $barang->kategori }}">

                        <div class="product-card">
                            @if (!empty($barang->gambar))
                                <img
                                    src="{{ asset('gambar/' . $barang->gambar) }}"
                                    class="product-img"
                                    alt="{{ $barang->nama_barang }}">
                            @else
                                <div class="product-img d-flex align-items-center justify-content-center">
                                    <i class="bi bi-image fs-1 text-secondary"></i>
                                </div>
                            @endif

                            <div class="product-info">
                                <div class="category">
                                    {{ $barang->kategori }}
                                </div>

                                <div class="product-name">
                                    {{ $barang->nama_barang }}
                                </div>

                                @if (!empty($barang->merk))
                                    <div class="text-secondary small mt-1">
                                        {{ $barang->merk }}
                                    </div>
                                @endif

                                <div class="price">
                                    Rp {{ number_format($barang->harga, 0, ',', '.') }}
                                </div>

                                <div class="stock">
                                    @if ($barang->stok > 0)
                                        <span class="badge bg-success">TERSEDIA</span>
                                        <span class="text-secondary">
                                            Stok: {{ $barang->stok }}
                                        </span>
                                    @else
                                        <span class="badge bg-danger">HABIS</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="alert alert-light">
                            Belum ada data barang yang tersedia.
                        </div>
                    </div>
                @endforelse
            </div>

            <p id="tidakDitemukan" class="text-center mt-4 d-none">
                Barang tidak ditemukan.
            </p>
        </section>
    </main>

    <footer>
        Jatilawang Adventure © 2026 | Sistem Penyewaan Camping
    </footer>

    <script>
        function filterProduk() {
            const cari = document.getElementById('cari').value.toLowerCase();
            const kategori = document.getElementById('kategori').value;
            const produk = document.querySelectorAll('.item-produk');
            let jumlahTampil = 0;

            produk.forEach(function(item) {
                const nama = item.dataset.nama;
                const jenis = item.dataset.kategori;

                const cocokNama = nama.includes(cari);
                const cocokKategori = kategori === '' || jenis === kategori;

                if (cocokNama && cocokKategori) {
                    item.classList.remove('d-none');
                    jumlahTampil++;
                } else {
                    item.classList.add('d-none');
                }
            });

            document.getElementById('tidakDitemukan')
                .classList.toggle('d-none', jumlahTampil > 0);
        }
    </script>
</body>
</html>
