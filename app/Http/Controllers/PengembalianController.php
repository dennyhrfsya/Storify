<?php

namespace App\Http\Controllers;

use App\Models\Aset;
use App\Models\Peminjaman;
use App\Models\Pengembalian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PengembalianController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');

        $pengembalians = Pengembalian::with(['peminjaman.aset'])
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    // Cari berdasarkan kode pengembalian (jika ada kolomnya)
                    $q->where('kode_pengembalian', 'like', "%{$search}%")
                    // Mencari ke tabel peminjaman
                    ->orWhereHas('peminjaman', function ($subP) use ($search) {
                        $subP->where('user_aset', 'like', "%{$search}%")
                            // Mencari lebih dalam lagi ke tabel aset
                            ->orWhereHas('aset', function ($subA) use ($search) {
                                $subA->where('nama_barang', 'like', "%{$search}%")
                                        ->orWhere('kode_barang', 'like', "%{$search}%");
                            });
                    });
                });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('pengembalian.index', compact('pengembalians'));
    }

    public function simpan(Request $request)
    {
        $request->validate([
            'id_peminjaman' => 'required|exists:peminjaman,id',
            'tanggal_pengembalian' => 'required|date',
            'foto_pengembalian' => 'nullable|file|mimes:jpg,png,jpeg,pdf|max:5120',
            'kondisi_pengembalian' => 'required|in:baik,rusak',
            'catatan' => 'nullable|string'
        ],[
            'foto_pengembalian.mimes' => 'Format file harus berupa JPEG, PNG, JPG, atau PDF.',
            'foto_pengembalian.max' => 'Ukuran file maksimal adalah 2MB.',
        ]);

        try {
            DB::beginTransaction();

            $peminjaman = Peminjaman::findOrFail($request->id_peminjaman);
            $aset = Aset::findOrFail($peminjaman->id_aset);

            // 1. Handle Upload File
            $filePath = null;
            if ($request->hasFile('foto_pengembalian')) {
                $filePath = $request->file('foto_pengembalian')->store('pengembalian', 'public');
            }

            // 2. LOGIKA KODE OTOMATIS (VERSI STABIL)
            $today = now()->format('Ymd');

            // Cari kode pengembalian terakhir yang berawalan KMB + Tanggal hari ini
            // Kita gunakan LIKE agar tidak bergantung pada isi kolom tanggal_pengembalian
            $lastReturn = Pengembalian::where('kode_pengembalian', 'LIKE', "KMB{$today}%")
                            ->latest('id')
                            ->first();

            if ($lastReturn) {
                // Ambil 3 angka terakhir
                $lastNumber = (int) substr($lastReturn->kode_pengembalian, -3);
                $nextNumber = str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);
            } else {
                $nextNumber = '001';
            }

            $kodeKembaliOtomatis = 'KMB' . $today . $nextNumber;

            // 3. Simpan ke tabel pengembalian
            Pengembalian::create([
                'id_peminjaman' => $peminjaman->id,
                'kode_pengembalian' => $kodeKembaliOtomatis,
                'tanggal_pengembalian' => $request->tanggal_pengembalian,
                'foto_pengembalian' => $filePath,
                'kondisi_pengembalian' => $request->kondisi_pengembalian,
                'catatan' => $request->catatan,
            ]);

            // 4. Update status peminjaman
            $peminjaman->update(['status' => 'dikembalikan']);

            // 5. Update data aset
            $aset->update([
                'status' => 'tersedia',
                'kondisi' => $request->kondisi_pengembalian,
                'user_aset' => null,
                'departemen' => null,
                'lokasi' => 'Gudang'
            ]);

            DB::commit();

            // PENTING: Redirect ke halaman index pengembalian agar terlihat datanya
            return redirect()->route('pengembalian.index')->with('success', 'Aset berhasil <strong>Dikembalikan</strong>');

        } catch (\Exception $e) {
            DB::rollBack();
            // Gunakan dd($e->getMessage()) jika masih gagal untuk melihat error aslinya
            return redirect()->back()->with('error', 'Gagal: ' . $e->getMessage());
        }
    }

    public function detail(string $kode_pengembalian)
    {
        $pengembalian = Pengembalian::with(['peminjaman.aset'])
                        ->where('kode_pengembalian', $kode_pengembalian)
                        ->firstOrFail();

        return view('pengembalian.detail', compact('pengembalian'));
    }
}
