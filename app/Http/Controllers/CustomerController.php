<?php

namespace App\Http\Controllers;

use App\Models\Barang;

class CustomerController extends Controller
{
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
}
