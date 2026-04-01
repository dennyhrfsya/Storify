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
            'bukti_transaksi'   => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ],[
            'bukti_transaksi.mimes' => 'Format file harus berupa JPEG, PNG, JPG, atau PDF.',
            'bukti_transaksi.max'   => 'Ukuran file maksimal adalah 2MB.',
        ]);

        try {
            return DB::transaction(function () use ($request) {
                // Lock record barang untuk mencegah manipulasi stok secara bersamaan
                $stokBarang = StokBarang::lockForUpdate()->findOrFail($request->stok_barang_id);

                // 2. Cek kecukupan stok (Validasi Bisnis)
                if ($stokBarang->stok_saat_ini < $request->jumlah) {
                    throw new \Exception('Stok barang "' . $stokBarang->nama_barang . '" tidak mencukupi (Sisa: ' . $stokBarang->stok_saat_ini . ')');
                }

                // 3. Logika Histori Stok (Snapshoot sebelum dikurangi)
                $stokAwal  = $stokBarang->stok_saat_ini;
                $stokAkhir = $stokAwal - $request->jumlah;

                // 4. Generate Kode Transaksi Otomatis
                // Mengambil ID terakhir dari database
                $lastTransaksi = Transaksi::orderBy('id', 'desc')->first();
                $nextId = $lastTransaksi ? $lastTransaksi->id + 1 : 1;
                $kodeTrOtomatis = 'TR' . date('Ymd') . str_pad($nextId, 4, '0', STR_PAD_LEFT);

                if ($request->hasFile('bukti_transaksi')) {
                    $path = $request->file('bukti_transaksi')->store('bukti_transaksi', 'public');
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

        } catch (\Exception $e) {
            // Jika gagal, user tidak perlu ketik ulang berkat withInput()
            return back()->withInput()->with('error', 'Gagal menyimpan: ' . $e->getMessage());
        }
    }

    public function ubah($id)
    {
        $transaksi = Transaksi::findOrFail($id);
        $stokBarang = StokBarang::all();
        return view('transaksi.ubah', compact('transaksi', 'stokBarang'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'stok_barang_id' => 'required|exists:stok_barang,id',
            'jumlah'         => 'required|numeric|min:1',
            'status'         => 'required|in:dipinjamkan,diberikan,dibatalkan',
            'nama_user'      => 'required|string',
            'departemen'     => 'required|string',
            'tanggal_transaksi' => 'required|date',
            'bukti_transaksi'   => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ],[
            'bukti_transaksi.mimes' => 'Format file harus berupa JPEG, PNG, JPG, atau PDF.',
            'bukti_transaksi.max'   => 'Ukuran file maksimal adalah 2MB.',
        ]);

        try {
            return DB::transaction(function () use ($request, $id) {
                $transaksi = Transaksi::findOrFail($id);

                // 1. KEMBALIKAN STOK BARANG LAMA (REVERSE)
                $barangLama = StokBarang::lockForUpdate()->find($transaksi->stok_barang_id);
                if ($transaksi->status !== 'dibatalkan') {
                    $barangLama->increment('stok_saat_ini', $transaksi->jumlah);
                }

                // 2. AMBIL DATA BARANG BARU (Bisa jadi ID-nya tetap sama, bisa jadi beda)
                $barangBaru = StokBarang::lockForUpdate()->find($request->stok_barang_id);
                $statusBaru = strtolower($request->status);

                // 3. HITUNG HISTORI STOK BARU
                $stokAwalBaru  = $barangBaru->stok_saat_ini;
                $stokAkhirBaru = $stokAwalBaru;

                if ($statusBaru !== 'dibatalkan') {
                    // Cek ketersediaan stok pada barang baru
                    if ($barangBaru->stok_saat_ini < $request->jumlah) {
                        throw new \Exception("Stok tidak mencukupi! Barang '{$barangBaru->nama_barang}' tersedia: {$barangBaru->stok_saat_ini}");
                    }

                    $stokAkhirBaru = $stokAwalBaru - $request->jumlah;

                    // Kurangi stok barang baru
                    $barangBaru->decrement('stok_saat_ini', $request->jumlah);
                }

                // 2. Logika File (Upload baru & Hapus lama)
                $path = $transaksi->bukti_transaksi; // Default pakai yang lama

                if ($request->hasFile('bukti_transaksi')) {
                    // Hapus file lama jika ada di storage
                    if ($transaksi->bukti_transaksi && Storage::disk('public')->exists($transaksi->bukti_transaksi)) {
                        Storage::disk('public')->delete($transaksi->bukti_transaksi);
                    }

                    // Simpan file baru
                    $path = $request->file('bukti_transaksi')->store('bukti_transaksi', 'public');
                }

                // 4. UPDATE DATA TRANSAKSI
                $transaksi->update([
                    'stok_barang_id'    => $request->stok_barang_id,
                    'jumlah'            => $request->jumlah,
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
                    Storage::disk('public')->delete($transaksi->bukti_transaksi);
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
}
