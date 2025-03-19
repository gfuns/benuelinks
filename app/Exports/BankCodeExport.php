<?php
namespace App\Exports;

use App\Models\Bank;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class BankCodeExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles, WithColumnFormatting
{
    protected $rowCount = 0;

    public function __construct()
    {

    }

    public function collection()
    {
        return Bank::all();

    }

    /**
     * Map the data for export.
     *
     * @param mixed $payment
     * @return array
     */
    public function map($bank): array
    {
        $this->rowCount++;
        return [
            $this->rowCount,
            $bank->bank_name,
            $bank->bank_code,
        ];
    }

    public function headings(): array
    {
        // Specify the headings for the columns
        return [
            'S/No',
            'Bank Name',
            'Bank Code',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Apply bold font style to the headings row
        $sheet->getStyle('A1:J1')->applyFromArray([
            'font' => [
                'bold' => true,
            ],
        ]);
    }

    public function columnFormats(): array
    {
        return [
            'B' => NumberFormat::FORMAT_TEXT,
            'C' => NumberFormat::FORMAT_TEXT,
        ];
    }
}
