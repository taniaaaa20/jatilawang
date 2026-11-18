<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class PegawaiController extends Controller
{
    private function cekPemilik()
    {
        if (session('role') !== 'pemilik') {
            return redirect()->route('login');
        }

        return null;
    }

    public function index()
    {
        if ($redirect = $this->cekPemilik()) {
            return $redirect;
        }

        // Urutkan pegawai berdasarkan ID
        $data_pegawai = Pegawai::orderBy('id_pegawai', 'asc')->get();

        return view('pemilik.pegawai.index', compact('data_pegawai'));
    }

    public function create()
    {
        if ($redirect = $this->cekPemilik()) {
            return $redirect;
        }

        return view('pemilik.pegawai.tambah');
    }

    public function store(Request $request)
    {
        if ($redirect = $this->cekPemilik()) {
            return $redirect;
        }

        // Validasi data tanpa meminta ID pegawai dari pengguna
        $request->validate([
            'nama_pegawai' => 'required|string|max:50',
            'noHP_pegawai' => 'required|string|max:15',
            'username' => 'required|string|max:30|unique:pegawai,username',
            'password' => 'required|string|min:8',
            'role' => 'required|in:pemilik,pegawai',
        ]);

        // Buat ID otomatis dan simpan dalam transaksi
        $pegawai = DB::transaction(function () use ($request) {
            // Kunci data yang ada agar pembuatan ID lebih aman
            $pegawaiTerakhir = Pegawai::where('id_pegawai', 'like', 'P%')
                ->orderByRaw('CAST(SUBSTRING(id_pegawai, 2) AS UNSIGNED) DESC')
                ->lockForUpdate()
                ->first();

            $nomorTerakhir = 0;

            if ($pegawaiTerakhir) {
                $nomorTerakhir = (int) substr($pegawaiTerakhir->id_pegawai, 1);
            }

            $nomorBaru = $nomorTerakhir + 1;
            $idBaru = 'P' . str_pad($nomorBaru, 3, '0', STR_PAD_LEFT);

            // Pastikan ID belum digunakan
            while (Pegawai::where('id_pegawai', $idBaru)->exists()) {
                $nomorBaru++;
                $idBaru = 'P' . str_pad($nomorBaru, 3, '0', STR_PAD_LEFT);
            }

            return Pegawai::create([
                'id_pegawai' => $idBaru,
                'nama_pegawai' => $request->nama_pegawai,
                'noHP_pegawai' => $request->noHP_pegawai,
                'username' => $request->username,
                'password' => Hash::make($request->password),
                'role' => $request->role,
            ]);
        });

        return redirect()->route('pemilik.pegawai.index')
            ->with('success', 'Pegawai berhasil ditambahkan dengan ID ' . $pegawai->id_pegawai . '.');
    }

    public function edit($id)
    {
        if ($redirect = $this->cekPemilik()) {
            return $redirect;
        }

        $pegawai = Pegawai::findOrFail($id);

        return view('pemilik.pegawai.edit', compact('pegawai'));
    }

    public function update(Request $request, $id)
    {
        if ($redirect = $this->cekPemilik()) {
            return $redirect;
        }

        $pegawai = Pegawai::findOrFail($id);

        $request->validate([
            'nama_pegawai' => 'required|string|max:50',
            'noHP_pegawai' => 'required|string|max:15',
            'username' => 'required|string|max:30|unique:pegawai,username,' . $id . ',id_pegawai',
            'password' => 'nullable|string|min:8',
            'role' => 'required|in:pemilik,pegawai',
        ]);

        $data = $request->only([
            'nama_pegawai',
            'noHP_pegawai',
            'username',
            'role',
        ]);

        // Ubah password hanya jika diisi
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $pegawai->update($data);

        return redirect()->route('pemilik.pegawai.index')
            ->with('success', 'Data pegawai berhasil diperbarui.');
    }

    public function destroy($id)
    {
        if ($redirect = $this->cekPemilik()) {
            return $redirect;
        }

        $pegawai = Pegawai::findOrFail($id);

        // Cegah pemilik menghapus akun yang sedang digunakan
        if ($pegawai->id_pegawai == session('id_pegawai')) {
            return redirect()->route('pemilik.pegawai.index')
                ->with('error', 'Akun yang sedang digunakan tidak dapat dihapus.');
        }

        $pegawai->delete();

        return redirect()->route('pemilik.pegawai.index')
            ->with('success', 'Data pegawai berhasil dihapus.');
    }
}
