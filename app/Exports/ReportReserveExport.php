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
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

use Maatwebsite\Excel\Concerns\Exportable;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class ReportReserveExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithEvents, WithColumnFormatting
{
    private $data;

    public function collection()
    {
        $yearSearch = 2024; 
        $test = Joborder::with(['invoice', 'charge', 'customerRefer'])
            // ->where('documentstatus', 'A')
            ->whereHas('invoice', function($query) {
                $query->whereNull('taxivRef');
            })
            ->whereYear('documentDate', $yearSearch)
            ->get();
            // dd($test[0]);
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
        
        $mappedRows = [];
        foreach ($row as $groupKey => $charges) {
            $cusCode = $groupKey;  
            $cusName = Customer::where('cusCode', $cusCode)->first();
           
            foreach ($charges as $chargeCode => $data) {
                
                $mappedRows[] = [
                    $cusName->custNameEN ? $cusName->custNameEN : $cusName->custNameTH,                 
                    $chargeCode,                      
                    $data['detail'],                  
                    $data['chargesbillReceive'],      
                ];
            }
          
        }
        return $mappedRows;
        
    }

    public function columnFormats(): array
    {
        return [
            'D' => \PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
        ];
    }

    public function styles(Worksheet $sheet)
    {
       
        $sheet->getStyle('A1:D1')->getFont()->setBold(true);

        $sheet->getColumnDimension('A')->setWidth(70);
        $sheet->getColumnDimension('B')->setWidth(20);
        $sheet->getColumnDimension('C')->setWidth(70);
        $sheet->getColumnDimension('D')->setWidth(20);

     
        $sheet->getStyle($sheet->calculateWorksheetDimension())->getFont()->setSize(14);

      
        $currentCompany = null;
        $startRow = 2; 
        $lastRow = $startRow;

        $flattenedData = [];
        foreach ($this->data as $item) {
            foreach ($item as $cusCode => $charges) {
                foreach ($charges as $chargeCode => $data) {
                    $flattenedData[] = ['cusCode' => $cusCode, 'chargeCode' => $chargeCode];
                }
            
                
            }
            
        }

        foreach ($flattenedData as $index => $row) {
            $cusCode = $row['cusCode'];
            
            if ($cusCode !== $currentCompany) {
                if ($currentCompany !== null) {
                    
                    $sheet->mergeCells("A{$startRow}:A" . ($lastRow - 1));
                }
                
                $currentCompany = $cusCode;
                $startRow = $lastRow;
            }
            $lastRow++; 
        }

        
        if ($currentCompany !== null) {
            
            $sheet->mergeCells("A{$startRow}:A" . ($lastRow - 1));
        }

        
        $sheet->getStyle('A1:D' . ($lastRow - 1))->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

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

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                // dd($event, $sheet);
                $lastRow = $sheet->getHighestRow() + 1; // Get the next empty row
                
                // Add sum formula in the 'Amount' column
                $sheet->setCellValue('C' . $lastRow, 'Total');
                $sheet->setCellValue('D' . $lastRow, '=SUM(D2:D' . ($lastRow - 1) . ')'); // Adjust column/row references
                $sheet->getStyle($sheet->calculateWorksheetDimension())->getFont()->setSize(14);

                $sheet->getStyle('D2:D' . $lastRow)->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
                
                // Optional: apply some styling
                $sheet->getStyle('C' . $lastRow . ':D' . $lastRow)->getFont()->setBold(true);

                
            }
        ];
    }
}
