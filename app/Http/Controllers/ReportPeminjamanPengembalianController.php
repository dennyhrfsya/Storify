<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use Illuminate\Http\Request;
use App\Exports\PeminjamanPengembalianExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportPeminjamanPengembalianController extends Controller
{
    public function index(Request $request)
    {
        $request->validate([
        'dari_tanggal'   => 'nullable|date',
        'sampai_tanggal' => 'nullable|date|after_or_equal:dari_tanggal',
        ], [
            'sampai_tanggal.after_or_equal' => 'Tanggal akhir tidak boleh lebih kecil dari Tanggal mulai',
        ]);

        $search = $request->input('search');
        $dari_tanggal = $request->input('dari_tanggal');
        $sampai_tanggal = $request->input('sampai_tanggal');

        $query = Peminjaman::with(['aset', 'pengembalian']);

        // CEK: Jika semua filter kosong, paksa query mengembalikan hasil kosong
        if (!$search && !$dari_tanggal && !$sampai_tanggal) {
            $query->whereRaw('1 = 0');
        } else {
            // Jalankan Filter jika ada input
            if ($search) {
                $query->where(function($q) use ($search) {
                    $q->where('kode_peminjaman', 'LIKE', "%{$search}%")
                    ->orWhere('user_aset', 'LIKE', "%{$search}%")
                    ->orWhereHas('aset', function($qAset) use ($search) {
                        $qAset->where('kode_barang', 'LIKE', "%{$search}%")
                                ->orWhere('nama_barang', 'LIKE', "%{$search}%");
                    })
                    ->orWhereHas('pengembalian', function($qKembali) use ($search) {
                        $qKembali->where('kode_pengembalian', 'LIKE', "%{$search}%");
                    });
                });
            }

            if ($dari_tanggal && $sampai_tanggal) {
                $query->whereBetween('tanggal_peminjaman', [$dari_tanggal, $sampai_tanggal]);
            } elseif ($dari_tanggal) {
                $query->where('tanggal_peminjaman', '>=', $dari_tanggal);
            } elseif ($sampai_tanggal) {
                $query->where('tanggal_peminjaman', '<=', $sampai_tanggal);
            }
        }

        $reportPeminjamanPengembalian = $query->latest('tanggal_peminjaman')
                                            ->paginate(10)
                                            ->withQueryString();

        return view('report.report-peminjaman-pengembalian', [
            'reportPeminjamanPengembalian' => $reportPeminjamanPengembalian,
            'filters' => $request->all()
        ]);
    }

    public function exportExcel(Request $request)
    {
        $nama_file = 'Laporan_Peminjaman_Pengembalian_' . date('Ymd_His') . '.xlsx';

        return Excel::download(new PeminjamanPengembalianExport($request), $nama_file);
    }

    public function exportPdf(Request $request)
    {
        ini_set('memory_limit', '256M');

        $search = $request->input('search');
        $dari_tanggal = $request->input('dari_tanggal');
        $sampai_tanggal = $request->input('sampai_tanggal');

        $query = Peminjaman::with(['aset', 'pengembalian']);

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('kode_peminjaman', 'LIKE', "%{$search}%")
                ->orWhere('user_aset', 'LIKE', "%{$search}%")
                ->orWhere('pt_user', 'LIKE', "%{$search}%")
                ->orWhereHas('aset', function($qAset) use ($search) {
                    $qAset->where('kode_barang', 'LIKE', "%{$search}%")
                            ->orWhere('nama_barang', 'LIKE', "%{$search}%");
                })
                ->orWhereHas('pengembalian', function($qK) use ($search) {
                    $qK->where('kode_pengembalian', 'LIKE', "%{$search}%");
                });
            });
        }

        if ($dari_tanggal && $sampai_tanggal) {
            $query->whereBetween('tanggal_peminjaman', [$dari_tanggal, $sampai_tanggal]);
        }

        $reportPeminjamanPengembalian = $query->latest('tanggal_peminjaman','asc')->get();

        $pdf = Pdf::loadView('report.report-peminjaman-pengembalian-pdf', compact('reportPeminjamanPengembalian', 'dari_tanggal', 'sampai_tanggal'))
                ->setPaper('a4', 'landscape')
                ->setOptions([
                    'isHtml5ParserEnabled' => true,
                    'isRemoteEnabled' => true
                ]);

        return $pdf->download('Laporan_Peminjaman_Pengembalian_'.date('Ymd_His').'.pdf');
    }
}
