<?php

namespace App\Http\Resources;


use App\Http\Controllers\Controller;
use App\Models\Marketing\JobOrder;
use App\Models\Marketing\TrailerBooking;
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

    // public function AdvancePaymentPdfDownload(string $documentID)
    // {
    //     $data = AdvancePayment::find($documentID);
    //     $pdf = DomPdf::loadView('print.advance_payment_pdf', ['title' => "Advance Payment", 'data' => $data]);
    //     return $pdf->download('advance_payment.pdf');
    // }

    public function JobOrderPdf(string $documentID)
    {
        $data = JobOrder::find($documentID);
        $groupContainer = [];
        $calCharge = (object) [
            'vat7' => 0,
            'totalPaid' => 0,
            'totalReceive' => 0,
            'totalBill' => 0,
            'total' => 0,
            'vat3' => 0,
            'vat1'=> 0,
            'cusPaid'=> 0,
            'netTotal' => 0,

        ];
        if($data->containerList != null) {
            $groupContainer = $data->containerList->groupBy('referContainerSize.containersizeName')->map(function ($item, $key) {
                return collect($item)->count().'x'.$key;
            })->toArray();
        }
        $calCharge->vat7 = $data->total_vat;
        $calCharge->total = $data->total_amt;
        $calCharge->vat3 = $data->tax3;
        $calCharge->tax1 = $data->tax1;
        $calCharge->cusPaid = $data->cus_paid;
        $calCharge->netTotal = $data->total_netamt;
        if($data->charge != null) {
            $calCharge->totalPaid = $data->charge->sum('chargesCost');
            $calCharge->totalReceive = $data->charge->sum('chargesReceive');
            $calCharge->totalBill = $data->charge->sum('chargesbillReceive');
        }
        $pdf = DomPdf::loadView('print.job_order_pdf', ['title' => "Job Order", 'data' => $data, 'groupContainer' => $groupContainer, 'calCharge' => $calCharge]);
        return $pdf->stream('job_order.pdf');
    }

    public function BookingJobOrderPdf(string $documentID)
    {
        $data = JobOrder::find($documentID);
        $groupContainer = [];
        if($data->containerList != null) {
            $groupContainer = $data->containerList->groupBy('referContainerSize.containersizeName')->map(function ($item, $key) {
                return collect($item)->count().'x'.$key;
            })->toArray();
        }
        $pdf = DomPdf::loadView('print.booking_job_order_pdf', ['title' => "Booking Confirmation", 'data' => $data, 'groupContainer' => $groupContainer,]);
        return $pdf->stream('booking_job_order.pdf');
    }

    public function TrailerBookingPdf(string $documentID)
    {
        $data = TrailerBooking::find($documentID);
        $pdf = DomPdf::loadView('print.trailer_booking_pdf', ['title' => "Trailer Booking", 'data' => $data]);
        return $pdf->stream('trailer_booking.pdf');
    }

    public function testViewPdf(string $id)
    {
        $data = JobOrder::find($id);
        $groupContainer = [];
        if($data->containerList != null)
            $groupContainer = $data->containerList->groupBy('referContainerSize.containersizeName')->map(function ($item, $key) {
                return collect($item)->count().'X'.$key;
            })->toArray();
        // $pdf = DomPdf::loadView('print.testview', ['title' => "Advance Payment", 'data' => $data]);
        return view('print.job_order_pdf', ['title' => "Job Order", 'data' => $data, 'groupContainer' => $groupContainer, 'test' => true]);
    }
}