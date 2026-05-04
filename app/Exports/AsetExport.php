<?php

namespace App\Exports;

use App\Models\Aset;
use Carbon\Carbon; // Pastikan import Carbon
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class AsetExport implements FromQuery, WithHeadings, WithMapping, WithStyles
{
    protected $request;
    private $rowNumber = 0;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function query()
    {
        $query = Aset::query()->latest();

        if (!empty($this->request['search'])) {
            $search = $this->request['search'];
            $query->where(function($q) use ($search) {
                $q->where('nama_barang', 'like', "%{$search}%")
                  ->orWhere('kode_barang', 'like', "%{$search}%")
                  ->orWhere('kategori', 'like' , "%{$search}%")
                  ->orWhere('pt_pembeban', 'like', "%{$search}%")
                  ->orWhere('user_aset', 'like', "%{$search}%");
            });
        }

        if (!empty($this->request['status'])) {
            $query->where('status', $this->request['status']);
        }

        return $query;
    }

    public function headings(): array
    {
        return [
            'No', 'Kode Barang', 'Nama Barang', 'Total Pemakaian', 'Kategori',
            'Nomor Seri', 'Tanggal Pembelian', 'Tanggal Garansi', 'Status Garansi',
            'Quantity', 'Harga', 'PT Pembeban', 'User', 'Departemen', 'Lokasi',
            'Grade Barang', 'Kondisi', 'Status', 'Keterangan'
        ];
    }

    public function map($aset): array
    {
        $this->rowNumber++;

        // --- LOGIKA GARANSI (DIPINDAHKAN KE SINI) ---
        $garansiStatus = "Tidak ada garansi";
        $garansiSisa = "";

        if ($aset->tanggal_garansi) {
            $garansiDate = Carbon::parse($aset->tanggal_garansi);
            $today = Carbon::today();

            if ($garansiDate->isPast()) {
                $garansiStatus = "Garansi sudah habis";
            } else {
                $sisaHari = $today->diffInDays($garansiDate);
                if ($sisaHari <= 30) {
                    $garansiStatus = "Masa tenggang garansi";
                    $garansiSisa = " ($sisaHari hari tersisa)";
                } else {
                    $garansiStatus = "Garansi aktif";
                    $garansiSisa = " ($sisaHari hari tersisa)";
                }
            }
        }

        // Logika Label Status Inventori
        $statusLabel = 'Available';
        if ($aset->status == 'dipinjam') { $statusLabel = 'Delivered'; }
        elseif ($aset->status == 'tertunda') { $statusLabel = 'Pending'; }
        elseif ($aset->status == 'permanen') { $statusLabel = 'Permanent'; }

        return [
            $this->rowNumber,
            $aset->kode_barang,
            $aset->nama_barang,
            $aset->total_pemakaian > 0 ? $aset->total_pemakaian . ' times used' : 'Unused',
            $aset->kategori,
            $aset->nomor_seri ?? '-',
            $aset->tanggal_pembelian ? Carbon::parse($aset->tanggal_pembelian)->format('d-m-Y') : '-',
            $aset->tanggal_garansi ? Carbon::parse($aset->tanggal_garansi)->format('d-m-Y') : '-',
            $garansiStatus . $garansiSisa,
            $aset->kuantitas,
            'Rp. ' . number_format($aset->harga, 0, ',', '.'),
            $aset->pt_pembeban,
            $aset->user_aset ?? '-',
            $aset->departemen ?? '-',
            $aset->lokasi ?? '-',
            ucfirst($aset->grade_barang),
            ucfirst($aset->kondisi),
            $statusLabel,
            $aset->keterangan ?? '-'
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [1 => ['font' => ['bold' => true]]];
    }
}
