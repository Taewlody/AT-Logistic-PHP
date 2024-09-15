<?php

namespace App\Exports;

use App\Models\Marketing\JobOrder;
use App\Models\Common\Customer;

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

class ReportReserveExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    private $data;

    public function collection()
    {
        $yearSearch = 2024; 
        $test = Joborder::with(['invoice', 'charge', 'customerRefer'])
            ->where('documentstatus', 'A')
            ->whereYear('documentDate', $yearSearch)
            ->get();

            $company = [];

            // Loop through each JobOrder
            foreach ($test as $jobOrder) {
                // Initialize grouped data for each customer if not already set
                if (!isset($company[$jobOrder->cusCode])) {
                    $company[$jobOrder->cusCode] = [];
                }
            
                // Loop through each charge related to the JobOrder
                foreach ($jobOrder->charge as $charge) {
                    $code = $charge->chargeCode;
            
                    // Initialize grouped data for each chargeCode if not already set
                    if (!isset($company[$jobOrder->cusCode][$code])) {
                        $company[$jobOrder->cusCode][$code] = [
                            'chargesbillReceive' => 0,
                            'detail' => '',
                        ];
                    }
            
                    // Accumulate chargesbillReceive
                    $company[$jobOrder->cusCode][$code]['chargesbillReceive'] += $charge->chargesbillReceive;

                    $company[$jobOrder->cusCode][$code]['detail'] = $charge->detail;
                }
            }

            $t[] = collect($company);
            // dd(collect($t));
      
        $this->data = collect($t);
      
        return collect($t);
   
    }

    public function headings(): array
    {
        return ['Company', 'ChargeCode', 'Details', 'Amount'];
    }

    public function map($row): array
    {
        // dd($row);
        $mappedRows = [];
        foreach ($row as $groupKey => $charges) {
           
            foreach ($charges as $chargeCode => $data) {
                $cusCode = $groupKey;  
                $cusName = Customer::where('cusCode', $cusCode)->first();
                // dd($cusName);
                $mappedRows[] = [
                    $cusName->custNameEN ? $cusName->custNameEN : $cusName->custNameTH,                         // Corrected customer code
                    $chargeCode,                      // Charge code
                    $data['detail'],                  // Charge detail
                    $data['chargesbillReceive'],      // Total amount
                ];
            }
        }
        // dd($row, $mappedRows);
        return $mappedRows;
        
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1:D1')->getFont()->setBold(true);

    // Set column widths
    $sheet->getColumnDimension('A')->setWidth(70);
    $sheet->getColumnDimension('B')->setWidth(20);
    $sheet->getColumnDimension('C')->setWidth(70);
    $sheet->getColumnDimension('D')->setWidth(20);

    // Set font size for the whole sheet
    $sheet->getStyle($sheet->calculateWorksheetDimension())->getFont()->setSize(14);

    // Initialize variables for merging
    $currentCompany = null;
    $startRow = 2; // Starting row (after the header)
    $lastRow = $startRow;

    // Flatten data into an array to properly iterate through
    $flattenedData = [];
    foreach ($this->data as $item) {
        foreach ($item as $cusCode => $charges) {
            foreach ($charges as $chargeCode => $data) {
                $flattenedData[] = ['cusCode' => $cusCode, 'chargeCode' => $chargeCode];
            }
        }
    }

    // Loop through flattened data for merging
    foreach ($flattenedData as $index => $row) {
        $cusCode = $row['cusCode'];

        // Check if we are on a new company
        if ($cusCode !== $currentCompany) {
            if ($currentCompany !== null) {
                // Merge cells for the previous company
                $sheet->mergeCells("A{$startRow}:A" . ($lastRow - 1));
            }
            // Update the company and start row for the new company
            $currentCompany = $cusCode;
            $startRow = $lastRow;
        }

        $lastRow++; // Increment row counter for each row
    }

    // Merge the last group
    if ($currentCompany !== null) {
        $sheet->mergeCells("A{$startRow}:A" . ($lastRow - 1));
    }

    // Set border style for all cells in the range
    $sheet->getStyle('A1:D' . ($lastRow - 1))->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

    // Alignment configuration
    return [
        'A' => [
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ],
        ],
        'B' => [
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ],
        ],
        'C' => [
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ],
        ],
        'D' => [
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ],
        ],
    ];
    }
}
