<?php

namespace App\Exports;

use App\Models\AsetTanahModel;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\PageSetup;

class AsetTanahExport implements FromCollection, WithMapping, WithHeadings, ShouldAutoSize, WithEvents, WithColumnWidths
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        // return data with row number
        return AsetTanahModel::all()->map(function ($asetTanah, $key) {
            $asetTanah->no = $key + 1;
            return $asetTanah;
        });
    }

    public function headings(): array
    {
        return [
            ['LAPORAN HASIL INVENTASI ASET DESA'],
            ['BERUPA ASET TANAH'],
            [''],
            [
                'No',
                'Jenis Barang',
                'Identitas Barang',
                'Asal Usul Barang',
                '',
                '',
                'Tanggal Bulan Tahun Perolehan',
                'Harga Nilai Perolehan',
                'Perkiraan Harga Nilai Sekarang',
                'Keterangan'
            ],
            [
                '', '', '', 'APBD', 'Perolehan Lain Yang Sah', 'Aset atau Kekayaan Asli Desa', '', '', '', ''
            ]
        ];
    }

    public function map($asetTanah): array
    {
        return [
            $asetTanah->no,
            $asetTanah->jenis_barang,
            $asetTanah->identitas_barang,
            $asetTanah->apbd,
            $asetTanah->perolehan_lain_yang_sah,
            $asetTanah->aset_atau_kekayaan_asli_desa,
            $asetTanah->tanggal_bulan_tahun_perolehan,
            $asetTanah->harga_nilai_perolehan,
            $asetTanah->perkiraan_harga_nilai_sekarang,
            $asetTanah->keterangan
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                $sheet->getParent()->getDefaultStyle()->getFont()->setSize(10);
                $sheet->mergeCells('A1:J1');
                $sheet->mergeCells('A2:J2');
                $sheet->getStyle('A1:J2')->applyFromArray([
                    'font' => [
                        'bold' => true
                    ],
                    'alignment' => [
                        'horizontal' => 'center'
                    ]
                ]);
                $sheet->mergeCells('A4:A5');
                $sheet->mergeCells('B4:B5');
                $sheet->mergeCells('C4:C5');
                $sheet->mergeCells('D4:F4');
                $sheet->mergeCells('G4:G5');
                $sheet->mergeCells('H4:H5');
                $sheet->mergeCells('I4:I5');
                $sheet->mergeCells('J4:J5');
                $sheet->getStyle('A4:J5')->applyFromArray([
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

                AsetTanahModel::all()->map(function ($asetTanah, $key) use ($sheet) {
                    $row = $key + 6;
                    $sheet->getStyle('A' . $row . ':J' . $row)->applyFromArray([
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
                });

                // Set the paper size
                $sheet->getPageSetup()->setPaperSize(PageSetup::PAPERSIZE_A4);

                // Set the orientation to landscape
                $sheet->getPageSetup()->setOrientation(PageSetup::ORIENTATION_LANDSCAPE);

                $users = AsetTanahModel::all();
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
                $sheet->mergeCells('G' . ($row + 2) . ':J' . ($row + 2))->setCellValue('G' . ($row + 2), 'MANGGUH, ' . $tanggal);
                $sheet->mergeCells('G' . ($row + 3) . ':J' . ($row + 3))->setCellValue('G' . ($row + 3), 'PENGELOLA/PENGURUS ASET DESA');
                $sheet->mergeCells('G' . ($row + 8) . ':J' . ($row + 8))->setCellValue('G' . ($row + 8), env('PENGELOLA_ASET_NAME'));

                // Prebekel
                $sheet->mergeCells('A' . ($row + 5) . ':J' . ($row + 5))->setCellValue('A' . ($row + 5), 'MENGETAHUI');
                $sheet->mergeCells('A' . ($row + 6) . ':J' . ($row + 6))->setCellValue('A' . ($row + 6), 'PREBEKEL MANGGUH');
                $sheet->mergeCells('A' . ($row + 11) . ':J' . ($row + 11))->setCellValue('A' . ($row + 11), env('PREBEKEL_NAME'));

                $sheet->getStyle('A' . ($row + 2) . ':J' . ($row + 11))->applyFromArray([
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
            'B' => 20,
            'C' => 20,
            'D' => 8,
            'E' => 8,
            'F' => 8,
            'G' => 11,
            'H' => 15,
            'I' => 15,
            'j' => 22,
        ];
    }
}
