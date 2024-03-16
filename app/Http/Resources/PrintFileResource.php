<?php

namespace App\Http\Resources;


use App\Http\Controllers\Controller;
use App\Models\Payment\AdvancePayment;
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
        // $content = pdf('print.advance_payment_pdf', ['title' => "Advance Payment", 'data' => $data])->withBrowsershot(function (Browsershot $browsershot) {
        //     $browsershot->noSandbox()->setEnvironmentOptions(['LANG' => 'th_TH.UTF-8']);
        // })->format(Format::A4)->margins(27, 15, 10, 15, Unit::Pixel)->name('advance_payment.pdf')->headers(['Content-Type' => 'text/html','title' => "Advance Payment"]);
        // return $content;

        $pdf = DomPdf::loadView('print.advance_payment_pdf', ['title' => "Advance Payment", 'data' => $data]);
        return $pdf->stream();
    }

    public function AdvancePaymentPdfDownload(string $documentID)
    {
        $data = AdvancePayment::find($documentID);
        return pdf('print.advance_payment_pdf', ['title' => "Advance Payment", 'data' => $data])->withBrowsershot(function (Browsershot $browsershot) {
            $browsershot->noSandbox()->setEnvironmentOptions(['LANG' => 'th_TH.UTF-8']);
        })->format(Format::A4)->download('advance_payment.pdf');
    }
}