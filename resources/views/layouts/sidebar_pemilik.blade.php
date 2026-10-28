
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

    .sidebar a.logout {
        background-color: #4a3228;
        color: #ffffff;
        padding: 10px 16px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        gap: 8px;
        margin-top: 30px;
        font-size: 14px;
        font-weight: 600;
    }

    .sidebar a.logout:hover {
        background-color: #943530;
        color: #ffffff;
    }

    @media (max-width: 600px) {
        .sidebar {
            position: relative;
            width: 100%;
            height: auto;
        }
    }
</style>

<div class="sidebar">

    <div class="logo">
        <i class="bi bi-tree-fill"></i>
        <div>
            Jatilawang
            <span>Adventure</span>
        </div>
    </div>

    {{-- Dashboard --}}
    <a
        class="{{ request()->routeIs('pemilik.dashboard') ? 'active' : '' }}"
        href="{{ route('pemilik.dashboard') }}"
    >
        <i class="bi bi-speedometer2"></i>
        Dashboard
    </a>

    {{-- Kelola Pegawai --}}
    <a
        class="{{ request()->is('pemilik/pegawai*') ? 'active' : '' }}"
        href="{{ url('/pemilik/pegawai') }}"
    >
        <i class="bi bi-person-badge-fill"></i>
        Kelola Pegawai
    </a>

    {{-- Laporan Keuangan --}}
    <a
        class="{{ request()->is('pemilik/laporan-keuangan*') ? 'active' : '' }}"
        href="{{ \Illuminate\Support\Facades\Route::has('pemilik.laporan-keuangan.index')
            ? route('pemilik.laporan-keuangan.index')
            : url('/pemilik/laporan-keuangan') }}"
    >
        <i class="bi bi-cash-stack"></i>
        Laporan Keuangan
    </a>

    {{-- Laporan Stok --}}
    <a
        class="{{ request()->is('pemilik/laporan-stok*') ? 'active' : '' }}"
        href="{{ url('/pemilik/laporan-stok') }}"
    >
        <i class="bi bi-boxes"></i>
        Laporan Stok
    </a>

    {{-- Transaksi --}}
    <a
        class="{{ request()->is('pemilik/transaksi*') ? 'active' : '' }}"
        href="{{ url('/pemilik/transaksi') }}"
    >
        <i class="bi bi-clock-history"></i>
        Transaksi
    </a>

    {{-- Data Customer --}}
    <a
        class="{{ request()->is('pemilik/customer*') ? 'active' : '' }}"
        href="{{ url('/pemilik/customer') }}"
    >
        <i class="bi bi-people-fill"></i>
        Data Customer
    </a>

    {{-- Logout --}}
    <a
        class="logout"
        href="{{ route('logout') }}"
        onclick="event.preventDefault(); document.getElementById('form-logout-pemilik').submit();"
    >
        <i class="bi bi-box-arrow-right"></i>
        Logout
    </a>

    <form
        id="form-logout-pemilik"
        action="{{ route('logout') }}"
        method="POST"
        style="display: none;"
    >
        @csrf
    </form>

</div>
