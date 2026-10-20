<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (session()->has('pegawai')) {
            return $this->redirectDashboard(session('role'));
        }

        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $pegawai = DB::table('pegawai')
            ->where('username', $request->username)
            ->first();

        if (
            !$pegawai ||
            $pegawai->password !== $request->password
        ) {
            return back()
                ->withInput($request->only('username'))
                ->with('error', 'Username atau password salah.');
        }

        $role = strtolower($pegawai->role);

        if (!in_array($role, ['pemilik', 'pegawai'])) {
            return back()
                ->withInput($request->only('username'))
                ->with('error', 'Role akun tidak valid.');
        }

        $request->session()->regenerate();

        $request->session()->put([
            'pegawai' => $pegawai->id_pegawai,
            'nama_pegawai' => $pegawai->nama_pegawai,
            'role' => $role,
        ]);

        return $this->redirectDashboard($role);
    }

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

    public function logout(Request $request)
    {
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
