<?php

namespace App\Http\Controllers;

use App\Models\Aset;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PeminjamanController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');
        // Pastikan nama variabelnya adalah $peminjamans (pake 's' di belakang karena jamak)
        $peminjamans = Peminjaman::with('aset')
            ->when($search, function ($query) use ($search) {
                $query->where('kode_peminjaman', 'like', "%{$search}%")
                    ->orWhere('user_aset', 'like', "%{$search}%")
                    ->orWhereHas('aset', function ($q) use ($search) {
                        $q->where('kode_barang', 'like', "%{$search}%")
                            ->orWhere('nama_barang', 'like', "%{$search}%");
                    });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('peminjaman.index', compact('peminjamans'));
    }

    public function tambah()
    {
        $asets = Aset::where('status', 'tersedia')->get();
        $lastId = Peminjaman::max('id') ?? 0;
        $kodePinjamOtomatis = 'PJ' . date('Ymd') . '' . str_pad($lastId + 1, 4, '0', STR_PAD_LEFT);

        return view('peminjaman.tambah', compact('asets', 'kodePinjamOtomatis'));
    }

    public function simpan(Request $request)
    {
        if ($request->pt_user === 'Lainnya') {
            $request->merge([
                'pt_user' => trim($request->pt_user_lainnya)
            ]);
        }

        // 1. Validasi Input
        $request->validate([
            'id_aset' => 'required|exists:aset,id', // Pastikan ID aset ada di db
            'user_aset' => 'required|string',
            'pt_user' => 'required|string',
            'departemen' => 'required|string',
            'lokasi' => 'required|string',
            'tanggal_peminjaman' => 'required|date',
            'status' => 'required|in:dipinjam,permanen',
            'foto_peminjaman' => 'nullable|file|mimes:jpeg,png,jpg,pdf|max:2048',
        ],[
            'foto_peminjaman.mimes' => 'Format file harus berupa JPEG, PNG, JPG, atau PDF.',
            'foto_peminjaman.max' => 'Ukuran file maksimal adalah 2MB.',
        ]);

        // 2. Gunakan Transaction agar jika satu gagal, semua batal (Data Aman)
        return DB::transaction(function () use ($request) {

            // Cek kembali apakah aset masih tersedia (menghindari double input di waktu bersamaan)
            $aset = Aset::findOrFail($request->id_aset);
            if ($aset->status !== 'tersedia') {
                return redirect()->back()->with('error', 'Maaf, aset baru saja dipinjam orang lain');
            }

            // 3. Handle Upload Foto
            $fotoPath = null;
            if ($request->hasFile('foto_peminjaman')) {
                $fotoPath = $request->file('foto_peminjaman')->store('peminjaman', 'public');
            }

            // 4. Buat Record Peminjaman
            $peminjaman = Peminjaman::create([
                'kode_peminjaman' => $request->kode_peminjaman, // Dari input readonly di view
                'id_aset' => $request->id_aset,
                'user_aset' => $request->user_aset,
                'pt_user' => $request->pt_user,
                'departemen' => $request->departemen,
                'lokasi' => $request->lokasi,
                'tanggal_peminjaman' => $request->tanggal_peminjaman,
                'foto_peminjaman' => $fotoPath,
                'status' => $request->status,
            ]);

            // 5. SINKRONISASI: Update Tabel Aset
            $aset = Aset::findOrFail($request->id_aset);
            $aset->update([
                'status' => ($request->status == 'permanen' ? 'permanen' : 'dipinjam'),
                'user_aset' => $request->user_aset,    // Data dari input form
                'departemen' => $request->departemen, // Data dari input form
                'lokasi' => $request->lokasi          // Data dari input form
            ]);

            return redirect()->route('peminjaman.index')
                            ->with('success', 'Transaksi Peminjaman ' . $request->kode_peminjaman . ' </strong> berhasil <strong>Ditambah</strong>');
        });
    }

    public function detail(string $kode_peminjaman)
    {
        $peminjaman = Peminjaman::with('aset')
                    ->where('kode_peminjaman', $kode_peminjaman)
                    ->firstOrFail();

        return view('peminjaman.detail', compact('peminjaman'));
    }
}
