<?php

namespace App\Http\Controllers;

use App\Models\StokBarang;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StokBarangController extends Controller
{
    public function index(Request $request)
    {
        $query = StokBarang::latest();

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function($q) use ($search) {
                $q->where('nama_barang', 'like', "%{$search}%")
                ->orWhere('kode_barang', 'like', "%{$search}%");
            });
        }

        $stoks = $query->paginate(10)->withQueryString();
        return view('stok_barang.index', compact('stoks'));
    }

    public function tambah()
    {
        $lastId = StokBarang::max('id') ?? 0;
        $kodeStokOtomatis = 'BRG-' . str_pad($lastId + 1, 4, '0', STR_PAD_LEFT);

        return view('stok_barang.tambah', compact('kodeStokOtomatis'));
    }

    public function simpan(Request $request)
    {
        if ($request->pt_pembeban === 'Lainnya') {
            $request->merge([
                'pt_pembeban' => trim($request->pt_pembeban_lainnya)
            ]);
        }

        if ($request->satuan === 'Lainnya') {
            $request->merge([
                'satuan' => trim($request->satuan_lainnya)
            ]);
        }

        $request->validate([
            // 'kode_barang'       => 'required|unique:stok_barang,kode_barang|max:50',
            'nama_barang'       => 'required|string|max:255',
            'tanggal_pembelian' => 'required|date',
            'pt_pembeban'       => 'required|string|max:100',
            'satuan'            => 'required|string|max:20',
            'stok_saat_ini'     => 'required|numeric|min:0',
            'harga_satuan'      => 'required|numeric|min:0',
        ]
        // ,[   'kode_barang.unique' => 'Kode barang sudah ada, gunakan kode lain.', ]
        );

        try {
            return DB::transaction(function () use ($request) {

            $lastId = StokBarang::max('id') ?? 0;
            $kodeStokOtomatis = 'BRG-' . str_pad($lastId + 1, 4, '0', STR_PAD_LEFT);

            // 1. Hitung Harga Total
            $stok = $request->stok_saat_ini;
            $hargaSatuan = $request->harga_satuan;
            $hargaTotal = $stok * $hargaSatuan;

            // 2. Simpan ke Database
            StokBarang::create([
                'kode_barang'       => $kodeStokOtomatis, // Hasil generate otomatis
                'nama_barang'       => $request->nama_barang,
                'tanggal_pembelian' => $request->tanggal_pembelian,
                'pt_pembeban'       => $request->pt_pembeban,
                'satuan'            => $request->satuan,
                'stok_saat_ini'     => $stok,
                'harga_satuan'      => $hargaSatuan,
                'harga_total'       => $hargaTotal,
            ]);

            return redirect()->route('stok.index')
                         ->with('success', 'Stok baru berhasil <strong>Ditambah</strong>');
            });

        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Gagal menambah stok: ' . $e->getMessage());
        }
    }

    public function ubah($id)
    {
        $stok = StokBarang::findOrFail($id);
        return view('stok_barang.ubah', compact('stok'));
    }

    public function update(Request $request, $id)
    {
        $stok = StokBarang::findOrFail($id);

        if ($request->pt_pembeban === 'Lainnya') {
            $request->merge(['pt_pembeban' => trim($request->pt_pembeban_lainnya)]);
        }

        if ($request->satuan === 'Lainnya') {
            $request->merge([
                'satuan' => trim($request->satuan_lainnya)
            ]);
        }

        $request->validate([
            'kode_barang'       => 'required|max:50|unique:stok_barang,kode_barang,' . $id,
            'nama_barang'       => 'required|string|max:255',
            'stok_saat_ini'     => 'required|numeric|min:0',
            'harga_satuan'      => 'required|numeric|min:0',
        ],[
            'kode_barang.unique' => 'Kode barang sudah ada, gunakan kode lain.',
        ]);

        try {
            return DB::transaction(function () use ($request, $stok) {
                // Kalkulasi Ulang
                $total = $request->stok_saat_ini * $request->harga_satuan;

                $stok->update([
                    'kode_barang'       => $request->kode_barang,
                    'nama_barang'       => $request->nama_barang,
                    'tanggal_pembelian' => $request->tanggal_pembelian,
                    'pt_pembeban'       => $request->pt_pembeban,
                    'satuan'            => $request->satuan,
                    'stok_saat_ini'     => $request->stok_saat_ini,
                    'harga_satuan'      => $request->harga_satuan,
                    'harga_total'       => $total,
                ]);

                return redirect()->route('stok.index')
                                ->with('success', 'Data stok berhasil <strong>Diubah</strong>');
            });
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Gagal mengubah data: ' . $e->getMessage());
        }
    }

    public function hapus($id)
    {
        $stok = StokBarang::findOrFail($id);
        // Cek apakah barang ini sudah pernah ada di transaksi
        $transaksi = Transaksi::where('stok_barang_id', $id)->exists();

        if ($transaksi) {
            return redirect()->route('stok.index')
                ->with('error', 'Barang <strong>' . $stok->nama_barang . '</strong> tidak bisa dihapus karena sudah memiliki riwayat transaksi.');
        }

        $stok->delete();

        return redirect()->route('stok.index')
                        ->with('success', 'Data stok berhasil <strong>Dihapus</strong>');
    }
}
