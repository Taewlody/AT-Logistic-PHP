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
            'tax3' => 0,
            'tax1'=> 0,
            'cusPaid'=> 0,
            'netTotal' => 0,

        ];
        if($data->containerList != null) {
            $groupContainer = $data->containerList->groupBy('size.containersizeName')->map(function ($item, $key) {
                return collect($item)->count().'x'.$key;
            })->toArray();
        }
        $calCharge->vat7 = $data->total_vat;
        $calCharge->total = $data->total_amt;
        $calCharge->tax3 = $data->tax3;
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
            $groupContainer = $data->containerList->groupBy('size.containersizeName')->map(function ($item, $key) {
                return collect($item)->count().'x'.$key;
            })->toArray();
        }
        $groupCommodity = [];
        if($data->commodity != null) {
            $groupCommodity = $data->commodity->map(function ($item, $key) {
                return $item->commodityNameEN ? $item->commodityNameEN : $item->commodityNameTH;
            })->toArray();
        }
        
        $pdf = DomPdf::loadView('print.booking_job_order_pdf', ['title' => "Booking Confirmation", 'data' => $data, 'groupContainer' => $groupContainer, 'groupCommodity' => $groupCommodity,]);
        return $pdf->stream('booking_job_order.pdf');

        // return view('print.booking_job_order_pdf', [
        //     'title' => "Booking Confirmation", 
        //     'data' => $data, 
        //     'groupCommodity' => $groupCommodity, 
        //     'groupContainer' => $groupContainer, 
        //     'test' => true]);
    }

    public function TrailerBookingPdf(string $documentID)
    {
        $data = TrailerBooking::find($documentID);
        if($data == null) {
            return view('404');
        }
        $groupContainer = [];
        if($data->jobOrder != null && $data->jobOrder->containerList != null) {
            $groupContainer = $data->jobOrder->containerList->groupBy('size.containersizeName')->map(function ($item, $key) {
                return collect($item)->count().'x'.$key;
            })->toArray();
        }
        
        $pdf = DomPdf::loadView('print.trailer_booking_pdf', ['title' => "Trailer Booking", 'data' => $data, 'groupContainer' => $groupContainer]);
        return $pdf->stream('trailer_booking.pdf');

        // return view('print.trailer_booking_pdf', [
        //     'title' => "Trailer Booking", 
        //     'data' => $data, 
        //     'groupContainer' => $groupContainer,
        //     'test' => true]);
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
        $heightItems = 0;
        if($data->items != null) {
            $heightItems = $data->items->count() * 14;
        }
        
        $heightItems = 328 - $heightItems;
        $heightItems = $heightItems < 0 ? 'auto' : $heightItems.'px';
        
        $credit = $data->credit && $data->credit->creditName ? $data->credit->creditName : $data->customer->creditDay.' Day';

        $groupCommodity = [];
        if($data->joborder->commodity != null) {
            $groupCommodity = $data->joborder->commodity->map(function ($item, $key) {
                return $item->commodityNameEN ? $item->commodityNameEN : $item->commodityNameTH;
            })->toArray();
        }

        $onBoard = '';
        if($data->joborder->getBound === 'IN BOUND'){
            $onBoard = $data->joborder->etaDate;
        }else {
            $onBoard = $data->joborder->etdDate;
        }
        // dd($onBoard, $data->joborder);
        $pdf = DomPdf::loadView('print.invoice_pdf', [
            'title' => "Invoice", 
            'data' => $data, 
            'credit' => $credit,
            'groupCommodity' => $groupCommodity,
            'onBoard' => $onBoard,
            'heightItems' => $heightItems]);
        return $pdf->stream('invoice.pdf');

        // return view('print.invoice_pdf', [
        //     'title' => "Invoice", 
        //     'data' => $data, 
        //     'heightItems' => $heightItems,
        //     'credit' => $credit,
        //     'groupCommodity' => $groupCommodity,
        //     'onBoard' => $onBoard,
        //     'test' => true]);
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
        if($data->items != null) {
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
        if($data->items != null) {
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
        if($data->items != null) {
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
        if($data->items != null) {
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
        $heightChargesReceive = 0;
        $heightChargesbillReceive = 0;
        $itemChargesReceive = $data->items->filter(function ($item) {
            return $item->chargesReceive > 0;
        })->groupBy('detail')->map(function ($item) {
            $newItem = (object) [
                'detail' => $item->first()->detail,
                'chargesReceive' => $item->sum('chargesReceive'),
            ];
            return $newItem;
        });
        $itemChargesbillReceive = $data->items->filter(function ($item) {
            return $item->chargesbillReceive > 0;
        })->groupBy('detail')->map(function ($item) {
            $newItem = (object) [
                'detail' => $item->first()->detail,
                'chargesbillReceive' => $item->sum('chargesbillReceive'),
            ];
            return $newItem;
        });
        // if($data->items != null) {
            $heightChargesReceive = $itemChargesReceive->count() * 14;
            $heightChargesbillReceive = $itemChargesbillReceive->count() * 14;
        // }
        
        $heightChargesReceive = 260 - $heightChargesReceive;
        $heightChargesReceive = $heightChargesReceive < 0 ? 'auto' : $heightChargesReceive.'px';
        $heightChargesbillReceive = 288 - $heightChargesbillReceive;
        $heightChargesbillReceive = $heightChargesbillReceive < 0 ? 'auto' : $heightChargesbillReceive.'px';
        $pdf = DomPdf::loadView('print.tax_invoice_pdf', ['title' => "Tax Invoice", 'data' => $data, 'itemChargesReceive'=> $itemChargesReceive, 'heightChargesReceive' => $heightChargesReceive, 'itemChargesbillReceive'=> $itemChargesbillReceive, 'heightChargesbillReceive' => $heightChargesbillReceive]);
        return $pdf->stream('tax_invoice.pdf');
    }

    public function testViewPdf(string $id)
    {
        $data = TaxInvoice::find($id);
        if($data == null) {
            return view('404');
        }
        $heightChargesReceive = 0;
        $itemChargesReceive = $data->items->filter(function ($item) {
            return $item->chargesReceive > 0;
        })->groupBy('detail')->map(function ($item) {
            $newItem = (object) [
                'detail' => $item->first()->detail,
                'chargesReceive' => $item->sum('chargesReceive'),
            ];
            return $newItem;
        });
        if($data->items != null) {
            $heightChargesReceive = $itemChargesReceive->count() * 14;
        }
        $heightChargesReceive = 328 - $heightChargesReceive;
        $heightChargesReceive = $heightChargesReceive < 0 ? 'auto' : $heightChargesReceive.'px';

        
        return view('print.tax_invoice_pdf', ['title' => "Tax Invoice", 'data' => $data, 'itemChargesReceive'=> $itemChargesReceive, 'heightChargesReceive' => $heightChargesReceive, 'test' => true]);
    }
}