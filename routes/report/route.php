<?php

use Illuminate\Support\Facades\Route;

use App\Livewire\Page\Report\ReportJob\Page as ReportJob;
use App\Livewire\Page\Report\ReportProfitAndLossJob\Page as ReportProfitAndLossJob;
use App\Livewire\Page\Report\ReportSaleInvoice\Page as ReportSaleInvoice;
use App\Livewire\Page\Report\ReportSaleTaxInvoice\Page as ReportSaleTaxInvoice;
use App\Livewire\Page\Report\ReportInvoiceOverdue\Page as ReportInvoiceOverdue;
use App\Livewire\Page\Report\PaymentVoucherItems\Page as ReportPaymentVoucherItems;
use App\Livewire\Page\Report\ReceiptVoucher\Page as ReportReceiptVoucher;
use App\Livewire\Page\Report\TaxInvoice\Page as ReportTaxInvoice;
use App\Livewire\Page\Report\PaymentVoucher\Page as ReportPaymentVoucher;

Route::group(['prefix'=> 'report',], function() {
    Route::get("/report-job", ReportJob::class)->name('report-job');

    Route::get("/report-profit-and-loss-job", ReportProfitAndLossJob::class)->name('report-profit-and-loss-job');

    Route::get("/report-sale-invoice", ReportSaleInvoice::class)->name('report-sale-invoice');

    Route::get("/report-sale-tax-invoice", ReportSaleTaxInvoice::class)->name('report-sale-tax-invoice');

    Route::get("/report-invoice-overdue", ReportInvoiceOverdue::class)->name('report-invoice-overdue');

    Route::get("/report-payment-voucher-items", ReportPaymentVoucherItems::class)->name('report-payment-voucher-items');

    Route::get("/report-receipt-voucher", ReportReceiptVoucher::class)->name('report-receipt-voucher');

    Route::get("/report-tax-invoice", ReportTaxInvoice::class)->name('report-tax-invoice');

    Route::get("/report-payment-voucher", ReportPaymentVoucher::class)->name('report-payment-voucher');
});