<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class LaporanStokController extends Controller
{
    public function index()
    {
        // Cek login
        if (!session()->has('pegawai')) {
            return redirect()->route('login');
        }

        // Khusus pemilik
        if (session('role') !== 'pemilik') {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }

        // Mengambil seluruh data barang
        $data_barang = DB::table('barang')
            ->orderBy('nama_barang', 'asc')
            ->get();

        // Menghitung total jenis barang
        $total_barang = DB::table('barang')->count();

        // Menghitung total seluruh stok
        $total_stok = DB::table('barang')->sum('stok') ?? 0;

        // Menghitung barang dengan stok rendah (stok <= 3)
        $stok_rendah = DB::table('barang')
            ->where('stok', '<=', 3)
            ->count();

        return view('pemilik.laporan_stok.index', compact(
            'data_barang',
            'total_barang',
            'total_stok',
            'stok_rendah'
        ));
    }
}
