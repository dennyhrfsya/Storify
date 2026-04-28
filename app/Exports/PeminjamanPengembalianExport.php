<?php

namespace App\Exports;

use App\Models\Peminjaman;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Carbon\Carbon;

class PeminjamanPengembalianExport implements FromQuery, WithHeadings, WithMapping, ShouldAutoSize, WithCustomStartCell, WithEvents
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
        $search = $this->request->search;
        $dari_tanggal = $this->request->dari_tanggal;
        $sampai_tanggal = $this->request->sampai_tanggal;

        $query = Peminjaman::with(['aset', 'pengembalian']);

        // Jika tidak ada filter, return query kosong (sesuai diskusi kemarin)
        if (!$search && !$dari_tanggal && !$sampai_tanggal) {
            return $query->whereRaw('1 = 0');
        }

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('kode_peminjaman', 'LIKE', "%{$search}%")
                ->orWhere('user_aset', 'LIKE', "%{$search}%")
                ->orWhere('pt_user', 'LIKE', "%{$search}%")
                ->orWhereHas('aset', function($qAset) use ($search) {
                    $qAset->where('kode_barang', 'LIKE', "%{$search}%")
                            ->orWhere('nama_barang', 'LIKE', "%{$search}%");
                })
                ->orWhereHas('pengembalian', function($qKembali) use ($search) {
                    $qKembali->where('kode_pengembalian', 'LIKE', "%{$search}%");
                });
            });
        }

        // Filter Rentang Tanggal (Mencakup Peminjaman DAN Pengembalian)
        if ($dari_tanggal || $sampai_tanggal) {
            $query->where(function($q) use ($dari_tanggal, $sampai_tanggal) {
                // Kondisi untuk Tanggal Peminjaman
                $q->where(function($qPinjam) use ($dari_tanggal, $sampai_tanggal) {
                    if ($dari_tanggal && $sampai_tanggal) {
                        $qPinjam->whereBetween('tanggal_peminjaman', [$dari_tanggal, $sampai_tanggal]);
                    } elseif ($dari_tanggal) {
                        $qPinjam->where('tanggal_peminjaman', '>=', $dari_tanggal);
                    } elseif ($sampai_tanggal) {
                        $qPinjam->where('tanggal_peminjaman', '<=', $sampai_tanggal);
                    }
                })
                // ATAU Kondisi untuk Tanggal Pengembalian (melalui relasi)
                ->orWhereHas('pengembalian', function($qKembali) use ($dari_tanggal, $sampai_tanggal) {
                    if ($dari_tanggal && $sampai_tanggal) {
                        $qKembali->whereBetween('tanggal_pengembalian', [$dari_tanggal, $sampai_tanggal]);
                    } elseif ($dari_tanggal) {
                        $qKembali->where('tanggal_pengembalian', '>=', $dari_tanggal);
                    } elseif ($sampai_tanggal) {
                        $qKembali->where('tanggal_pengembalian', '<=', $sampai_tanggal);
                    }
                });
            });
        }

        return $query->latest('tanggal_peminjaman');
    }

    public function headings(): array
    {
        return [
            'No', 'No Peminjaman', 'No Pengembalian', 'Kode Barang', 'Nama Barang',
            'User','PT User', 'Departemen', 'Lokasi', 'Tanggal Pinjam / Serah Terima', 'Tanggal Kembali',
            'Status', 'Usage', 'Kondisi', 'Catatan'
        ];
    }

    private function getOrdinalUsage($urutan, $status)
    {
        if ($status == 'dibatalkan') {
            return 'Canceled';
        }

        if (!$urutan) {
            return 'No record';
        }

        $suffix = 'th';
        if ($urutan % 100 < 11 || $urutan % 100 > 13) {
            switch ($urutan % 10) {
                case 1: $suffix = 'st'; break;
                case 2: $suffix = 'nd'; break;
                case 3: $suffix = 'rd'; break;
            }
        }

        return $urutan . $suffix . ' usage';
    }

    public function map($peminjaman): array
    {
        $this->rowNumber++;
        $statusRaw = strtolower($peminjaman->status);
        $statusPeminjamanPengembalians = match ($statusRaw) {
            'dipinjam'     => 'Delivered',
            'dikembalikan' => 'Returned',
            'dibatalkan'   => 'Canceled',
            'permanen'     => 'Permanent',
            default        => ucfirst($statusRaw),
        };
        return [
            $this->rowNumber,
            $peminjaman->kode_peminjaman,
            $peminjaman->pengembalian?->kode_pengembalian ?? '-',
            $peminjaman->aset->kode_barang ?? '-',
            $peminjaman->aset->nama_barang ?? '-',
            $peminjaman->user_aset ?? '-',
            $peminjaman->pt_user ?? '-',
            $peminjaman->departemen ?? '-',
            $peminjaman->lokasi ?? '-',
            $peminjaman->tanggal_peminjaman ? $peminjaman->tanggal_peminjaman->format('d-m-Y') : '-',
            $peminjaman->pengembalian?->tanggal_pengembalian ? $peminjaman->pengembalian->tanggal_pengembalian->format('d-m-Y') : '-',
            $statusPeminjamanPengembalians,
            $this->getOrdinalUsage($peminjaman->urutan_pemakaian, $statusRaw),
            ucfirst(strtolower($peminjaman->pengembalian?->kondisi_pengembalian ?? '-')),
            $peminjaman->pengembalian->catatan ?? '-'
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $dari = $this->request->dari_tanggal ? Carbon::parse($this->request->dari_tanggal)->format('d-m-Y') : '-';
                $sampai = $this->request->sampai_tanggal ? Carbon::parse($this->request->sampai_tanggal)->format('d-m-Y') : '-';

                $event->sheet->mergeCells('A1:L1');
                $event->sheet->setCellValue('A1', 'LAPORAN PEMINJAMAN DAN PENGEMBALIAN ASET');

                $event->sheet->mergeCells('A2:L2');
                $event->sheet->setCellValue('A2', "Periode: $dari s/d $sampai");

                $styleHeader = [
                    'font' => ['bold' => true, 'size' => 14],
                    'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER],
                ];
                $event->sheet->getStyle('A1')->applyFromArray($styleHeader);
                $event->sheet->getStyle('A2')->getFont()->setBold(true);
                $event->sheet->getStyle('A2')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                $event->sheet->getStyle('A4:O4')->applyFromArray([
                    'font' => ['bold' => true],
                    'background' => [
                        'color' => ['rgb' => 'F8F9FA']
                    ]
                ]);
            },
        ];
    }
}
