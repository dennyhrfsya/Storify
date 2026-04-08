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
        // 1. Cari data peminjaman terlebih dahulu untuk referensi tanggal
        $peminjaman = Peminjaman::findOrFail($request->id_peminjaman);
        $aset = Aset::findOrFail($peminjaman->id_aset);

        $request->validate([
            'id_peminjaman' => 'required|exists:peminjaman,id',
            'tanggal_pengembalian' => [
                'required',
                'date',
                'after_or_equal:' . $peminjaman->tanggal_peminjaman,
            ],
            'foto_pengembalian' => [
                'nullable', 'file', 'mimes:jpg,jpeg,png,pdf',
                function ($attribute, $value, $fail) {
                    $extension = strtolower($value->getClientOriginalExtension());
                    $size = $value->getSize() / 1024;

                    if ($extension === 'pdf' && $size > 2048) {
                        $fail('Untuk file PDF, ukuran maksimal adalah 2MB.');
                    }
                    if (in_array($extension, ['jpg', 'jpeg', 'png']) && $size > 10240) {
                        $fail('Ukuran gambar maksimal 10MB untuk dikompres.');
                    }
                }
            ],
            'kondisi_pengembalian' => 'required|in:baik,rusak',
            'catatan' => 'nullable|string'
        ],[
            'foto_pengembalian.mimes' => 'Format file harus berupa JPEG, PNG, JPG, atau PDF.',
        ]);

        try {
            DB::beginTransaction();

            $peminjaman = Peminjaman::findOrFail($request->id_peminjaman);
            $aset = Aset::findOrFail($peminjaman->id_aset);

            // 1. LOGIKA KODE OTOMATIS (VERSI STABIL)
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

            // 2. Handle Upload File
            $filePath = null;
            if ($request->hasFile('foto_pengembalian')) {
                $file = $request->file('foto_pengembalian');
                $extension = strtolower($file->getClientOriginalExtension());
                $today = now()->format('Ymd');
                $filename = $today . '_' . $kodeKembaliOtomatis . '.' . $extension;

                // Jika Gambar dan ukuran > 2MB (2048 KB), lakukan kompresi
                if (in_array($extension, ['jpg', 'jpeg', 'png']) && $file->getSize() > 2048 * 1024) {

                    $destinationPath = storage_path('app/public/pengembalian/' . $filename);

                    // Pastikan folder tujuan ada
                    if (!file_exists(storage_path('app/public/pengembalian'))) {
                        mkdir(storage_path('app/public/pengembalian'), 0755, true);
                    }

                    // Gunakan fungsi helper kompresi yang sudah kita perbaiki tadi
                    $this->compressImage($file->getRealPath(), $destinationPath, $extension);
                    $filePath = 'pengembalian/' . $filename;
                } else {
                    // Simpan normal (untuk PDF atau gambar yang sudah kecil)
                    $filePath = $file->storeAs('pengembalian', $filename, 'public');
                }
            }

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
            return redirect()->back()
            ->withInput()
            ->with('error', 'Gagal: ' . $e->getMessage());
        }
    }

    public function detail(string $kode_pengembalian)
    {
        $pengembalian = Pengembalian::with(['peminjaman.aset'])
                        ->where('kode_pengembalian', $kode_pengembalian)
                        ->firstOrFail();

        return view('pengembalian.detail', compact('pengembalian'));
    }

    private function compressImage($source, $destination, $extension)
    {
        $info = getimagesize($source);
        $image = null;

        if ($info['mime'] == 'image/jpeg' || $info['mime'] == 'image/jpg') {
            $image = imagecreatefromjpeg($source);
        } elseif ($info['mime'] == 'image/png') {
            $image = imagecreatefrompng($source);
            $bg = imagecreatetruecolor(imagesx($image), imagesy($image));
            imagefill($bg, 0, 0, imagecolorallocate($bg, 255, 255, 255));
            imagecopy($bg, $image, 0, 0, 0, 0, imagesx($image), imagesy($image));
            $image = $bg;
        }

        if ($image) {
            imagejpeg($image, $destination, 60);
        }
    }
}
