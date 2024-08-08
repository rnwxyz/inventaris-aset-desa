<?php

namespace App\Exports;

use App\Models\KendaraanBermotorModel;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\PageSetup;

class KendaraanBermotorExport implements FromCollection, WithMapping, WithHeadings, ShouldAutoSize, WithEvents, WithColumnWidths
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        // return data with row number
        return KendaraanBermotorModel::all()->map(function ($kendaraanBermotor, $key) {
            $kendaraanBermotor->no = $key + 1;
            return $kendaraanBermotor;
        });
    }

    public function headings(): array
    {
        return [
            ['LAPORAN HASIL INVENTASI ASET DESA'],
            ['BERUPA KENDARAAN BERMOTOR'],
            [''],
            [
                'No',
                'Nama Barang',
                'Kode Barang',
                'NUP',
                'Merk',
                'Tahun Perolehan',
                'Nilai Perolehan',
                'Kode Barang',
                '',
                '',
                'Keterangan'
            ],
            [
                '', '', '', '', '', '', '', 'B', 'RR', 'RB', ''
            ]
        ];
    }

    public function map($kendaraanBermotor): array
    {
        return [
            $kendaraanBermotor->no,
            $kendaraanBermotor->nama_barang,
            $kendaraanBermotor->kode_barang,
            $kendaraanBermotor->nup,
            $kendaraanBermotor->merk,
            $kendaraanBermotor->tahun_perolehan,
            // format rupiah
            $kendaraanBermotor->nilai_perolehan ? 'Rp ' . number_format($kendaraanBermotor->nilai_perolehan, 0, ',', '.') : '',
            $kendaraanBermotor->b ? '✓' : '',
            $kendaraanBermotor->rr ? '✓' : '',
            $kendaraanBermotor->rb ? '✓' : '',
            $kendaraanBermotor->keterangan
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                $sheet->getParent()->getDefaultStyle()->getFont()->setSize(10);
                $sheet->mergeCells('A1:K1');
                $sheet->mergeCells('A2:K2');
                $sheet->getStyle('A1:K2')->applyFromArray([
                    'font' => [
                        'bold' => true
                    ],
                    'alignment' => [
                        'horizontal' => 'center'
                    ]
                ]);
                $sheet->mergeCells('H4:J4');
                $sheet->mergeCells('A4:A5');
                $sheet->mergeCells('B4:B5');
                $sheet->mergeCells('C4:C5');
                $sheet->mergeCells('D4:D5');
                $sheet->mergeCells('E4:E5');
                $sheet->mergeCells('F4:F5');
                $sheet->mergeCells('G4:G5');
                $sheet->mergeCells('K4:K5');
                $sheet->getStyle('A4:K5')->applyFromArray([
                    'font' => [
                        'bold' => true
                    ],
                    'alignment' => [
                        'horizontal' => 'center',
                        'vertical' => 'center',
                        'wrapText' => true
                    ],
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => 'thin'
                        ]
                    ]
                ]);

                KendaraanBermotorModel::all()->map(function ($kendaraanBermotor, $key) use ($sheet) {
                    $row = $key + 6;
                    $sheet->getStyle('A' . $row . ':K' . $row)->applyFromArray([
                        'borders' => [
                            'allBorders' => [
                                'borderStyle' => 'thin'
                            ],
                        ],
                        'wrapText' => true,
                        'wrap' => true,
                        'alignment' => [
                            'horizontal' => 'left',
                            'vertical' => 'top',
                            'wrapText' => true
                        ]
                    ]);
                    $sheet->getStyle('A' . $row . ':A' . $row)->applyFromArray([
                        'alignment' => [
                            'horizontal' => 'center',
                        ]
                    ]);
                    $sheet->getStyle('C' . $row . ':C' . $row)->applyFromArray([
                        'alignment' => [
                            'horizontal' => 'left',
                        ]
                    ]);
                    $sheet->getStyle('H' . $row . ':J' . $row)->applyFromArray([
                        'alignment' => [
                            'horizontal' => 'center',
                        ]
                    ]);
                });

                // Set the paper size
                $sheet->getPageSetup()->setPaperSize(PageSetup::PAPERSIZE_A4);

                // Set the orientation to landscape
                $sheet->getPageSetup()->setOrientation(PageSetup::ORIENTATION_LANDSCAPE);

                $users = KendaraanBermotorModel::all();
                $row = $users->count() + 6;

                // Add signature
                // Sekretaris Desa
                $sheet->mergeCells('A' . ($row + 2) . ':c' . ($row + 2))->setCellValue('A' . ($row + 2), 'SEKRETARIS DESA');
                $sheet->mergeCells('A' . ($row + 3) . ':c' . ($row + 3))->setCellValue('A' . ($row + 3), 'SELAKU PEMBANTU PENGELOLA ASET DESA');
                $sheet->mergeCells('A' . ($row + 8) . ':c' . ($row + 8))->setCellValue('A' . ($row + 8), env('SEKRETARIS_NAME'));

                // Pengelola
                // bulan bahasa indonesia
                $bulan = [
                    'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
                ];
                // tanggal sekarang
                $tanggal = date('d') . ' ' . strtoupper($bulan[date('n') - 1]) . ' ' . date('Y');
                $sheet->mergeCells('G' . ($row + 2) . ':K' . ($row + 2))->setCellValue('G' . ($row + 2), 'MANGGUH, ' . $tanggal);
                $sheet->mergeCells('G' . ($row + 3) . ':K' . ($row + 3))->setCellValue('G' . ($row + 3), 'PENGELOLA/PENGURUS ASET DESA');
                $sheet->mergeCells('G' . ($row + 8) . ':K' . ($row + 8))->setCellValue('G' . ($row + 8), env('PENGELOLA_ASET_NAME'));

                // Prebekel
                $sheet->mergeCells('A' . ($row + 5) . ':K' . ($row + 5))->setCellValue('A' . ($row + 5), 'MENGETAHUI');
                $sheet->mergeCells('A' . ($row + 6) . ':K' . ($row + 6))->setCellValue('A' . ($row + 6), 'PREBEKEL MANGGUH');
                $sheet->mergeCells('A' . ($row + 11) . ':K' . ($row + 11))->setCellValue('A' . ($row + 11), env('PREBEKEL_NAME'));

                $sheet->getStyle('A' . ($row + 2) . ':K' . ($row + 11))->applyFromArray([
                    'alignment' => [
                        'horizontal' => 'center',
                    ]
                ]);
            }
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 5,
            'B' => 35,
            'C' => 12,
            'D' => 8,
            'E' => 10,
            'F' => 9.5,
            'G' => 17,
            'K' => 27,
        ];
    }
}
