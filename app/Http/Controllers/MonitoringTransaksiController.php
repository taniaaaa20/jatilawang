<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class MonitoringTransaksiController extends Controller
{
    // Pengecekan hak akses pemilik
    private function cekPemilik()
    {
        if (!session()->has('pegawai')) {
            return redirect()->route('login');
        }

        if (session('role') !== 'pemilik') {
            abort(403, 'Halaman ini hanya dapat diakses oleh pemilik.');
        }

        return null;
    }

    // Halaman monitoring transaksi
    public function index()
    {
        if ($redirect = $this->cekPemilik()) {
            return $redirect;
        }

        // Mengambil seluruh data transaksi
        $data_transaksi = DB::table('sewa as s')
            ->join('customer as c', 's.id_customer', '=', 'c.id_customer')
            ->leftJoin('pegawai as p', 's.id_pegawai', '=', 'p.id_pegawai')
            ->leftJoin('detail_sewa as ds', 's.no_nota', '=', 'ds.no_nota')
            ->leftJoin('barang as b', 'ds.id_barang', '=', 'b.id_barang')

            ->select(
                's.no_nota',
                's.id_pegawai',
                's.id_customer',
                's.tanggal_sewa',
                's.tanggal_kembali',
                's.tanggal_dikembalikan',
                's.tujuan',
                's.denda',
                's.total_transaksi',
                's.status',
                'c.nama_customer',
                'c.noHP_customer',
                'p.nama_pegawai',

                DB::raw("
                    GROUP_CONCAT(
                        CONCAT(
                            b.nama_barang,
                            ' (',
                            ds.jumlah_barang,
                            ')'
                        )
                        SEPARATOR ', '
                    ) AS daftar_barang
                ")
            )

            ->groupBy(
                's.no_nota',
                's.id_pegawai',
                's.id_customer',
                's.tanggal_sewa',
                's.tanggal_kembali',
                's.tanggal_dikembalikan',
                's.tujuan',
                's.denda',
                's.total_transaksi',
                's.status',
                'c.nama_customer',
                'c.noHP_customer',
                'p.nama_pegawai'
            )

            ->orderByDesc('s.tanggal_sewa')
            ->get();

        // Menghitung lama sewa dan menentukan status
        foreach ($data_transaksi as $transaksi) {

            $transaksi->lama_sewa = Carbon::parse(
                $transaksi->tanggal_sewa
            )->diffInDays(
                Carbon::parse($transaksi->tanggal_kembali)
            );

            if ($transaksi->tanggal_dikembalikan) {

                $transaksi->status_tampilan = 'Dikembalikan';

            } elseif (
                $transaksi->tanggal_kembali < now()->toDateString()
            ) {

                $transaksi->status_tampilan = 'Terlambat';

            } else {

                $transaksi->status_tampilan = 'Dipinjam';
            }
        }

        // Menghitung ringkasan transaksi
        $total_transaksi = $data_transaksi->count();

        $transaksi_aktif = $data_transaksi
            ->where('status_tampilan', 'Dipinjam')
            ->count();

        $transaksi_terlambat = $data_transaksi
            ->where('status_tampilan', 'Terlambat')
            ->count();

        $transaksi_selesai = $data_transaksi
            ->where('status_tampilan', 'Dikembalikan')
            ->count();

        return view('pemilik.transaksi', compact(
            'data_transaksi',
            'total_transaksi',
            'transaksi_aktif',
            'transaksi_terlambat',
            'transaksi_selesai'
        ));
    }
}