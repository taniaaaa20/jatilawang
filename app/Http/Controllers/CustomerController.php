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

        DB::table('customer')
            ->where('id_customer', $id)
            ->delete();

        return redirect()->route('customer.index')
            ->with('success', 'Data pelanggan berhasil dihapus.');
    }
}
