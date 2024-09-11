<?php

namespace App\Exports;

use App\Models\Marketing\JobOrder;
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
use PhpOffice\PhpSpreadsheet\Style\Color;

class JobOrderExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    /**
     * Retrieve the collection of job orders with status 'P'.
     *
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return JobOrder::where('documentstatus', 'P')->orderBy('documentID')->get();
        // return JobOrder::where('documentID', 'REF2407-00029')->orderBy('documentID')->get();
    }

    /**
     * Define the column headings for the Excel file.
     *
     * @return array
     */
    public function headings(): array
    {
        return [
            'REF.',
            'Customer',
            'Bound',
            'B/L NO',
            'INVOICE NO.',
            'Liners', // liners = agent
            'VOLUME',
            'ETA',
            'D/O',
            'TRAILER'
        ];
    }

    /**
     * Map each job order to a row in the Excel file.
     *
     * @param  \App\Models\JobOrder  $jobOrder
     * @return array
     */
    public function map($jobOrder): array
    {
        $chargeList = $jobOrder->charge->toArray();
        $checkDo = array_filter($chargeList, function($charge) {
            return $charge['chargeCode'] === "C-007";
        });

        $supplier = $jobOrder->trailerBooking ? $jobOrder->trailerBooking->tocompany : '';
        $trailer = '';
        if($supplier) {
            $trailer = Supplier::select('supNameTH', 'supNameEN')->where('supCode', $supplier)->first();
        }
        $liner = $jobOrder->agentRefer ?? '';
        
        return [
            $jobOrder->documentID,

            $jobOrder->customerRefer != null ? $jobOrder->customerRefer->custNameEN ? $jobOrder->customerRefer->custNameEN : $jobOrder->customerRefer->custNameTH : '',

            $jobOrder->bound === "1" ? 'IN BOUND' : 'OUT BOUND',
            $jobOrder->bill_of_landing,
            $jobOrder->invNo,
            $liner ?
                $liner->supNameEN ? $liner->supNameEN : $liner->supNameTH
                : '', //liners
            $jobOrder->containerList->count(),
            $jobOrder->etaDate,
            $checkDo ? 'OK' : '',
            $trailer ?
                $trailer->supNameEN ? $trailer->supNameEN : $trailer->supNameTH
                : '',
            
        ];
    }

    public function styles(Worksheet $sheet)
    {

        $sheet->getStyle('A1:J1')->getFont()->setBold(true);
        $sheet->getStyle('I2:I' . ($sheet->getHighestRow()))->getFont()->getColor()->setARGB(Color::COLOR_GREEN);

        // Set border style
        $sheet->getColumnDimension('A')->setWidth(20);
        $sheet->getColumnDimension('B')->setWidth(50);
        $sheet->getColumnDimension('C')->setWidth(30);
        $sheet->getColumnDimension('D')->setWidth(30);
        $sheet->getColumnDimension('E')->setAutoSize(true);
        $sheet->getColumnDimension('F')->setAutoSize(true);
        $sheet->getColumnDimension('G')->setWidth(20);
        $sheet->getColumnDimension('H')->setAutoSize(true);
        $sheet->getColumnDimension('I')->setAutoSize(true);
        $sheet->getColumnDimension('J')->setAutoSize(true);

        $sheet->getStyle($sheet->calculateWorksheetDimension())->getFont()->setSize(14);

        $dataRange = 'A1:J' . ($sheet->getHighestRow()); // Adjust range as needed
        $sheet->getStyle($dataRange)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

        return [
            'A' => [
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
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
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                ],
            ],
            'D' => [
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
                ],
            ],
            'E' => [
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
                ],
            ],
            'G' => [
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                ],
            ],
            'H' => [
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                ],
            ],
            'I' => [
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                ],
            ],
        ];
    }
}
