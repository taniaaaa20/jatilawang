<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BarangController extends Controller
{
    private function cekLogin()
    {
        if (!session()->has('pegawai')) {
            return redirect()->route('login');
        }

        return null;
    }

    // Membuat kode barang berdasarkan kategori
    private function buatIdBarang($kategori)
    {
        $daftarKode = [
            'Carrier' => 'CAR',
            'Tenda' => 'TEN',
            'Sepatu' => 'SEP',
            'Jaket' => 'JAK',
            'Matras' => 'MAT',
            'Trekking Pole' => 'TRK',
            'Peralatan Masak' => 'MAS',
        ];

        $kategoriNormal = trim($kategori);
        $kodeKategori = $daftarKode[$kategoriNormal] ?? null;

        if (!$kodeKategori) {
            abort(422, 'Kategori belum memiliki kode barang.');
        }

        // Cari nomor terbesar untuk kategori tersebut
        $barangTerakhir = DB::table('barang')
            ->where('id_barang', 'like', $kodeKategori . '%')
            ->orderByRaw(
                'CAST(SUBSTRING(id_barang, 4, 2) AS UNSIGNED) DESC'
            )
            ->first();

        if ($barangTerakhir) {
            $nomorTerakhir = (int) substr(
                $barangTerakhir->id_barang,
                3,
                2
            );

            $nomorBaru = $nomorTerakhir + 1;
        } else {
            $nomorBaru = 1;
        }

        if ($nomorBaru > 99) {
            abort(422, 'Nomor kode barang untuk kategori ini sudah penuh.');
        }

        return $kodeKategori . str_pad(
            $nomorBaru,
            2,
            '0',
            STR_PAD_LEFT
        );
    }

    // Menampilkan daftar barang
    public function index()
    {
        if ($redirect = $this->cekLogin()) {
            return $redirect;
        }

        $data_barang = DB::table('barang')
            ->orderBy('id_barang', 'asc')
            ->get();

        return view('pegawai.barang.index', compact('data_barang'));
    }

    // Menampilkan form tambah barang
    public function create()
    {
        if ($redirect = $this->cekLogin()) {
            return $redirect;
        }

        return view('pegawai.barang.tambah');
    }

    // Menyimpan barang baru
    public function store(Request $request)
    {
        if ($redirect = $this->cekLogin()) {
            return $redirect;
        }

        $request->validate([
            'nama_barang' => 'required|string|max:255',
            'merk' => 'required|string|max:255',
            'kategori' => 'required|string|max:100',
            'harga' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'gambar' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $folderGambar = public_path('gambar');

        if (!file_exists($folderGambar)) {
            mkdir($folderGambar, 0755, true);
        }

        // Membuat ID berdasarkan kategori
        $idBarang = $this->buatIdBarang($request->kategori);

        $namaGambar = $request->file('gambar')->hashName();

        $request->file('gambar')->move(
            $folderGambar,
            $namaGambar
        );

        DB::table('barang')->insert([
            'id_barang' => $idBarang,
            'nama_barang' => $request->nama_barang,
            'merk' => $request->merk,
            'kategori' => $request->kategori,
            'harga' => $request->harga,
            'stok' => $request->stok,
            'gambar' => $namaGambar,
        ]);

        return redirect()
            ->route('barang.index')
            ->with('success', 'Barang berhasil ditambahkan.');
    }

    // Menampilkan form edit barang
    public function edit($id)
    {
        if ($redirect = $this->cekLogin()) {
            return $redirect;
        }

        $data = DB::table('barang')
            ->where('id_barang', $id)
            ->first();

        if (!$data) {
            abort(404);
        }

        return view('pegawai.barang.edit', compact('data'));
    }

    // Memperbarui data barang
    public function update(Request $request, $id)
    {
        if ($redirect = $this->cekLogin()) {
            return $redirect;
        }

        $request->validate([
            'nama_barang' => 'required|string|max:255',
            'merk' => 'required|string|max:255',
            'kategori' => 'required|string|max:100',
            'harga' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $data = DB::table('barang')
            ->where('id_barang', $id)
            ->first();

        if (!$data) {
            abort(404);
        }

        $namaGambar = $data->gambar;
        $folderGambar = public_path('gambar');

        if ($request->hasFile('gambar')) {
            if (!file_exists($folderGambar)) {
                mkdir($folderGambar, 0755, true);
            }

            $namaGambar = $request->file('gambar')->hashName();

            $request->file('gambar')->move(
                $folderGambar,
                $namaGambar
            );

            if (
                $data->gambar &&
                file_exists($folderGambar . '/' . $data->gambar)
            ) {
                unlink($folderGambar . '/' . $data->gambar);
            }
        }

        DB::table('barang')
            ->where('id_barang', $id)
            ->update([
                'nama_barang' => $request->nama_barang,
                'merk' => $request->merk,
                'kategori' => $request->kategori,
                'harga' => $request->harga,
                'stok' => $request->stok,
                'gambar' => $namaGambar,
            ]);

        return redirect()
            ->route('barang.index')
            ->with('success', 'Barang berhasil diubah.');
    }

    // Menghapus barang

    public function destroy($id)
    {
        $data = DB::table('barang')
            ->where('id_barang', $id)
            ->first();

        if (!$data) {
            return redirect()
                ->route('barang.index')
                ->with('error', 'Barang tidak ditemukan.');
        }

        // Periksa apakah barang masih digunakan dalam transaksi sewa
        $adaTransaksi = DB::table('detail_sewa')
            ->where('id_barang', $id)
            ->exists();

        if ($adaTransaksi) {
            return redirect()
                ->route('barang.index')
                ->with('error', 'Barang tidak dapat dihapus karena sudah digunakan dalam transaksi sewa.');
        }

        // Hapus data barang
        DB::table('barang')
            ->where('id_barang', $id)
            ->delete();

        // Hapus gambar jika ada
        $pathGambar = public_path('gambar/' . $data->gambar);

        if ($data->gambar && file_exists($pathGambar)) {
            unlink($pathGambar);
        }

        return redirect()
            ->route('barang.index')
            ->with('success', 'Barang berhasil dihapus.');
    }
} 
