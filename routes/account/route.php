<?php

use Illuminate\Support\Facades\Route;

use App\Livewire\Page\Account\Invoice\Page as Invoice;
use App\Livewire\Page\Account\TaxInvoice\Page as TaxInvoice;
use App\Livewire\Page\Account\PaymentVoucher\Page as PaymentVoucherAccount;
use App\Livewire\Page\Account\ReceiptVoucher\Page as ReceiptVoucher;
use App\Livewire\Page\Account\BillingReceipt\Page as BillingReceipt;
use App\Livewire\Page\Account\PettyCash\Page as PettyCashAccount;
use App\Livewire\Page\Account\WithholdingTax\Page as WithholdingTax;

Route::group(['prefix'=> 'account',], function() {
    Route::get("/invoice", Invoice::class)->name('invoice')
    ;
    Route::get("/tax-invoice", TaxInvoice::class)->name('tax-invoice');

    Route::get("/payment-voucher", PaymentVoucherAccount::class)->name('account-payment-voucher');

    Route::get("/receipt-voucher", ReceiptVoucher::class)->name('receipt-voucher');

    Route::get("/billing-receipt", BillingReceipt::class)->name('billing-receipt');

    Route::get("/petty-cash", PettyCashAccount::class)->name('account-petty-cash');

    Route::get("/withholding-tax", WithholdingTax::class)->name('withholding-tax');
});