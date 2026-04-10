<?php

namespace App\Http\Controllers;

use App\Models\StokBarang;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class TransaksiController extends Controller
{

    public function index(Request $request)
    {
        $search = $request->query('search');

        $transaksis = Transaksi::with('stokBarang')
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('kode_transaksi', 'like', "%{$search}%")
                    ->orWhere('status', 'like', "%{$search}%");
                })
                ->orWhereHas('stokBarang', function ($q) use ($search) {
                    $q->where('nama_barang', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('transaksi.index', compact('transaksis'));
    }

    public function tambah()
    {
        $stokBarang = StokBarang::where('stok_saat_ini', '>', 0)->get();

        $lastId = Transaksi::max('id') ?? 0;
        $kodeTrOtomatis = 'TR' . date('Ymd') . '' . str_pad($lastId + 1, 4, '0', STR_PAD_LEFT);

        return view('transaksi.tambah', compact('stokBarang', 'kodeTrOtomatis'));
    }

    public function simpan(Request $request)
    {
        // 1. Validasi Input Dasar
        $request->validate([
            'stok_barang_id'    => 'required|exists:stok_barang,id',
            'tanggal_transaksi' => 'required|date',
            'jumlah'            => 'required|numeric|min:1',
            'nama_user'         => 'required|string|max:255',
            'departemen'        => 'required|string|max:100',
            'status'            => 'required|in:dipinjamkan,diberikan',
            'bukti_transaksi' => [
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
        ],[
            'bukti_transaksi.mimes' => 'Format file harus berupa JPEG, PNG, JPG, atau PDF.',
        ]);

        try {
            return DB::transaction(function () use ($request) {
                // Lock record barang untuk mencegah manipulasi stok secara bersamaan
                $stokBarang = StokBarang::lockForUpdate()->findOrFail($request->stok_barang_id);

                // 2. Cek kecukupan stok (Validasi Bisnis)
                // Validasi Stok
                if ($stokBarang->stok_saat_ini < $request->jumlah) {
                    // Gunakan ValidationException agar error muncul di bawah input 'jumlah'
                    throw \Illuminate\Validation\ValidationException::withMessages([
                        'jumlah' => "Stok tidak mencukupi! Sisa stok: {$stokBarang->stok_saat_ini}"
                    ]);
                }

                // 3. Logika Histori Stok (Snapshoot sebelum dikurangi)
                $stokAwal  = $stokBarang->stok_saat_ini;
                $stokAkhir = $stokAwal - $request->jumlah;

                // 4. Generate Kode Transaksi Otomatis
                // Mengambil ID terakhir dari database
                $lastTransaksi = Transaksi::orderBy('id', 'desc')->first();
                $nextId = $lastTransaksi ? $lastTransaksi->id + 1 : 1;
                $kodeTrOtomatis = 'TR' . date('Ymd') . str_pad($nextId, 4, '0', STR_PAD_LEFT);

                $path = null;
                // 2. Cek apakah ada file yang diunggah
                if ($request->hasFile('bukti_transaksi')) {
                    $file = $request->file('bukti_transaksi');
                    $extension = strtolower($file->getClientOriginalExtension());
                    $today = now()->format('Ymd');
                    $filename = $today . '_' . $kodeTrOtomatis . '.' . $extension;
                    $folderPath = 'bukti_transaksi';

                    if (in_array($extension, ['jpg', 'jpeg', 'png']) && $file->getSize() > 2048 * 1024) {
                        // Jalankan Kompresi
                        $destinationPath = storage_path('app/public/' . $folderPath . '/' . $filename);

                        if (!file_exists(storage_path('app/public/' . $folderPath))) {
                            mkdir(storage_path('app/public/' . $folderPath), 0755, true);
                        }

                        $this->compressImage($file->getRealPath(), $destinationPath, $extension);
                        $path = $folderPath . '/' . $filename; // Isi path jika kompres
                    } else {
                        // Simpan Normal
                        $path = $file->storeAs($folderPath, $filename, 'public'); // Isi path jika simpan biasa
                    }
                }

                // 5. Simpan Transaksi
                Transaksi::create([
                    'kode_transaksi'    => $kodeTrOtomatis,
                    'stok_barang_id'    => $request->stok_barang_id,
                    'nama_user'         => $request->nama_user,
                    'departemen'        => $request->departemen,
                    'jumlah'            => $request->jumlah,
                    'stok_awal'         => $stokAwal,
                    'stok_akhir'        => $stokAkhir,
                    'status'            => strtolower($request->status), // Pastikan lowercase
                    'tanggal_transaksi' => $request->tanggal_transaksi,
                    'bukti_transaksi'   => $path
                ]);

                // 6. Update Stok Master
                $stokBarang->decrement('stok_saat_ini', $request->jumlah);

                return redirect()->route('transaksi.index')
                                ->with('success', 'Transaksi <strong>' . $kodeTrOtomatis . '</strong> berhasil di <strong>Tambah</strong>');
            });

        } catch (\Illuminate\Validation\ValidationException $e) {
            throw $e; // Lempar balik ke Laravel untuk ditangani otomatis
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Gagal: ' . $e->getMessage());
        }
    }

    public function ubah($id)
    {
        $transaksi = Transaksi::findOrFail($id);
        $stokBarang = StokBarang::all();
        return view('transaksi.ubah', compact('transaksi', 'stokBarang'));
    }

    // public function update(Request $request, $id)
    // {
    //     $request->validate([
    //         'stok_barang_id' => 'required|exists:stok_barang,id',
    //         'jumlah'         => 'required|numeric|min:1',
    //         'status'         => 'required|in:dipinjamkan,diberikan,dibatalkan',
    //         'nama_user'      => 'required|string',
    //         'departemen'     => 'required|string',
    //         'tanggal_transaksi' => 'required|date',
    //         'bukti_transaksi' => [
    //             'nullable', 'file', 'mimes:jpg,jpeg,png,pdf',
    //             function ($attribute, $value, $fail) {
    //                 $extension = strtolower($value->getClientOriginalExtension());
    //                 $size = $value->getSize() / 1024;

    //                 if ($extension === 'pdf' && $size > 2048) {
    //                     $fail('Untuk file PDF, ukuran maksimal adalah 2MB.');
    //                 }
    //                 if (in_array($extension, ['jpg', 'jpeg', 'png']) && $size > 10240) {
    //                     $fail('Ukuran gambar maksimal 10MB untuk dikompres.');
    //                 }
    //             }
    //         ],
    //     ],[
    //         'bukti_transaksi.mimes' => 'Format file harus berupa JPEG, PNG, JPG, atau PDF.',
    //     ]);

    //     try {
    //         return DB::transaction(function () use ($request, $id) {
    //             $transaksi = Transaksi::findOrFail($id);

    //             // Supaya kalau tidak upload file baru, data lama tidak hilang/error
    //             $path = $transaksi->bukti_transaksi;

    //             // 1. KEMBALIKAN STOK BARANG LAMA (REVERSE)
    //             $barangLama = StokBarang::lockForUpdate()->find($transaksi->stok_barang_id);
    //             if ($transaksi->status !== 'dibatalkan') {
    //                 $barangLama->increment('stok_saat_ini', $transaksi->jumlah);
    //             }

    //             // 2. AMBIL DATA BARANG BARU (Bisa jadi ID-nya tetap sama, bisa jadi beda)
    //             $barangBaru = StokBarang::lockForUpdate()->find($request->stok_barang_id);
    //             $statusBaru = strtolower($request->status);

    //             // 3. HITUNG HISTORI STOK BARU
    //             $stokAwalBaru  = $barangBaru->stok_saat_ini;
    //             $stokAkhirBaru = $stokAwalBaru;

    //             if ($statusBaru !== 'dibatalkan') {
    //                 // Cek ketersediaan stok pada barang baru
    //                 if ($barangBaru->stok_saat_ini < $request->jumlah) {
    //                     throw new \Exception("Stok tidak mencukupi! Barang '{$barangBaru->nama_barang}' tersedia: {$barangBaru->stok_saat_ini}");
    //                 }

    //                 $stokAkhirBaru = $stokAwalBaru - $request->jumlah;

    //                 // Kurangi stok barang baru
    //                 $barangBaru->decrement('stok_saat_ini', $request->jumlah);
    //             }

    //             // 2. Logika File (Upload baru & Hapus lama)
    //             if ($request->hasFile('bukti_transaksi')) {
    //                 if ($transaksi->bukti_transaksi && Storage::disk('public')->exists($transaksi->bukti_transaksi)) {
    //                     Storage::disk('public')->delete($transaksi->bukti_transaksi);
    //                 }

    //                 $file = $request->file('bukti_transaksi');
    //                 $extension = strtolower($file->getClientOriginalExtension());
    //                 $filename = now()->format('Ymd') . '_' . $transaksi->kode_transaksi . '.' . $extension;
    //                 $folderPath = 'bukti_transaksi';

    //                 if (in_array($extension, ['jpg', 'jpeg', 'png']) && $file->getSize() > 2048 * 1024) {
    //                     if (!Storage::disk('public')->exists($folderPath)) {
    //                         Storage::disk('public')->makeDirectory($folderPath);
    //                     }

    //                     $destinationPath = storage_path('app/public/' . $folderPath . '/' . $filename);
    //                     $this->compressImage($file->getRealPath(), $destinationPath, $extension);
    //                     $path = $folderPath . '/' . $filename;
    //                 } else {
    //                     $path = $file->storeAs($folderPath, $filename, 'public');
    //                 }
    //             }

    //             // 4. UPDATE DATA TRANSAKSI
    //             $transaksi->update([
    //                 'stok_barang_id'    => $request->stok_barang_id,
    //                 'jumlah'            => $request->jumlah,
    //                 'status'            => $statusBaru,
    //                 'nama_user'         => $request->nama_user,
    //                 'departemen'        => $request->departemen,
    //                 'tanggal_transaksi' => $request->tanggal_transaksi,
    //                 'stok_awal'         => $stokAwalBaru,
    //                 'stok_akhir'        => $stokAkhirBaru,
    //                 'bukti_transaksi'   => $path
    //             ]);

    //             return redirect()->route('transaksi.index')
    //                 ->with('success', 'Transaksi <strong>'.$transaksi->kode_transaksi.'</strong> berhasil di <strong>Ubah</strong>');
    //         });
    //     } catch (\Throwable $e) {
    //         return back()->withInput()->with('error','Gagal mengubah: ' . $e->getMessage());
    //     }
    // }

    public function update(Request $request, $id)
    {
        $request->validate([
            'stok_barang_id' => 'required|exists:stok_barang,id',
            'jumlah'         => 'required|numeric|min:1',
            'status'         => 'required|in:dipinjamkan,diberikan,dibatalkan',
            'nama_user'      => 'required|string',
            'departemen'     => 'required|string',
            'tanggal_transaksi' => 'required|date',
            'bukti_transaksi' => [
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
        ],[
            'bukti_transaksi.mimes' => 'Format file harus berupa JPEG, PNG, JPG, atau PDF.',
        ]);

        try {
            return DB::transaction(function () use ($request, $id) {
                $transaksi = Transaksi::findOrFail($id);

                // Simpan status dan data lama sebelum diupdate
                $statusLama = strtolower($transaksi->status);
                $jumlahLama = $transaksi->jumlah;
                $barangIdLama = $transaksi->stok_barang_id;

                $statusBaru = strtolower($request->status);
                $jumlahBaru = $request->jumlah;
                $barangIdBaru = $request->stok_barang_id;

                // 1. REVERSE STOK (KONDISIONAL)
                // Kita hanya mengembalikan stok jika status lama BUKAN dibatalkan
                if ($statusLama !== 'dibatalkan') {
                    $barangLama = StokBarang::lockForUpdate()->find($barangIdLama);
                    $barangLama->increment('stok_saat_ini', $jumlahLama);
                    $barangLama->refresh();
                }

                // 2. AMBIL DATA BARANG BARU (Untuk hitung stok setelah reverse)
                $barangSekarang = StokBarang::lockForUpdate()->find($barangIdBaru);

                $stokAwalBaru  = $barangSekarang->stok_saat_ini;
                $stokAkhirBaru = $stokAwalBaru;

                // 3. POTONG STOK JIKA STATUS BARU AKTIF
                if ($statusBaru !== 'dibatalkan') {
                    if ($barangSekarang->stok_saat_ini < $jumlahBaru) {
                        throw new \Exception("Stok tidak mencukupi! Tersedia: {$barangSekarang->stok_saat_ini}");
                    }

                    $barangSekarang->decrement('stok_saat_ini', $jumlahBaru);
                    $stokAkhirBaru = $stokAwalBaru - $jumlahBaru;
                }

                // 4. LOGIKA FILE (Tetap sama seperti kode kamu)
                $path = $transaksi->bukti_transaksi;
                if ($request->hasFile('bukti_transaksi')) {
                    if ($transaksi->bukti_transaksi && Storage::disk('public')->exists($transaksi->bukti_transaksi)) {
                        Storage::disk('public')->delete($transaksi->bukti_transaksi);
                    }

                    $file = $request->file('bukti_transaksi');
                    $extension = strtolower($file->getClientOriginalExtension());
                    $filename = now()->format('Ymd') . '_' . $transaksi->kode_transaksi . '.' . $extension;
                    $folderPath = 'bukti_transaksi';

                    if (in_array($extension, ['jpg', 'jpeg', 'png']) && $file->getSize() > 2048 * 1024) {
                        if (!Storage::disk('public')->exists($folderPath)) {
                            Storage::disk('public')->makeDirectory($folderPath);
                        }

                        $destinationPath = storage_path('app/public/' . $folderPath . '/' . $filename);
                        $this->compressImage($file->getRealPath(), $destinationPath, $extension);
                        $path = $folderPath . '/' . $filename;
                    } else {
                        $path = $file->storeAs($folderPath, $filename, 'public');
                    }
                }

                // 5. UPDATE DATA TRANSAKSI
                $transaksi->update([
                    'stok_barang_id'    => $barangIdBaru,
                    'jumlah'            => $jumlahBaru,
                    'status'            => $statusBaru,
                    'nama_user'         => $request->nama_user,
                    'departemen'        => $request->departemen,
                    'tanggal_transaksi' => $request->tanggal_transaksi,
                    'stok_awal'         => $stokAwalBaru,
                    'stok_akhir'        => $stokAkhirBaru,
                    'bukti_transaksi'   => $path
                ]);

                return redirect()->route('transaksi.index')
                    ->with('success', 'Transaksi <strong>'.$transaksi->kode_transaksi.'</strong> berhasil di <strong>Ubah</strong>');
            });
        } catch (\Throwable $e) {
            return back()->withInput()->with('error','Gagal mengubah: ' . $e->getMessage());
        }
    }

    public function hapus($id)
    {
        try {
            return DB::transaction(function () use ($id) {
                $transaksi = Transaksi::findOrFail($id);

                if ($transaksi->bukti_transaksi) {
                    if (Storage::disk('public')->exists($transaksi->bukti_transaksi)) {
                        Storage::disk('public')->delete($transaksi->bukti_transaksi);
                    }
                }

                // Ambil data stok barang dan kunci row-nya (Lock)
                $stokBarang = StokBarang::lockForUpdate()->find($transaksi->stok_barang_id);

                // --- LANGKAH 1: KEMBALIKAN STOK KE MASTER ---
                $status = strtolower($transaksi->status);
                if ($status === 'dipinjamkan' || $status === 'diberikan') {
                    if ($stokBarang) {
                        $stokBarang->increment('stok_saat_ini', $transaksi->jumlah);
                    }
                }

                // --- LANGKAH 2: HAPUS DATA TRANSAKSI ---
                $transaksi->delete();

                return redirect()->route('transaksi.index')
                                ->with('success', 'Transaksi berhasil di<strong>Hapus</strong> dan stok telah dikembalikan');
            });
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menghapus : ' . $e->getMessage());
        }
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
