<?php

namespace App\Http\Resources;


use App\Http\Controllers\Controller;
use App\Models\Payment\AdvancePayment;
use Dompdf\Css\Stylesheet;
use Spatie\Browsershot\Browsershot;
use Spatie\LaravelPdf\Enums\Format;
use Spatie\LaravelPdf\Enums\Unit;
use function Spatie\LaravelPdf\Support\pdf;
use Barryvdh\DomPDF\Facade\Pdf as DomPdf;
use Dompdf\FontMetrics;

class PrintFileResource extends Controller
{

    public function AdvancePaymentPdf(string $documentID)
    {
        $data = AdvancePayment::find($documentID);
        $pdf = DomPdf::loadView('print.advance_payment_pdf', ['title' => "Advance Payment", 'data' => $data]);
        return $pdf->stream('advance_payment.pdf');
    }

    public function AdvancePaymentPdfDownload(string $documentID)
    {
        $data = AdvancePayment::find($documentID);
        $pdf = DomPdf::loadView('print.advance_payment_pdf', ['title' => "Advance Payment", 'data' => $data]);
        return $pdf->download('advance_payment.pdf');
    }

    public function testViewPdf(string $id)
    {
        $data = AdvancePayment::find($id);
        // $pdf = DomPdf::loadView('print.testview', ['title' => "Advance Payment", 'data' => $data]);
        return view('print.advance_payment_pdf', ['title' => "Advance Payment", 'data' => $data, 'test' => true]);
    }
}