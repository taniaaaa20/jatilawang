<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{
    // DASHBOARD LAMA: TETAP DIPERTAHANKAN
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
        if (!in_array(session('role'), ['pegawai', 'pemilik'])) {
            return redirect()->route('login');
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

        $data_customer = DB::table('customer')
            ->orderBy('nama_customer')
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
            'nama_customer' => 'required|string|max:50',
            'noHP_customer' => 'required|string|max:15',
        ]);

        $id = 'CUS' . strtoupper(substr(uniqid(), -13));

        DB::table('customer')->insert([
            'id_customer' => $id,
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

        $request->validate([
            'nama_customer' => 'required|string|max:50',
            'noHP_customer' => 'required|string|max:15',
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

        DB::table('customer')
            ->where('id_customer', $id)
            ->delete();

        return redirect()->route('customer.index')
            ->with('success', 'Data pelanggan berhasil dihapus.');
    }
}