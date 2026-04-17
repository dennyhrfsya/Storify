<?php

namespace App\Http\Controllers;

use App\Models\Aset;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
                    ->orWhere('pt_user', 'like', "%{$search}%")
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
            'foto_peminjaman' => [
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
            'foto_peminjaman.mimes' => 'Format file harus berupa JPEG, PNG, JPG, atau PDF.',
        ]);

        // 2. Gunakan Transaction agar jika satu gagal, semua batal (Data Aman)
        return DB::transaction(function () use ($request) {

            // Cek kembali apakah aset masih tersedia (menghindari double input di waktu bersamaan)
            $aset = Aset::findOrFail($request->id_aset);
            if ($aset->status !== 'tersedia') {
                return redirect()->back()->with('error', 'Maaf, aset baru saja dipinjam orang lain');
            }

            // LOGIKA BARU: Jika barang rusak DAN user belum mencentang konfirmasi
            if ($aset->kondisi === 'rusak' && !$request->has('konfirmasi_rusak')) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', '
                        Kondisi aset ini sedang <strong>RUSAK</strong>. Apakah Anda yakin ingin tetap melanjutkan peminjaman?
                        <div class="mt-3">
                            <div class="position-relative dx-checkbox">
                                <input id="konfirmasi-rusak-check" type="checkbox" name="konfirmasi_rusak"
                                    onchange="document.getElementById(\'btn-submit-pmj\').disabled = !this.checked">
                                <label for="konfirmasi-rusak-check">
                                    Ya, saya menyadari kondisi aset rusak dan tetap ingin meminjam.
                                </label>
                            </div>
                        </div>
                    ');
            }

            // 3. Handle Upload & Kompresi Foto
            $filePath = null;
            if ($request->hasFile('foto_peminjaman')) {
                $file = $request->file('foto_peminjaman');
                $extension = strtolower($file->getClientOriginalExtension());
                $today = now()->format('Ymd');
                $filename = $today . '_' . $request->kode_peminjaman . '.' . $extension;

                // Logika: Jika Gambar dan ukuran > 2MB, maka kompres
                if (in_array($extension, ['jpg', 'jpeg', 'png']) && $file->getSize() > 2048 * 1024) {

                    $destinationPath = storage_path('app/public/peminjaman/' . $filename);

                    // Pastikan folder tujuan ada
                    if (!file_exists(storage_path('app/public/peminjaman'))) {
                        mkdir(storage_path('app/public/peminjaman'), 0755, true);
                    }

                    $this->compressImage($file->getRealPath(), $destinationPath, $extension);
                    $filePath = 'peminjaman/' . $filename;
                } else {
                    // Jika PDF atau gambar sudah kecil (< 2MB), simpan normal
                    $filePath = $file->storeAs('peminjaman', $filename, 'public');
                }
            }

            // Logika untuk penambahan total pemakaian
            $aset->increment('total_pemakaian');
            $pemakaianKe = $aset->total_pemakaian;

            // 4. Buat Record Peminjaman
            Peminjaman::create([
                'kode_peminjaman' => $request->kode_peminjaman, // Dari input readonly di view
                'id_aset' => $request->id_aset,
                'urutan_pemakaian' => $pemakaianKe,
                'user_aset' => $request->user_aset,
                'pt_user' => $request->pt_user,
                'departemen' => $request->departemen,
                'lokasi' => $request->lokasi,
                'tanggal_peminjaman' => $request->tanggal_peminjaman,
                'foto_peminjaman' => $filePath,
                'status' => $request->status,
            ]);

            // 5. SINKRONISASI: Update Tabel Aset
            $aset->update([
                'status' => ($request->status == 'permanen' ? 'permanen' : 'dipinjam'),
                'user_aset' => $request->user_aset,    // Data dari input form
                'departemen' => $request->departemen, // Data dari input form
                'lokasi' => $request->lokasi          // Data dari input form
            ]);

            return redirect()->route('peminjaman.index')
                            ->with('success', 'Transaksi Peminjaman <strong>' . $request->kode_peminjaman . ' </strong> berhasil <strong>Ditambah</strong>.');
        });
    }

    public function detail(string $kode_peminjaman)
    {
        $peminjaman = Peminjaman::with('aset')
                    ->where('kode_peminjaman', $kode_peminjaman)
                    ->firstOrFail();

        return view('peminjaman.detail', compact('peminjaman'));
    }

    public function batalkanPeminjaman($id)
    {
        // 1. Cari data peminjaman
        $peminjaman = Peminjaman::findOrFail($id);

        try {
            DB::transaction(function () use ($peminjaman) {
                // 2. Rollback counter di Tabel Aset
                $aset = Aset::find($peminjaman->id_aset);
                if ($aset) {
                    // Kurangi total pemakaian hanya jika lebih dari 0
                    if ($aset->total_pemakaian > 0) {
                        $aset->decrement('total_pemakaian');
                    }

                    // Kosongkan detail pemegang di Aset agar statusnya "Fresh"
                    $aset->update([
                        'user_aset'  => null,
                        'departemen' => null,
                        'lokasi'     => null,
                        'status'     => 'tersedia'
                    ]);
                }

               // 3. Update Tabel PEMINJAMAN (DATA TETAP ADA)
                $peminjaman->update([
                    'status' => 'dibatalkan',
                    // Kita biarkan user_aset, departemen, dll TETAP ISI untuk audit
                    // urutan_pemakaian kita set NULL agar bisa dideteksi "Canceled" di View
                    'urutan_pemakaian' => null,
                ]);
            });

            return redirect()->back()->with('success', '<strong>Peminjaman</strong> dibatalkan. Data aset dan peminjaman telah dibersihkan.');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan sistem saat sinkronisasi data.');
        }
    }

    /**
     * Helper: Kompresi Gambar PHP 8+
     */
    private function compressImage($source, $destination, $extension)
    {
        $info = getimagesize($source);
        $image = null;

        if ($info['mime'] == 'image/jpeg' || $info['mime'] == 'image/jpg') {
            $image = imagecreatefromjpeg($source);
        } elseif ($info['mime'] == 'image/png') {
            $image = imagecreatefrompng($source);

            // Membuat canvas baru dengan ukuran yang sama
            $bg = imagecreatetruecolor(imagesx($image), imagesy($image));

            // Memberi warna latar belakang putih (mencegah bagian transparan jadi hitam)
            imagefill($bg, 0, 0, imagecolorallocate($bg, 255, 255, 255));

            // Copy gambar asli ke canvas baru (menggunakan variabel $bg yang benar)
            imagecopy($bg, $image, 0, 0, 0, 0, imagesx($image), imagesy($image));

            // Simpan hasilnya ke variabel $image untuk diproses imagejpeg
            $image = $bg;
        }

        if ($image) {
            // Simpan dengan kualitas 60 (Output otomatis menjadi format .jpg)
            imagejpeg($image, $destination, 60);
        }
    }
}
