<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Menampilkan halaman login
    public function showLogin()
    {
        if (session()->has('pegawai')) {
            return $this->redirectDashboard(session('role'));
        }

        return view('auth.login');
    }

    // Proses login pegawai
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        // Mencari pegawai berdasarkan username
        $pegawai = DB::table('pegawai')
            ->where('username', $request->username)
            ->first();

        // Memeriksa username dan password
        if (
            !$pegawai ||
            !Hash::check($request->password, $pegawai->password)
        ) {
            return back()
                ->withInput($request->only('username'))
                ->with('error', 'Username atau password salah.');
        }

        // Memeriksa role
        $role = strtolower($pegawai->role);

        if (!in_array($role, ['pemilik', 'pegawai'])) {
            return back()
                ->withInput($request->only('username'))
                ->with('error', 'Role akun tidak valid.');
        }

        // Membuat session baru setelah login berhasil
        $request->session()->regenerate();

        $request->session()->put([
            'pegawai' => $pegawai->id_pegawai,
            'nama_pegawai' => $pegawai->nama_pegawai,
            'role' => $role,
        ]);

        // Mengarahkan pengguna ke dashboard sesuai role
        return $this->redirectDashboard($role);
    }

    // Redirect berdasarkan role
    private function redirectDashboard($role)
    {
        if ($role === 'pemilik') {
            return redirect()->route('pemilik.dashboard');
        }

        if ($role === 'pegawai') {
            return redirect()->route('pegawai.dashboard');
        }

        return redirect()->route('login');
    }

    // Proses logout
    public function logout(Request $request)
    {
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
