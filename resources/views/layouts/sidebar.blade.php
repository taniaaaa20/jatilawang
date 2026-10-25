```html
<style>
.sidebar {
    position: fixed;
    top: 0;
    left: 0;
    width: 260px;
    height: 100vh;
    padding: 25px;
    background: #2f3e2c;
    color: white;
    overflow-y: auto;
    z-index: 1000;
    font-family: 'Poppins', sans-serif;
    box-sizing: border-box;
}

.sidebar * {
    box-sizing: border-box;
}

.sidebar .logo {
    display: flex;
    align-items: center;
    gap: 12px;
    font-size: 22px;
    font-weight: 700;
    margin-bottom: 40px;
}

.sidebar .logo>i {
    font-size: 30px;
}

.sidebar .logo span {
    display: block;
    color: #facc15;
}

.sidebar a {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 12px 18px;
    margin-bottom: 8px;
    border-radius: 16px;
    color: #ffffff;
    text-decoration: none;
    font-size: 14px;
    font-weight: 500;
    transition: background-color 0.2s ease;
}

.sidebar a i {
    font-size: 18px;
    margin-right: 0;
}

.sidebar a:hover,
.sidebar a.active {
    background: #394a39;
    color: #ffffff;
}

.sidebar .logout-form {
    margin-top: 35px;
    margin-bottom: 0;
    width: 100%;
}

.sidebar button.logout {
    display: flex;
    width: 100%;
    align-items: center;
    justify-content: flex-start;
    gap: 8px;
    background-color: #4a3228;
    color: #ffffff;
    padding: 10px 16px;
    border: none;
    border-radius: 12px;
    font-family: inherit;
    font-size: 14px;
    font-weight: 600;
    line-height: 1.5;
    cursor: pointer;
    transition: background-color 0.2s ease;
}

.sidebar button.logout:hover {
    background-color: #943530;
    color: #ffffff;
}

.sidebar button.logout i {
    font-size: 18px;
}

@media (max-width: 768px) {
    .sidebar {
        position: relative;
        width: 100%;
        height: auto;
    }
}
</style>

<div class="sidebar no-print">
    <div class="logo">
        <i class="bi bi-tree-fill"></i>
        <div>
            Jatilawang
            <span>Adventure</span>
        </div>
    </div>

    {{-- MENU PEGAWAI --}}
    @if (session('role') === 'pegawai')
    <a class="{{ request()->routeIs('pegawai.dashboard') ? 'active' : '' }}" href="{{ route('pegawai.dashboard') }}">
        <i class="bi bi-speedometer2"></i>
        Dashboard
    </a>

    <a class="{{ request()->routeIs('barang.*') ? 'active' : '' }}" href="{{ route('barang.index') }}">
        <i class="bi bi-box-seam-fill"></i>
        Kelola Barang
    </a>

<a class="{{ request()->routeIs('customer.index') ? 'active' : '' }}"
   href="{{ route('customer.index') }}">
    <i class="bi bi-people-fill"></i>
    Data Pelanggan
</a>

    <a href="#">
        <i class="bi bi-cart-check-fill"></i>
        Transaksi Rental
    </a>
    @endif

    {{-- MENU PEMILIK --}}
    @if (session('role') === 'pemilik')
    <a class="{{ request()->routeIs('pemilik.dashboard') ? 'active' : '' }}" href="{{ route('pemilik.dashboard') }}">
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

    {{-- LOGOUT --}}
    <form action="{{ route('logout') }}" method="POST" class="logout-form">
        @csrf
        <button type="submit" class="logout">
            <i class="bi bi-box-arrow-right"></i>
            Logout
        </button>
    </form>
</div>
