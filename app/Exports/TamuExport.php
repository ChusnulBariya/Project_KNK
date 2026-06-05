<?php

namespace App\Exports;

use App\Models\Tamu;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use Carbon\Carbon;

class TamuExport implements FromQuery, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    use Exportable;

    protected $startDate;
    protected $endDate;
    private $rowNumber = 0;

    public function __construct($startDate = null, $endDate = null)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    /**
     * Fetch the filtered list of tamu records.
     */
    public function query()
    {
        $query = Tamu::query()->with('kategori');

        if ($this->startDate && $this->endDate) {
            $query->whereBetween('created_at', [
                Carbon::parse($this->startDate)->startOfDay(),
                Carbon::parse($this->endDate)->endOfDay()
            ]);
        } elseif ($this->startDate) {
            $query->where('created_at', '>=', Carbon::parse($this->startDate)->startOfDay());
        } elseif ($this->endDate) {
            $query->where('created_at', '<=', Carbon::parse($this->endDate)->endOfDay());
        }

        return $query->orderBy('created_at', 'asc');
    }

    /**
     * Define the Excel header row.
     */
    public function headings(): array
    {
        return [
            'No',
            'Nama Tamu',
            'Nomor HP',
            'Alamat',
            'Kategori Keperluan',
            'Tanggal Kunjungan',
            'Jam Kunjungan'
        ];
    }

    /**
     * Map each row's data.
     */
    public function map($tamu): array
    {
        $this->rowNumber++;
        return [
            $this->rowNumber,
            $tamu->nama,
            $tamu->nomor_hp,
            $tamu->alamat,
            $tamu->kategori->nama_kategori,
            $tamu->created_at->format('d/m/Y'),
            $tamu->created_at->format('H:i') . ' WIB'
        ];
    }

    /**
     * Apply custom style to the header row.
     */
    public function styles(Worksheet $sheet)
    {
        // Alignments and borders
        $sheet->getStyle('A1:G1')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
        $sheet->getStyle('A1:G1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        return [
            1 => [
                'font' => [
                    'bold' => true,
                    'color' => ['rgb' => 'FFFFFF'],
                    'size' => 11
                ],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '0052D4']
                ],
            ]
        ];
    }
}
