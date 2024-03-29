<?php

namespace App\Http\Resources;


use App\Http\Controllers\Controller;
use App\Models\Account\Invoice;
use App\Models\Account\ReceiptVoucher;
use App\Models\Account\TaxInvoice;
use App\Models\Marketing\BillOfLading;
use App\Models\Marketing\JobOrder;
use App\Models\Marketing\TrailerBooking;
use App\Models\Payment\AdvancePayment;
use App\Models\Payment\PaymentVoucher;
use App\Models\Payment\ShipingPaymentVoucher;
use App\Models\PettyCash\PettyCash;
use App\Models\PettyCash\PettyCashShipping;
use App\Models\Shipping\Deposit;
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
        if($data == null) {
            return view('404');
        }
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
        if($data == null) {
            return view('404');
        }
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
        if($data == null) {
            return view('404');
        }
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
        if($data == null) {
            return view('404');
        }
        $groupContainer = [];
        if($data->jobOrder != null && $data->jobOrder->containerList != null) {
            $groupContainer = $data->jobOrder->containerList->groupBy('referContainerSize.containersizeName')->map(function ($item, $key) {
                return collect($item)->count().'x'.$key;
            })->toArray();
        }
        $pdf = DomPdf::loadView('print.trailer_booking_pdf', ['title' => "Trailer Booking", 'data' => $data, 'groupContainer' => $groupContainer]);
        return $pdf->stream('trailer_booking.pdf');
    }

    public function BillOfLadingPdf(string $documentID)
    {
        $data = BillOfLading::find($documentID);
        if($data == null) {
            return view('404');
        }
        $pdf = DomPdf::loadView('print.bill_of_lading_pdf', ['title' => "Bill Of Lading", 'data' => $data]);
        return $pdf->stream('bill_of_lading.pdf');
    }

    public function DepositPdf(string $documentID){
        $data = Deposit::find($documentID);
        if($data == null) {
            return view('404');
        }
        $pdf = DomPdf::loadView('print.deposit_pdf', ['title' => "Deposit", 'data' => $data]);
        return $pdf->stream('deposit.pdf');
    }

    public function InvoicePdf(string $documentID){
        $data = Invoice::find($documentID);
        if($data == null) {
            return view('404');
        }
        $pdf = DomPdf::loadView('print.invoice_pdf', ['title' => "Invoice", 'data' => $data]);
        return $pdf->stream('invoice.pdf');
    }

    public function PaymentVoucherPdf(string $documentID)
    {
        $data = PaymentVoucher::find($documentID);
        if($data == null) {
            return view('404');
        }
        $tax1 = (object) [
            'sumAmount' => 0,
            'sumTax' => 0,

        ];
        $tax3 = (object) [
            'sumAmount' => 0,
            'sumTax' => 0,
        ];
        if($data->items == null) {
            $tax1->sumAmount = $data->items->filter(function ($item) {
                if($item->charge == null || $item->charge->chargesType == null) return false;
                return $item->charges->chargesType->amount == 1;
            })->sum('amount');
            $tax1->sumTax = $tax1->sumAmount * 0.01;
            $tax3->sumAmount = $data->items->filter(function ($item) {
                if($item->charge == null || $item->charge->chargesType == null) return false;
                return $item->charges->chargesType->amount == 3;
            })->sum('amount');
            $tax3->sumTax = $tax3->sumAmount * 0.03;
        }
        $pdf = DomPdf::loadView('print.payment_voucher_pdf', ['title' => "Payment Voucher", 'data' => $data, 'tax1' => $tax1, 'tax3' => $tax3]);
        return $pdf->stream('payment_voucher.pdf');
    }

    public function PettyCashPdf(string $documentID)
    {
        $data = PettyCash::find($documentID);
        if($data == null) {
            return view('404');
        }
        $tax1 = 0;
        $tax3 = 0;
        if($data->items == null) {
            $tax1 = $data->items->filter(function ($item) {
                if($item->charge == null || $item->charge->chargesType == null) return false;
                return $item->charges->chargesType->amount == 1;
            })->sum('amount') * 0.01;
            $tax3 = $data->items->filter(function ($item) {
                if($item->charge == null || $item->charge->chargesType == null) return false;
                return $item->charges->chargesType->amount == 3;
            })->sum('amount') * 0.03;
        }
        $pdf = DomPdf::loadView('print.petty_cash_pdf', ['title' => "Petty Cash", 'data' => $data, 'tax1'=> $tax1, 'tax3'=> $tax3]);
        return $pdf->stream('petty_cash.pdf');
    }

    public function ShippingPaymentVoucherPdf(string $documentID)
    {
        $data = ShipingPaymentVoucher::find($documentID);
        if($data == null) {
            return view('404');
        }
        $tax1 = (object) [
            'sumAmount' => 0,
            'sumTax' => 0,

        ];
        $tax3 = (object) [
            'sumAmount' => 0,
            'sumTax' => 0,
        ];
        if($data->items == null) {
            $tax1->sumAmount = $data->items->filter(function ($item) {
                if($item->charge == null || $item->charge->chargesType == null) return false;
                return $item->charges->chargesType->amount == 1;
            })->sum('amount');
            $tax1->sumTax = $tax1->sumAmount * 0.01;
            $tax3->sumAmount = $data->items->filter(function ($item) {
                if($item->charge == null || $item->charge->chargesType == null) return false;
                return $item->charges->chargesType->amount == 3;
            })->sum('amount');
            $tax3->sumTax = $tax3->sumAmount * 0.03;
        }
        $pdf = DomPdf::loadView('print.shiping_payment_voucher_pdf', ['title' => "Shipping Payment Voucher", 'data' => $data, 'tax1' => $tax1, 'tax3' => $tax3]);
        return $pdf->stream('shipping_payment_voucher.pdf');
    }

    public function ShippingPettyCashPdf(string $documentID)
    {
        $data = PettyCashShipping::find($documentID);
        if($data == null) {
            return view('404');
        }
        $tax1 = 0;
        $tax3 = 0;
        if($data->items == null) {
            $tax1 = $data->items->filter(function ($item) {
                if($item->charge == null || $item->charge->chargesType == null) return false;
                return $item->charges->chargesType->amount == 1;
            })->sum('amount') * 0.01;
            $tax3 = $data->items->filter(function ($item) {
                if($item->charge == null || $item->charge->chargesType == null) return false;
                return $item->charges->chargesType->amount == 3;
            })->sum('amount') * 0.03;
        }
        $pdf = DomPdf::loadView('print.petty_cash_shipping_pdf', ['title' => "Shipping Petty Cash", 'data' => $data, 'tax1'=> $tax1,'tax3'=> $tax3]);
        return $pdf->stream('shiping_petty_cash.pdf');
    }

    public function ReceiptVoucherPdf(string $documentID)
    {
        $data = ReceiptVoucher::find($documentID);
        if($data == null) {
            return view('404');
        }
        $pdf = DomPdf::loadView('print.receipt_voucher_pdf', ['title' => "Receipt Voucher", 'data' => $data]);
        return $pdf->stream('receipt_voucher.pdf');
    }

    public function TaxInvoicePdf(string $documentID)
    {
        $data = TaxInvoice::find($documentID);
        if($data == null) {
            return view('404');
        }
        $pdf = DomPdf::loadView('print.tax_invoice_pdf', ['title' => "Tax Invoice", 'data' => $data]);
        return $pdf->stream('tax_invoice.pdf');
    }

    public function testViewPdf(string $id)
    {
        $data = Invoice::find($id);
        if($data == null) {
            return view('404');
        }
        return view('print.invoice_pdf', ['title' => "Invoice", 'data' => $data, 'test' => true]);
    }
}