<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Aset;
use App\Models\Peminjaman;
use App\Models\Pengembalian;

class DashboardController extends Controller
{
    public function index()
    {
        // Hitung jumlah total
        $totalUsers = User::count();
        $totalAsets = Aset::count();
        $totalPeminjamans = Peminjaman::count();
        $totalPengembalians = Pengembalian::count();

        // Kirim data ke view
        return view('dashboard.index', compact('totalUsers', 'totalAsets', 'totalPeminjamans', 'totalPengembalians'));
    }
}
