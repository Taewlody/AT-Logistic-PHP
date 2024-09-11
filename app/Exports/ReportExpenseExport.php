<?php

namespace App\Exports;

use App\Models\Payment\PaymentVoucher;
use App\Models\Common\Supplier;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Border;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class ReportExpenseExport implements FromCollection, WithHeadings, WithMapping, WithEvents, WithStyles
{
    private $data;

    public function collection()
    {
        $yearSearch = 2024; // Replace with dynamic year if necessary
        $test = PaymentVoucher::with('items')
            ->select('documentID', 'documentDate', 'supCode')
            ->whereRaw("(refJobNo IS NULL OR refJobNo = '')")
            ->whereYear('documentDate', $yearSearch)
            // ->where('supCode','S-0359')
            ->groupBy('supCode', 'documentID', 'documentDate')
            // ->orderBy('supCode')
            ->get()
            ->mapToGroups(function ($item) {
                $result = [];
                if(count($item->items) > 0) {
                    foreach($item->items as $data) {
                       
                        $result[] = [
                            'supCode' => $item->supCode,
                            'amount' => $data['amount'],
                            'detail' => $data['chartDetail'],
                            'code' => $data['chargeCode'],
                        ];
                    }
                }
                // dd($result);
                return $result;
            });

        
            // $test = $test->map(function ($collection, $key) {
            //     return [
            //         'key' => $key, // The index name like "S-0014"
            //         'data' => $collection // The corresponding collection data
            //     ];
            // });
            
            $this->data = $test[0]->toArray();
        // dd($test[0]);
        return $test[0];
   
    }

    public function headings(): array
    {
        return ['Company', 'Details', 'Amount'];
    }

    public function map($row): array
    {
        $mappedRows = [];
        // dd($row);
        $supplier = Supplier::where('supCode', $row['supCode'])->first();
        
        $mappedRows[] = [             // The company or document ID (e.g., "S-0014")
            $supplier->supNameEN ? $supplier->supNameEN : $supplier->supNameTH,               // The chargeCode (details)
            $row['detail'],
            $row['amount'], // Sum of 'amount' for the current group
        ];
        return $mappedRows;
        
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1:C1')->getFont()->setBold(true);
    
    // Merge cells
    $currentCompany = null;
    $startRow = 2;
    $lastRow = $startRow;

    foreach ($this->data as $item) {
        if ($item['supCode'] !== $currentCompany) {
            if ($currentCompany !== null) {
                $sheet->mergeCells("A{$startRow}:A" . ($lastRow - 1));
            }
            $currentCompany = $item['supCode'];
            $startRow = $lastRow;
        }
        $lastRow++;
    }
    
    // Merge the last group
    if ($currentCompany !== null) {
        $sheet->mergeCells("A{$startRow}:A" . ($lastRow - 1));
    }

    // Set border style
    $sheet->getColumnDimension('A')->setWidth(50);
    $sheet->getColumnDimension('B')->setWidth(50);
    $sheet->getColumnDimension('C')->setWidth(20);

    $sheet->getStyle($sheet->calculateWorksheetDimension())->getFont()->setSize(14);

    $sheet->getStyle('A1:C' . ($lastRow - 1))->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

        return [
            'A' => [
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                ],
            ],
            'B' => [
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                ],
            ],
            'C' => [
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT,
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                ],
            ],
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                $companyColumn = 'A'; // Assuming 'A' is for Company
                $startRow = 2; // Starting after the header
    
                $currentCompany = null;
                $startMergeRow = $startRow;
                $index = 0;
    
                foreach ($this->data as $row) {
                    $company = $row['supCode'];
                    $currentRow = $startRow + $index;
                    if ($company === $currentCompany) {
                        
                        $index++;
                    } else {
                        
                        if ($currentCompany !== null && $startMergeRow < $currentRow - 1) {
                            // Merge cells for the previous company
                            $sheet->mergeCells("{$companyColumn}{$startMergeRow}:{$companyColumn}" . ($currentRow - 1));
                        }
    
                        $index = 1;
                    }
                    $currentCompany = $company;
                    $startMergeRow = $currentRow;
                }
    
                if ($startMergeRow < ($startRow + $index - 1)) {
                    $sheet->mergeCells("{$companyColumn}{$startMergeRow}:{$companyColumn}" . ($startRow + $index - 1));
                }
                
            },
        ];
    }
}
