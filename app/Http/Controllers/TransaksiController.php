<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    public function index()
    {
        // Menggunakan with('stokBarang') agar tidak terjadi N+1 query problem
        $transaksi = Transaksi::with('stokBarang')->latest()->get();
        return view('transaksi.index', compact('transaksi'));
    }
}
