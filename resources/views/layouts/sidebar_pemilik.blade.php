<div class="sidebar">

    <div class="logo">
        <i class="bi bi-tree-fill"></i>
        <div>
            Jatilawang
            <span>Adventure</span>
        </div>
    </div>

    <a class="active" href="{{ route('pemilik.dashboard') }}">
        <i class="bi bi-speedometer2"></i>
        Dashboard
    </a>

    <a href="{{ url('/pemilik/pegawai') }}">
        <i class="bi bi-person-badge-fill"></i>
        Kelola Pegawai
    </a>

    <a href="{{ url('/pemilik/laporan-keuangan') }}">
        <i class="bi bi-cash-stack"></i>
        Laporan Keuangan
    </a>

    <a href="{{ url('/pemilik/laporan-stok') }}">
        <i class="bi bi-boxes"></i>
        Laporan Stok
    </a>

    <a href="{{ url('/pemilik/transaksi') }}">
        <i class="bi bi-clock-history"></i>
        Transaksi
    </a>

    <a href="{{ url('/pemilik/customer') }}">
        <i class="bi bi-people-fill"></i>
        Data Customer
    </a>

    <a class="logout"
       href="{{ route('logout') }}"
       onclick="event.preventDefault(); document.getElementById('form-logout-pemilik').submit();">
        <i class="bi bi-box-arrow-right"></i>
        Logout
    </a>

    <form id="form-logout-pemilik"
          action="{{ route('logout') }}"
          method="POST"
          style="display:none">
        @csrf
    </form>

</div>
