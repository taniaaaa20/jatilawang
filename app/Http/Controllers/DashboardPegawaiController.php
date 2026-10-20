<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class DashboardPegawaiController extends Controller
{
    public function index()
    {
        if (session('role') !== 'pegawai') {
            return redirect()->route('login');
        }

        $total_barang = DB::table('barang')->count();
        $total_transaksi = DB::table('sewa')->count();
        $total_customer = DB::table('customer')->count();


        $total_aktif = DB::table('sewa')
            ->where('status', 'Dipinjam')
            ->count();


        $data_barang = DB::table('barang')
            ->orderByDesc('id_barang')
            ->limit(5)
            ->get();

        return view('pegawai.dashboard', compact(
            'total_barang',
            'total_transaksi',
            'total_customer',
            'total_aktif',
            'data_barang'
        ));
    }
}
