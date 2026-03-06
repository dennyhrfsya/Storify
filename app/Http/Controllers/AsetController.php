<?php

namespace App\Http\Controllers;

use App\Models\Aset;
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
                ->orWhere('pt_pembeban', 'like', "%{$search}%");
            });
        }

        // Eksekusi query dengan pagination, tampilkan 5 data per halaman
        $asets = $query->paginate(5);

        // Kirim data hasil query ke view 'aset.index'
        return view('aset.index', compact('asets'));
    }

    public function tambah()
    {
        // Tampilkan view tambah data aset
        return view('aset.tambah');
    }

    public function simpan(Request $request)
    {
        // dd($request->all());

        // Jika request memiliki input 'harga_display'
        if($request->has('harga_display')){
            // Bersihkan input harga_display dari karakter non-numeric (misalnya titik, koma, Rp)
            $harga_bersih = preg_replace('/[^0-9]/', '', $request->harga_display);

            // Gabungkan hasil bersih ke dalam request sebagai field 'harga'
            $request->merge(['harga' => $harga_bersih]);
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
            'user_aset' => 'required|string|max:150',
            'lokasi' => 'nullable|string|max:255',
            'kondisi' => 'required|in:Baik,Rusak',
            'keterangan' => 'nullable|string',
            'status' => 'required|in:Tersedia,Dipinjam',
            'bukti_tanda_terima' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ],[
            // Pesan error custom
            'kode_barang.unique' => 'Kode barang sudah terdaftar oleh aset lain.',
            'kode_barang.required' => 'Kode barang tidak boleh kosong.',
        ]);

        // Jika ada file bukti tanda terima diupload
        if ($request->hasFile('bukti_tanda_terima')) {
            // Simpan file ke folder 'bukti_tanda_terima' di storage/public
            $path = $request->file('bukti_tanda_terima')->store('bukti_tanda_terima', 'public');

            // Masukkan path file ke dalam data yang divalidasi
            $validated['bukti_tanda_terima'] = $path;
        }

        // Simpan data aset baru ke database
        Aset::create($validated);

        // Cek model setelah create
        // $aset = Aset::create($validated);
        // dd($aset);

        // Redirect ke halaman index aset dengan pesan sukses
        return redirect()->route('aset.index')
                        ->with('success', 'Aset baru berhasil di <strong>Tambah</strong>');
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

        // Validasi data yang dikirim dari form edit
        $validated = $request->validate([
            'kode_barang' => 'required|string|max:50|unique:aset,kode_barang,' . $id, // wajib unik, kecuali untuk aset yang sedang diupdate
            'nama_barang' => 'required|string|max:255',
            'kategori' => 'required|string|max:100',
            'merk' => 'nullable|string|max:150',
            'nomor_seri' => 'nullable|string|max:100',
            'tanggal_pembelian' => 'required|date',
            'tanggal_garansi' => 'nullable|date',
            'kuantitas' => 'nullable|integer|min:0',
            'harga' => 'required|numeric',
            'pt_pembeban' => 'nullable|string|max:150',
            'user_aset' => 'nullable|string|max:150',
            'lokasi' => 'nullable|string|max:255',
            'kondisi' => 'required|in:Baik,Rusak',
            'keterangan' => 'nullable|string',
            'status' => 'required|in:Tersedia,Dipinjam',
            'bukti_tanda_terima' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ],[
            // Pesan error custom
            'kode_barang.unique' => 'Kode barang sudah terdaftar oleh aset lain.',
            'kode_barang.required' => 'Kode barang tidak boleh kosong.',
        ]);

        // Jika ada file bukti tanda terima diupload
        if ($request->hasFile('bukti_tanda_terima')) {
            // Simpan file ke folder 'bukti' di storage/public
            $path = $request->file('bukti_tanda_terima')->store('bukti_tanda_terima', 'public');

            // Masukkan path file ke dalam data yang divalidasi
            $validated['bukti_tanda_terima'] = $path;
        }

        // Update data aset dengan data yang sudah divalidasi
        $aset->update($validated);

        // Redirect ke halaman index aset dengan pesan sukses
        return redirect()->route('aset.index', $aset->id)
                        ->with('success', 'Data aset berhasil di <strong>Ubah</strong>');
    }

    public function hapus(string $id)
    {
        // Cari data aset berdasarkan ID, jika tidak ditemukan akan throw 404
        $aset = Aset::findOrFail($id);

        // Jika aset memiliki file bukti tanda terima, hapus dari storage
        if ($aset->bukti_tanda_terima) {
            Storage::disk('public')->delete($aset->bukti_tanda_terima);
        }

        // Hapus data aset dari database
        $aset->delete();

        // Redirect kembali ke halaman sebelumnya dengan pesan sukses
        return redirect()->back()->with('success', 'Data aset berhasil di <strong>Hapus</strong>');
    }
}
