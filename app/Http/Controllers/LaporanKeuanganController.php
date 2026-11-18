<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class LaporanKeuanganController extends Controller
{
    public function index(Request $request)
    {
        if (session('role') !== 'pemilik') {
            return redirect()->route('login');
        }

        $periode = $request->input('periode', 'bulanan');
        $tanggalAwal = $request->input('tanggal_awal');
        $tanggalAkhir = $request->input('tanggal_akhir');

        // Tentukan rentang tanggal laporan
        if ($tanggalAwal && $tanggalAkhir) {
            $awal = Carbon::parse($tanggalAwal)->startOfDay();
            $akhir = Carbon::parse($tanggalAkhir)->endOfDay();
        } else {
            $sekarang = Carbon::today();

            switch ($periode) {
                case 'harian':
                    $awal = $sekarang->copy()->startOfDay();
                    $akhir = $sekarang->copy()->endOfDay();
                    break;

                case 'mingguan':
                    $awal = $sekarang->copy()->startOfWeek();
                    $akhir = $sekarang->copy()->endOfWeek();
                    break;

                case 'tahunan':
                    $awal = $sekarang->copy()->startOfYear();
                    $akhir = $sekarang->copy()->endOfYear();
                    break;

                default:
                    $periode = 'bulanan';
                    $awal = $sekarang->copy()->startOfMonth();
                    $akhir = $sekarang->copy()->endOfMonth();
                    break;
            }

            $tanggalAwal = $awal->toDateString();
            $tanggalAkhir = $akhir->toDateString();
        }

        // Query dasar berdasarkan tanggal sewa
        $query = DB::table('sewa')
            ->whereBetween('tanggal_sewa', [
                $awal->toDateString(),
                $akhir->toDateString()
            ]);

        // Ringkasan keuangan
        $ringkasan = (clone $query)
            ->selectRaw('COUNT(*) as total_transaksi')
            ->selectRaw('COALESCE(SUM(total_transaksi), 0) as total_pendapatan')
            ->selectRaw('COALESCE(SUM(denda), 0) as total_denda')
            ->first();

        // Daftar transaksi
        $dataTransaksi = (clone $query)
            ->leftJoin('customer', 'sewa.id_customer', '=', 'customer.id_customer')
            ->select(
                'sewa.no_nota',
                'sewa.tanggal_sewa',
                'sewa.tanggal_kembali',
                'sewa.total_transaksi',
                'sewa.denda',
                'customer.nama_customer'
            )
            ->orderByDesc('sewa.tanggal_sewa')
            ->orderByDesc('sewa.no_nota')
            ->get();

        // Barang paling laris berdasarkan jumlah barang yang disewa
        $barangTerlaris = DB::table('detail_sewa')
            ->join('sewa', 'detail_sewa.no_nota', '=', 'sewa.no_nota')
            ->join('barang', 'detail_sewa.id_barang', '=', 'barang.id_barang')
            ->whereBetween('sewa.tanggal_sewa', [
                $awal->toDateString(),
                $akhir->toDateString()
            ])
            ->select(
                'barang.nama_barang',
                DB::raw('SUM(detail_sewa.jumlah_barang) as total_disewa')
            )
            ->groupBy('barang.id_barang', 'barang.nama_barang')
            ->orderByDesc('total_disewa')
            ->limit(5)
            ->get();

        // Data grafik pendapatan per tanggal
        $dataGrafik = (clone $query)
            ->select('tanggal_sewa')
            ->selectRaw('SUM(total_transaksi) as pendapatan')
            ->groupBy('tanggal_sewa')
            ->orderBy('tanggal_sewa')
            ->get();

        return view('pemilik.laporan_keuangan.index', compact(
            'periode',
            'tanggalAwal',
            'tanggalAkhir',
            'ringkasan',
            'dataTransaksi',
            'barangTerlaris',
            'dataGrafik'
        ));
    }
}
