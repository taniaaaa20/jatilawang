<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransaksiRentalController extends Controller
{
    private function cekLogin()
    {
        if (!session()->has('pegawai')) {
            return redirect()->route('login');
        }

        return null;
    }

    // Menampilkan form dan daftar transaksi
    public function index()
    {
        if ($redirect = $this->cekLogin()) {
            return $redirect;
        }

        $data_customer = DB::table('customer')
            ->orderBy('nama_customer')
            ->get();

        $data_barang = DB::table('barang')
            ->where('stok', '>', 0)
            ->orderBy('nama_barang')
            ->get();

        $data_transaksi = DB::table('sewa as s')
            ->join('customer as c', 's.id_customer', '=', 'c.id_customer')
            ->leftJoin('detail_sewa as ds', 's.no_nota', '=', 'ds.no_nota')
            ->leftJoin('barang as b', 'ds.id_barang', '=', 'b.id_barang')
            ->select(
                's.*',
                'c.nama_customer',
                'c.noHP_customer',
                DB::raw("GROUP_CONCAT(CONCAT(b.nama_barang, ' (', ds.jumlah_barang, ')') SEPARATOR ', ') AS daftar_barang")
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
                'c.noHP_customer'
            )
            ->orderByDesc('s.tanggal_sewa')
            ->get();

        foreach ($data_transaksi as $transaksi) {
            if ($transaksi->tanggal_dikembalikan) {
                $transaksi->status_tampilan = 'Dikembalikan';
            } elseif ($transaksi->tanggal_kembali < now()->toDateString()) {
                $transaksi->status_tampilan = 'Terlambat';
            } else {
                $transaksi->status_tampilan = 'Dipinjam';
            }
        }

        return view('pegawai.transaksi.index', compact(
            'data_customer',
            'data_barang',
            'data_transaksi'
        ));
    }

    // Menyimpan transaksi rental
    public function store(Request $request)
    {
        if ($redirect = $this->cekLogin()) {
            return $redirect;
        }

        $request->validate([
            'id_customer' => 'required|exists:customer,id_customer',
            'tanggal_sewa' => 'required|date',
            'lama_sewa' => 'required|integer|min:1',
            'tujuan' => 'required|string|max:50',
            'id_barang' => 'required|array|min:1',
            'id_barang.*' => 'required|exists:barang,id_barang',
            'jumlah' => 'required|array|min:1',
            'jumlah.*' => 'required|integer|min:1',
        ]);

        if (count($request->id_barang) !== count($request->jumlah)) {
            return back()->withInput()
                ->with('error', 'Daftar barang dan jumlah tidak sesuai.');
        }

        // Gabungkan jika barang yang sama dipilih lebih dari sekali
        $pesanan = [];

        foreach ($request->id_barang as $i => $idBarang) {
            $jumlah = (int) $request->jumlah[$i];

            if (!isset($pesanan[$idBarang])) {
                $pesanan[$idBarang] = 0;
            }

            $pesanan[$idBarang] += $jumlah;
        }

        try {
            DB::transaction(function () use ($request, $pesanan) {
                $tanggalSewa = $request->tanggal_sewa;
                $tanggalKembali = date(
                    'Y-m-d',
                    strtotime($tanggalSewa . ' +' . (int) $request->lama_sewa . ' days')
                );

                $total = 0;
                $items = [];

                foreach ($pesanan as $idBarang => $jumlah) {
                    $barang = DB::table('barang')
                        ->where('id_barang', $idBarang)
                        ->lockForUpdate()
                        ->first();

                    if (!$barang) {
                        throw new \RuntimeException('Barang tidak ditemukan.');
                    }

                    if ((int) $barang->stok < $jumlah) {
                        throw new \RuntimeException(
                            'Stok ' . $barang->nama_barang . ' tidak mencukupi.'
                        );
                    }

                    $subtotal = (int) $barang->harga
                        * $jumlah
                        * (int) $request->lama_sewa;

                    $total += $subtotal;

                    $items[] = [
                        'id_barang' => $idBarang,
                        'jumlah_barang' => $jumlah,
                    ];
                }
                
                $notaTerakhir = DB::table('sewa')
                    ->where('no_nota', 'like', 'NT%')
                    ->orderByDesc('no_nota')
                    ->lockForUpdate()
                    ->value('no_nota');

                $nomor = $notaTerakhir
                    ? ((int) substr($notaTerakhir, 2)) + 1
                    : 1;

                $noNota = 'NT' . str_pad($nomor, 6, '0', STR_PAD_LEFT);

                if (strlen($noNota) > 8) {
                    throw new \RuntimeException('Nomor transaksi sudah mencapai batas.');
                }

                DB::table('sewa')->insert([
                    'no_nota' => $noNota,
                    'id_pegawai' => session('pegawai'),
                    'id_customer' => $request->id_customer,
                    'tanggal_sewa' => $tanggalSewa,
                    'tanggal_kembali' => $tanggalKembali,
                    'tanggal_dikembalikan' => null,
                    'tujuan' => $request->tujuan,
                    'denda' => 0,
                    'total_transaksi' => $total,
                    'status' => 'Dipinjam',
                ]);

                foreach ($items as $item) {
                    DB::table('detail_sewa')->insert([
                        'no_nota' => $noNota,
                        'id_barang' => $item['id_barang'],
                        'jumlah_barang' => $item['jumlah_barang'],
                    ]);

                    DB::table('barang')
                        ->where('id_barang', $item['id_barang'])
                        ->decrement('stok', $item['jumlah_barang']);
                }
            });

            return redirect()->route('transaksi.index')
                ->with('success', 'Transaksi rental berhasil disimpan.');
        } catch (\Throwable $e) {
            return back()->withInput()
                ->with('error', $e->getMessage());
        }
    }

    // Proses pengembalian barang
    public function kembalikan($noNota)
    {
        if ($redirect = $this->cekLogin()) {
            return $redirect;
        }

        try {
            DB::transaction(function () use ($noNota) {
                $sewa = DB::table('sewa')
                    ->where('no_nota', $noNota)
                    ->lockForUpdate()
                    ->first();

                if (!$sewa) {
                    throw new \RuntimeException('Transaksi tidak ditemukan.');
                }

                if ($sewa->tanggal_dikembalikan) {
                    throw new \RuntimeException('Barang pada transaksi ini sudah dikembalikan.');
                }

                $detail = DB::table('detail_sewa')
                    ->where('no_nota', $noNota)
                    ->get();

                foreach ($detail as $item) {
                    DB::table('barang')
                        ->where('id_barang', $item->id_barang)
                        ->increment('stok', $item->jumlah_barang);
                }

                DB::table('sewa')
                    ->where('no_nota', $noNota)
                    ->update([
                        'tanggal_dikembalikan' => now()->toDateString(),
                        'status' => 'Dikembalikan',
                    ]);
            });

            return redirect()->route('transaksi.index')
                ->with('success', 'Pengembalian barang berhasil dicatat.');
        } catch (\Throwable $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    // Menampilkan nota hanya untuk transaksi yang sudah dikembalikan
    public function nota($noNota)
    {
        if ($redirect = $this->cekLogin()) {
            return $redirect;
        }

        $transaksi = DB::table('sewa as s')
            ->join('customer as c', 's.id_customer', '=', 'c.id_customer')
            ->where('s.no_nota', $noNota)
            ->select('s.*', 'c.nama_customer', 'c.noHP_customer')
            ->first();

        if (!$transaksi) {
            abort(404);
        }

        if (!$transaksi->tanggal_dikembalikan) {
            return redirect()->route('transaksi.index')
                ->with('error', 'Nota hanya tersedia setelah barang dikembalikan.');
        }

        $detail = DB::table('detail_sewa as ds')
            ->join('barang as b', 'ds.id_barang', '=', 'b.id_barang')
            ->where('ds.no_nota', $noNota)
            ->select('ds.*', 'b.nama_barang', 'b.harga')
            ->get();

        return view('pegawai.transaksi.nota', compact('transaksi', 'detail'));
    }
}
