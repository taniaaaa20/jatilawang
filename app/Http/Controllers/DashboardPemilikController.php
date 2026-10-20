<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class DashboardPemilikController extends Controller
{
    public function index()
    {
        if (session('role') !== 'pemilik') {
            return redirect()->route('login');
        }

        // Total data
        $total_barang = DB::table('barang')->count();

        $total_transaksi = DB::table('sewa')->count();

        $total_pegawai = DB::table('pegawai')->count();

        // Total pendapatan
        $total_pendapatan = DB::table('sewa')
            ->sum('total_transaksi');

        // Transaksi terbaru
        $data_transaksi = DB::table('sewa')
            ->orderByDesc('tanggal_sewa')
            ->limit(5)
            ->get();

        return view('pemilik.dashboard', compact(
            'total_barang',
            'total_transaksi',
            'total_pegawai',
            'total_pendapatan',
            'data_transaksi'
        ));
    }
}
