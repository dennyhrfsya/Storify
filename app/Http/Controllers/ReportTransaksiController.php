<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use Illuminate\Http\Request;
use App\Exports\TransaksiExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportTransaksiController extends Controller
{
   public function index(Request $request)
    {
        $request->validate([
        'dari_tanggal'   => 'nullable|date',
        'sampai_tanggal' => 'nullable|date|after_or_equal:dari_tanggal',
        ], [
            'sampai_tanggal.after_or_equal' => 'Tanggal akhir tidak boleh lebih kecil dari Tanggal mulai.',
        ]);

        $search = $request->query('search');
        $dari_tanggal = $request->input('dari_tanggal');
        $sampai_tanggal = $request->input('sampai_tanggal');

        $query = Transaksi::with('stokBarang');

        // LOGIKA: Sembunyikan data jika tidak ada filter (Pencarian atau Tanggal)
        if (!$search && !$dari_tanggal && !$sampai_tanggal) {
            $query->whereRaw('1 = 0');
        } else {
            // 1. Filter Pencarian (Multi-kolom)
            if ($search) {
                $query->where(function($q) use ($search) {
                    $q->where('kode_transaksi', 'like', "%{$search}%")
                    ->orWhereHas('stokBarang', function($sub) use ($search) {
                        $sub->where('kode_barang', 'like', "%{$search}%")
                            ->orWhere('nama_barang', 'like', "%{$search}%");
                    });
                });
            }

            // 2. Filter Tanggal
            if ($dari_tanggal && $sampai_tanggal) {
                $query->whereBetween('tanggal_transaksi', [$dari_tanggal, $sampai_tanggal]);
            } elseif ($dari_tanggal) {
                $query->whereDate('tanggal_transaksi', '>=', $dari_tanggal);
            } elseif ($sampai_tanggal) {
                $query->whereDate('tanggal_transaksi', '<=', $sampai_tanggal);
            }
        }

        $reportTransaksis = $query->latest('tanggal_transaksi')
                            ->paginate(10)
                            ->withQueryString();

        return view('report.report-transaksi', compact('reportTransaksis'));
    }

    public function exportExcel(Request $request)
    {
        $namaFile = 'Laporan_Transaksi_' . now()->format('Ymd_His') . '.xlsx';
        return Excel::download(new TransaksiExport($request), $namaFile);
    }

    public function exportPdf(Request $request)
    {
        // 1. Tambahkan limit memori untuk berjaga-jaga jika data banyak
        ini_set('memory_limit', '256M');

        $search         = $request->query('search');
        $dari_tanggal   = $request->query('dari_tanggal');
        $sampai_tanggal = $request->query('sampai_tanggal');

        $query = Transaksi::with('stokBarang');

        // Filter Pencarian (Multi-kolom)
        $query->when($search, function ($query) use ($search) {
            $query->where(function($q) use ($search) {
                $q->where('kode_transaksi', 'like', "%{$search}%")
                ->orWhereHas('stokBarang', function($sub) use ($search) {
                    $sub->where('kode_barang', 'like', "%{$search}%")
                        ->orWhere('nama_barang', 'like', "%{$search}%");
                });
            });
        });

        // Filter Tanggal
        $query->when($dari_tanggal, function ($query) use ($dari_tanggal) {
            $query->whereDate('tanggal_transaksi', '>=', $dari_tanggal);
        });

        $query->when($sampai_tanggal, function ($query) use ($sampai_tanggal) {
            $query->whereDate('tanggal_transaksi', '<=', $sampai_tanggal);
        });

        $reportTransaksis = $query->orderBy('tanggal_transaksi','asc')->get();

        // 2. Load View dengan mengirimkan data report dan variabel filter tanggal untuk heading PDF
        $pdf = Pdf::loadView('report.report-transaksi-pdf', [
            'reportTransaksis' => $reportTransaksis,
            'dari_tanggal'     => $dari_tanggal,
            'sampai_tanggal'   => $sampai_tanggal,
        ])
        ->setPaper('a4', 'landscape')
        ->setOptions([
            'isHtml5ParserEnabled' => true,
            'isRemoteEnabled'      => true
        ]);

        return $pdf->download('Laporan_Transaksi_' . date('Ymd_His') . '.pdf');
    }
}
