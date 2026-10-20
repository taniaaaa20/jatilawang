<div class="sidebar no-print">
    <div class="logo">
        <i class="bi bi-tree-fill"></i>
        <div>
            Jatilawang
            <span>Adventure</span>
        </div>
    </div>

    @if (session('role') === 'pegawai')
        <a class="{{ request()->routeIs('pegawai.dashboard') ? 'active' : '' }}"
           href="{{ route('pegawai.dashboard') }}">
            <i class="bi bi-speedometer2"></i>
            Dashboard
        </a>

        <a href="#">
            <i class="bi bi-box-seam-fill"></i>
            Kelola Barang
        </a>

        <a href="#">
            <i class="bi bi-people-fill"></i>
            Data Pelanggan
        </a>

        <a href="#">
            <i class="bi bi-cart-check-fill"></i>
            Transaksi Rental
        </a>
    @endif

    @if (session('role') === 'pemilik')
        <a href="{{ route('pemilik.dashboard') }}">
            <i class="bi bi-speedometer2"></i>
            Dashboard
        </a>

        <a href="#">
            <i class="bi bi-person-badge-fill"></i>
            Kelola Pegawai
        </a>

        <a href="#">
            <i class="bi bi-bar-chart-fill"></i>
            Laporan
        </a>
    @endif

    <form action="{{ route('logout') }}" method="POST" class="logout-form">
        @csrf
        <button type="submit" class="logout">
            <i class="bi bi-box-arrow-right"></i>
            Logout
        </button>
    </form>
</div>
