<style>
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
        box-sizing: border-box;
        font-family: 'Poppins', sans-serif;
    }

    .sidebar * {
        box-sizing: border-box;
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
        color: #ffffff;
        text-decoration: none;
        font-size: 14px;
        font-weight: 500;
        transition: all 0.2s ease;
    }

    .sidebar a:hover,
    .sidebar a.active {
        background: #394a39;
        color: #ffffff;
    }

    .sidebar a i {
        font-size: 18px;
    }

    .sidebar .logout-form {
        margin-top: 30px;
        margin-bottom: 0;
        width: 100%;
    }

    .sidebar button.logout {
        background-color: #4a3228;
        color: #ffffff;
        padding: 10px 16px;
        border: none;
        border-radius: 12px;
        display: flex;
        align-items: center;
        gap: 8px;
        width: 100%;
        font-family: inherit;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
    }

    .sidebar button.logout:hover {
        background-color: #943530;
        color: #ffffff;
    }

    .sidebar button.logout i {
        font-size: 18px;
    }

    @media (max-width: 600px) {
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

        <a class="{{ request()->routeIs('pegawai.dashboard') ? 'active' : '' }}"
            href="{{ route('pegawai.dashboard') }}">
            <i class="bi bi-speedometer2"></i>
            Dashboard
        </a>

        <a class="{{ request()->routeIs('barang.*') ? 'active' : '' }}"
            href="{{ route('barang.index') }}">
            <i class="bi bi-box-seam-fill"></i>
            Kelola Barang
        </a>

        <a class="{{ request()->routeIs('customer.index') ? 'active' : '' }}"
            href="{{ route('customer.index') }}">
            <i class="bi bi-people-fill"></i>
            Data Pelanggan
        </a>

        <a class="{{ request()->routeIs('transaksi.*') ? 'active' : '' }}"
            href="{{ route('transaksi.index') }}">
            <i class="bi bi-cart-check-fill"></i>
            Transaksi Rental
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
