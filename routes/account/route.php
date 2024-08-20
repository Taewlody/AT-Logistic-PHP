<?php

use Illuminate\Support\Facades\Route;

use App\Livewire\Page\Account\Invoice\Page as Invoice;
use App\Livewire\Page\Account\Invoice\Form as InvoiceForm;
use App\Livewire\Page\Account\TaxInvoice\Page as TaxInvoice;
use App\Livewire\Page\Account\TaxInvoice\Form as TaxInvoiceForm;
use App\Livewire\Page\Account\PaymentVoucher\Page as PaymentVoucherAccount;
use App\Livewire\Page\Account\PaymentVoucher\Form as PaymentVoucherAccountForm;
use App\Livewire\Page\Account\ReceiptVoucher\Page as ReceiptVoucher;
use App\Livewire\Page\Account\ReceiptVoucher\Form as ReceiptVoucherForm;
use App\Livewire\Page\Account\BillingReceipt\Page as BillingReceipt;
use App\Livewire\Page\Account\BillingReceipt\Form as BillingReceiptForm;
use App\Livewire\Page\Account\PettyCash\Page as PettyCashAccount;
use App\Livewire\Page\Account\PettyCash\Form as PettyCashAccountForm;
use App\Livewire\Page\Account\WithholdingTax\Page as WithholdingTax;
use App\Livewire\Page\Account\WithholdingTax\Form as WithholdingTaxForm;
use App\Livewire\Page\Account\BillingSummary\Form as BillingSummary;

Route::group(['prefix'=> 'account',], function() {
    Route::get("/invoice", Invoice::class)->name('invoice');
    Route::get("/invoice/form", InvoiceForm::class)->name('invoice.form');

    Route::get("/billing-summary", BillingSummary::class)->name('billing-summary');

    Route::get("/tax-invoice", TaxInvoice::class)->name('tax-invoice');
    Route::get("/tax-invoice/form", TaxInvoiceForm::class)->name('tax-invoice.form');

    Route::get("/payment-voucher", PaymentVoucherAccount::class)->name('account-payment-voucher');
    Route::get("/payment-voucher/form", PaymentVoucherAccountForm::class)->name('account-payment-voucher.form');

    Route::get("/receipt-voucher", ReceiptVoucher::class)->name('receipt-voucher');
    Route::get("/receipt-voucher/form", ReceiptVoucherForm::class)->name('receipt-voucher.form');

    Route::get("/billing-receipt", BillingReceipt::class)->name('billing-receipt');
    Route::get("/billing-receipt/form", BillingReceiptForm::class)->name('billing-receipt.form');

    Route::get("/petty-cash", PettyCashAccount::class)->name('account-petty-cash');
    Route::get("/petty-cash/form", PettyCashAccountForm::class)->name('account-petty-cash.form');

    Route::get("/withholding-tax", WithholdingTax::class)->name('withholding-tax');
    Route::get("/withholding-tax/form", WithholdingTaxForm::class)->name('withholding-tax.form');
});