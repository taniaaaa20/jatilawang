<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class CustomerController extends Controller
{
    // DASHBOARD CUSTOMER
    public function index()
    {
        $kategoriList = [
            'Tenda',
            'Carrier',
            'Peralatan Masak',
            'Peralatan Tidur',
            'Peralatan Tracking',
            'Penerangan',
            'Peralatan Lainnya'
        ];

        $dataBarang = Barang::orderBy('nama_barang')->get();

        return view('customer.dashboard', compact(
            'kategoriList',
            'dataBarang'
        ));
    }

    // CEK AKSES PEGAWAI DAN PEMILIK
    private function cekAkses()
    {
        if (!session()->has('pegawai')) {
            return redirect()->route('login');
        }

        if (!in_array(session('role'), ['pegawai', 'pemilik'])) {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }

        return null;
    }

    // MENAMPILKAN DATA PELANGGAN
    public function dataPelanggan()
    {
        $cek = $this->cekAkses();

        if ($cek) {
            return $cek;
        }

        $data_customer = DB::table('customer as c')
            ->leftJoin('sewa as s', 'c.id_customer', '=', 's.id_customer')
            ->select(
                'c.id_customer',
                'c.nama_customer',
                'c.noHP_customer',
                DB::raw('COUNT(s.no_nota) AS total_transaksi'),
                DB::raw('COALESCE(SUM(s.total_transaksi), 0) AS total_belanja'),
                DB::raw('MAX(s.tanggal_sewa) AS transaksi_terakhir')
            )
            ->groupBy(
                'c.id_customer',
                'c.nama_customer',
                'c.noHP_customer'
            )
            ->orderBy('c.nama_customer')
            ->get();

        return view('customer.index', compact('data_customer'));
    }

    // MENAMBAHKAN PELANGGAN
    public function store(Request $request)
    {
        $cek = $this->cekAkses();

        if ($cek) {
            return $cek;
        }

        $request->validate([
            'id_customer' => [
                'required',
                'digits:16',
                Rule::unique('customer', 'id_customer'),
            ],
            'nama_customer' => 'required|string|max:50',
            'noHP_customer' => 'required|string|max:15',
        ], [
            'id_customer.required' => 'Nomor KTP wajib diisi.',
            'id_customer.digits' => 'Nomor KTP harus terdiri dari 16 digit.',
            'id_customer.unique' => 'Nomor KTP sudah terdaftar.',
            'nama_customer.required' => 'Nama pelanggan wajib diisi.',
            'nama_customer.max' => 'Nama pelanggan maksimal 50 karakter.',
            'noHP_customer.required' => 'Nomor HP wajib diisi.',
            'noHP_customer.max' => 'Nomor HP maksimal 15 karakter.',
        ]);

        DB::table('customer')->insert([
            'id_customer' => $request->id_customer,
            'nama_customer' => $request->nama_customer,
            'noHP_customer' => $request->noHP_customer,
        ]);

        return redirect()->route('customer.index')
            ->with('success', 'Pelanggan berhasil ditambahkan.');
    }

    // MENGUBAH DATA PELANGGAN
    public function update(Request $request, $id)
    {
        $cek = $this->cekAkses();

        if ($cek) {
            return $cek;
        }

        $customer = DB::table('customer')
            ->where('id_customer', $id)
            ->first();

        if (!$customer) {
            return redirect()->route('customer.index')
                ->with('error', 'Data pelanggan tidak ditemukan.');
        }

        $request->validate([
            'nama_customer' => 'required|string|max:50',
            'noHP_customer' => 'required|string|max:15',
        ], [
            'nama_customer.required' => 'Nama pelanggan wajib diisi.',
            'nama_customer.max' => 'Nama pelanggan maksimal 50 karakter.',
            'noHP_customer.required' => 'Nomor HP wajib diisi.',
            'noHP_customer.max' => 'Nomor HP maksimal 15 karakter.',
        ]);

        DB::table('customer')
            ->where('id_customer', $id)
            ->update([
                'nama_customer' => $request->nama_customer,
                'noHP_customer' => $request->noHP_customer,
            ]);

        return redirect()->route('customer.index')
            ->with('success', 'Data pelanggan berhasil diperbarui.');
    }

    // MENGHAPUS DATA PELANGGAN
    public function destroy($id)
    {
        $cek = $this->cekAkses();

        if ($cek) {
            return $cek;
        }

        $customer = DB::table('customer')
            ->where('id_customer', $id)
            ->first();

        if (!$customer) {
            return redirect()->route('customer.index')
                ->with('error', 'Data pelanggan tidak ditemukan.');
        }

        $adaTransaksi = DB::table('sewa')
            ->where('id_customer', $id)
            ->exists();

        if ($adaTransaksi) {
            return redirect()->route('customer.index')
                ->with(
                    'error',
                    'Pelanggan tidak dapat dihapus karena sudah memiliki riwayat transaksi.'
                );
        }

        $terhapus = DB::table('customer')
            ->where('id_customer', $id)
            ->delete();

        if (!$terhapus) {
            return redirect()->route('customer.index')
                ->with('error', 'Data pelanggan gagal dihapus.');
        }

        return redirect()->route('customer.index')
            ->with('success', 'Data pelanggan berhasil dihapus.');
    }
}
