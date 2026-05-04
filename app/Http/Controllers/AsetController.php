<?php

namespace App\Http\Controllers;

use App\Models\Aset;
use App\Exports\AsetExport;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AsetController extends Controller
{
    public function index(Request $request)
    {
        // Membuat query awal untuk model Aset, diurutkan berdasarkan data terbaru (created_at desc)
        $query = Aset::latest();

        // Jika request memiliki parameter 'search' yang terisi
        if ($request->filled('search')) {
            $search = $request->search;

            // Tambahkan kondisi pencarian ke query
            $query->where(function($q) use ($search) {
                // Cari berdasarkan nama_barang yang mirip dengan keyword
                $q->where('nama_barang', 'like', "%{$search}%")
                // Atau cari berdasarkan kode_barang
                ->orWhere('kode_barang', 'like', "%{$search}%")
                // Atau cari berdasarkan kategori
                ->orWhere('kategori', 'like' , "%{$search}%")
                // Atau cari berdasarkan pt_pembeban
                ->orWhere('pt_pembeban', 'like', "%{$search}%")
                ->orWhere('user_aset', 'like' , "%{$search}%");
            });
        }

        // Fitur Filter Status (Kondisi)
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Eksekusi query dengan pagination, tampilkan 5 data per halaman
        $asets = $query->paginate(10)->withQueryString();

        // Kirim data hasil query ke view 'aset.index'
        return view('aset.index', compact('asets'));
    }

    // public function tambah()
    // {
    //     // Tampilkan view tambah data aset
    //     return view('aset.tambah');
    // }
    public function tambah()
    {
        $tahun = date('Y');

        // Cari aset terakhir di tahun ini untuk menentukan nomor urut
        $lastAset = \App\Models\Aset::whereYear('created_at', $tahun)
                    ->orderBy('id', 'desc')
                    ->first();

        if ($lastAset) {
            $parts = explode('/', $lastAset->kode_barang);
            $lastNumber = (int) end($parts);
            $nextNumber = str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);
        } else {
            $nextNumber = '001';
        }

        // Kirim data ke view
        return view('aset.tambah', compact('nextNumber', 'tahun'));
    }


    public function simpan(Request $request)
    {
        // dd($request->all());

        // 1. Logika Penggabungan Input Manual "Lainnya"
        // 1. Untuk Kategori
        if ($request->kategori === 'Lainnya') {
            $request->merge([
                'kategori' => trim($request->kategori_lainnya)
            ]);
        }

        // 2. Untuk PT Pembeban
        if ($request->pt_pembeban === 'Lainnya') {
            $request->merge([
                'pt_pembeban' => trim($request->pt_pembeban_lainnya)
            ]);
        }

        // Validasi data yang dikirim dari form
        $validated = $request->validate([
            'kode_barang' => 'required|string|max:50|unique:aset,kode_barang', // wajib unik
            'nama_barang' => 'required|string|max:255',
            'kategori' => 'required|string|max:100',
            'merk' => 'nullable|string|max:150',
            'nomor_seri' => 'nullable|string|max:100',
            'tanggal_pembelian' => 'nullable|date',
            'tanggal_garansi' => 'nullable|date',
            'kuantitas' => 'nullable|integer|min:0',
            'harga' => 'nullable|numeric|min:0',
            'pt_pembeban' => 'required|string|max:150',
            'user_aset' => 'nullable|string|max:150',
            'departemen' => 'nullable|string|max:255',
            'lokasi' => 'nullable|string|max:255',
            'grade_barang' => 'required|string|max:100',
            'kondisi' => 'required|in:baik,rusak',
            'keterangan' => 'nullable|string',
            'status' => 'required|in:tersedia,tertunda',
            'upload_bukti_aset' => [
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
            // Pesan error custom
            'kode_barang.unique' => 'Kode barang sudah ada, gunakan kode lain.',
            'upload_bukti_aset.mimes' => 'Format file harus berupa JPEG, PNG, JPG, atau PDF.',
        ]);

        // Jika ada file bukti tanda terima diupload
        if ($request->hasFile('upload_bukti_aset')) {
            $file = $request->file('upload_bukti_aset');
            $extension = strtolower($file->getClientOriginalExtension());
            $today = now()->format('Ymd');
            $generateKodeAset = str_replace('/', '_', $request->kode_barang);

            $filename = $today . '_' . $generateKodeAset . '.' . $extension;

            if (in_array($extension, ['jpg', 'jpeg', 'png']) && $file->getSize() > 2048 * 1024) {
                // Jalankan Kompresi
                $destinationPath = storage_path('app/public/upload_bukti_aset/' . $filename);

                if (!file_exists(storage_path('app/public/upload_bukti_aset'))) {
                    mkdir(storage_path('app/public/upload_bukti_aset'), 0755, true);
                }

                $this->compressImage($file->getRealPath(), $destinationPath, $extension);
                $validated['upload_bukti_aset'] = 'upload_bukti_aset/' . $filename;
            } else {
                // Simpan Normal (PDF atau Gambar < 2MB)
                $path = $file->storeAs('upload_bukti_aset', $filename, 'public');
                $validated['upload_bukti_aset'] = $path;
            }
        }

        // Simpan data aset baru ke database
        Aset::create($validated);

        // Cek model setelah create
        // $aset = Aset::create($validated);
        // dd($aset);

        // Redirect ke halaman index aset dengan pesan sukses
        return redirect()->route('aset.index')
                        ->with('success', 'Aset baru berhasil <strong>Ditambah</strong>');
    }

    public function detail(string $id)
    {
        // Cari data aset berdasarkan ID, jika tidak ditemukan akan throw 404
        $aset = Aset::findOrFail($id);

        // Jika aset memiliki tanggal garansi
        if ($aset->tanggal_garansi) {
            // Ubah tanggal garansi ke objek Carbon
            $garansiDate = Carbon::parse($aset->tanggal_garansi);

            // Ambil tanggal hari ini
            $today = Carbon::today();

            // Jika tanggal garansi sudah lewat
            if ($garansiDate->isPast()) {
                $aset->garansi_status = "Garansi sudah habis";
                $aset->garansi_sisa = null;
            } else {
                // Hitung sisa hari antara hari ini dan tanggal garansi
                $sisaHari = $today->diffInDays($garansiDate);

                // Jika sisa hari kurang dari atau sama dengan 30 → masa tenggang
                if ($sisaHari <= 30) {
                    $aset->garansi_status = "Masa tenggang garansi";
                    $aset->garansi_sisa = $sisaHari . " hari tersisa";
                } else {
                    // Jika lebih dari 30 hari → garansi aktif
                    $aset->garansi_status = "Garansi aktif";
                    $aset->garansi_sisa = $sisaHari . " hari tersisa";
                }
            }
        } else {
            // Jika tidak ada tanggal garansi
            $aset->garansi_status = "Tidak ada garansi";
            $aset->garansi_sisa = null;
        }

        // Kirim data aset ke view detail
        return view('aset.detail', compact('aset'));
    }

    public function ubah(string $id)
    {
        // Cari data aset berdasarkan ID, jika tidak ditemukan akan throw 404
        $aset = Aset::findOrFail($id);

        // Kirim data aset ke view ubah
        return view('aset.ubah', compact('aset'));
    }

    public function update(Request $request, string $id)
    {
        // dd($request->all());
        // Cari data aset berdasarkan ID, jika tidak ditemukan akan throw 404
        $aset = Aset::findOrFail($id);

        if ($request->kategori === 'Lainnya') {
        $request->merge(['kategori' => trim($request->kategori_lainnya)]);
        }

        if ($request->pt_pembeban === 'Lainnya') {
            $request->merge(['pt_pembeban' => trim($request->pt_pembeban_lainnya)]);
        }

        // Validasi data yang dikirim dari form edit
        $validated = $request->validate([
            'kode_barang' => 'required|string|max:50|unique:aset,kode_barang,' . $id, // wajib unik, kecuali untuk aset yang sedang diupdate
            'nama_barang' => 'required|string|max:255',
            'kategori' => 'required|string|max:100',
            'merk' => 'nullable|string|max:150',
            'nomor_seri' => 'nullable|string|max:100',
            'tanggal_pembelian' => 'nullable|date',
            'tanggal_garansi' => 'nullable|date',
            'kuantitas' => 'nullable|integer|min:0',
            'harga' => 'nullable|numeric',
            'pt_pembeban' => 'nullable|string|max:150',
            'user_aset' => 'nullable|string|max:150',
            'departemen' => 'nullable|string|max:255',
            'lokasi' => 'nullable|string|max:255',
            'grade_barang' => 'required|string|max:100',
            'kondisi' => 'required|in:baik,rusak',
            'keterangan' => 'nullable|string',
            'status' => 'required|in:tersedia,dipinjam,permanen,tertunda',
            'upload_bukti_aset' => [
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
            // Pesan error custom
            'kode_barang.unique' => 'Kode barang sudah ada, gunakan kode lain.',
            'upload_bukti_aset.mimes' => 'Format file harus berupa JPEG, PNG, JPG, atau PDF.',
        ]);

        if ($request->hasFile('upload_bukti_aset')) {
            $file = $request->file('upload_bukti_aset');
            $extension = strtolower($file->getClientOriginalExtension());
            $today = now()->format('Ymd'); // Menggunakan format YYYYMMDD
            $generateKodeAset = str_replace('/', '_', $request->kode_barang);

            // Nama file menggunakan $today sesuai request kamu
            $filename = $today . '_' . $generateKodeAset . '.' . $extension;
            $relativeFolder = 'upload_bukti_aset';
            $fullFolderPath = storage_path('app/public/' . $relativeFolder);
            $destinationPath = $fullFolderPath . '/' . $filename;

            // 1. PENTING: Pastikan folder 'upload_bukti_aset' ada secara fisik
            if (!file_exists($fullFolderPath)) {
                mkdir($fullFolderPath, 0755, true);
            }

            // 2. Hapus file lama di database & storage agar tidak menumpuk sampah data
            if ($aset->upload_bukti_aset && Storage::disk('public')->exists($aset->upload_bukti_aset)) {
                Storage::disk('public')->delete($aset->upload_bukti_aset);
            }

            // 3. Proses Simpan (Kompres jika gambar besar, Simpan Normal jika PDF/Gambar kecil)
            if (in_array($extension, ['jpg', 'jpeg', 'png']) && $file->getSize() > 2048 * 1024) {
                // Jalankan fungsi compress (Sekarang aman karena folder sudah dipastikan ada di atas)
                $this->compressImage($file->getRealPath(), $destinationPath, $extension);
            } else {
                // Simpan file asli (Timpa jika nama filenya sama persis)
                $file->storeAs($relativeFolder, $filename, 'public');
            }

            // Simpan path relatif ke database
            $validated['upload_bukti_aset'] = $relativeFolder . '/' . $filename;
        }

        // Update data aset dengan data yang sudah divalidasi
        $aset->update($validated);

        // Redirect ke halaman index aset dengan pesan sukses
        return redirect()->route('aset.index', $aset->id)
                        ->with('success', 'Aset berhasil <strong>Diubah</strong>');
    }

    public function hapus(string $id)
    {
        // 1. Cari aset beserta hitung jumlah relasinya di tabel peminjaman
        // Pastikan nama relasi di model Aset adalah 'peminjaman'
        $aset = Aset::withCount('peminjaman')->findOrFail($id);

        // 2. CEK RELASI: Jika aset ini punya riwayat di tabel peminjaman
        if ($aset->peminjaman_count > 0) {
            return redirect()->back()->with('error',
                'Aset <strong>' . $aset->nama_barang . '</strong> tidak bisa dihapus karena masih memiliki riwayat peminjaman'
            );
        }

        // 3. Jika lolos pengecekan (tidak ada relasi), baru hapus file fisik
        if ($aset->upload_bukti_aset) {
            if (Storage::disk('public')->exists($aset->upload_bukti_aset)) {
                Storage::disk('public')->delete($aset->upload_bukti_aset);
            }
        }

        // 4. Hapus data dari database
        $aset->delete();

        return redirect()->back()->with('success', 'Aset berhasil <strong>Dihapus</strong>');
    }

    public function exportExcel(Request $request)
    {
        $nama_file = 'Laporan_Data_Aset_' . date('Ymd_His') . '.xlsx';
        return Excel::download(new AsetExport($request->all()), $nama_file);
    }

    private function compressImage($source, $destination, $extension)
    {
        $info = getimagesize($source);
        $image = null;

        // Pastikan folder tujuan ada sebelum proses simpan (Jaga-jaring pengaman)
        $directory = dirname($destination);
        if (!file_exists($directory)) {
            mkdir($directory, 0775, true);
        }

        // Hapus file lama jika ada agar benar-benar bersih (Overwrite logic)
        if (file_exists($destination)) {
            unlink($destination);
        }

        if ($info['mime'] == 'image/jpeg' || $info['mime'] == 'image/jpg') {
            $image = imagecreatefromjpeg($source);
        } elseif ($info['mime'] == 'image/png') {
            $pngImage = imagecreatefrompng($source);

            // Membuat canvas putih untuk menggantikan transparansi PNG saat dikonversi ke JPG
            $image = imagecreatetruecolor(imagesx($pngImage), imagesy($pngImage));
            $white = imagecolorallocate($image, 255, 255, 255);
            imagefill($image, 0, 0, $white);
            imagecopy($image, $pngImage, 0, 0, 0, 0, imagesx($pngImage), imagesy($pngImage));
        }

        if ($image) {
            // Simpan sebagai JPEG dengan kualitas 60% untuk kompresi
            imagejpeg($image, $destination, 60);
            // imagedestroy($image); // Opsional di PHP 8.0+, silakan hapus jika sudah upgrade
        }
    }
}
