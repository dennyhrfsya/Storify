<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Aset;

class DashboardController extends Controller
{
    public function index()
    {
        // Hitung jumlah total
        $totalUsers = User::count();
        $totalAsets = Aset::count();

        // Kirim data ke view
        return view('dashboard.index', compact('totalUsers', 'totalAsets'));
    }
}
