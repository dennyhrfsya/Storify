<?php

namespace App\Exports;

use App\Models\Transaksi;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Carbon\Carbon;

class TransaksiExport implements FromQuery, WithHeadings, WithMapping, ShouldAutoSize, WithCustomStartCell, WithEvents
{
    protected $request;
    private $rowNumber = 0;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function startCell(): string
    {
        return 'A4';
    }

    public function query()
    {
        $search         = $this->request->query('search');
        $dari_tanggal   = $this->request->query('dari_tanggal');
        $sampai_tanggal = $this->request->query('sampai_tanggal');

        if (!$search && !$dari_tanggal && !$sampai_tanggal) {
            return Transaksi::query()->whereRaw('1 = 0');
        }

        return Transaksi::query()->with('stokBarang')
            ->when($search, function ($query) use ($search) {
                $query->where(function($q) use ($search) {
                    $q->where('kode_transaksi', 'like', "%{$search}%")
                      ->orWhereHas('stokBarang', function($sub) use ($search) {
                          $sub->where('kode_barang', 'like', "%{$search}%")
                            ->orWhere('nama_barang', 'like', "%{$search}%");
                      });
                });
            })
            ->when($dari_tanggal, function ($query) use ($dari_tanggal) {
                $query->whereDate('tanggal_transaksi', '>=', $dari_tanggal);
            })
            ->when($sampai_tanggal, function ($query) use ($sampai_tanggal) {
                $query->whereDate('tanggal_transaksi', '<=', $sampai_tanggal);
            })
            ->latest('tanggal_transaksi');
    }

    public function headings(): array
    {
        return [
            'No',
            'Kode Transaksi',
            'Nama Barang',
            'User',
            'Departemen',
            'Tanggal',
            'Status',
            'Stok Awal',
            'Keluar',
            'Stok Akhir'
        ];
    }

    public function map($transaksi): array
    {
        $this->rowNumber++;
        return [
            $this->rowNumber,
            $transaksi->kode_transaksi,
            $transaksi->stokBarang->nama_barang,
            $transaksi->nama_user,
            $transaksi->departemen,
            $transaksi->tanggal_transaksi->format('d-m-Y'),
            ucfirst(strtolower($transaksi->status)),
            $transaksi->stok_awal ?? 0,
            $transaksi->jumlah,
            $transaksi->stok_akhir ?? 0,
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $dari = $this->request->query('dari_tanggal') ? Carbon::parse($this->request->query('dari_tanggal'))->format('d-m-Y') : '-';
                $sampai = $this->request->query('sampai_tanggal') ? Carbon::parse($this->request->query('sampai_tanggal'))->format('d-m-Y') : '-';

                $event->sheet->mergeCells('A1:J1');
                $event->sheet->setCellValue('A1', 'LAPORAN TRANSAKSI BARANG');

                $event->sheet->mergeCells('A2:J2');
                $event->sheet->setCellValue('A2', "Periode: $dari s/d $sampai");

                $styleHeader = [
                    'font' => ['bold' => true, 'size' => 14],
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER
                    ],
                ];

                $event->sheet->getStyle('A1')->applyFromArray($styleHeader);
                $event->sheet->getStyle('A2')->getFont()->setBold(true);
                $event->sheet->getStyle('A2')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                $event->sheet->getStyle('A4:J4')->applyFromArray([
                    'font' => ['bold' => true],
                    'background' => [
                        'color' => ['rgb' => 'F8F9FA']
                    ]
                ]);
            },
        ];
    }
}
