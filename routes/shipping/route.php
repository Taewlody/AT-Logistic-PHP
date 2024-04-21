<?php



use Illuminate\Support\Facades\Route;

// use App\Livewire\Page\Shipping\PaymentVoucher\Page as PaymentVoucherShipping;
// use App\Livewire\Page\Shipping\PaymentVoucher\Form as PaymentVoucherShippingForm;
// use App\Livewire\Page\Shipping\PettyCash\Page as PettyCashShipping;
// use App\Livewire\Page\Shipping\PettyCash\Form as PettyCashShippingForm;
use App\Livewire\Page\Account\PaymentVoucher\Page as PaymentVoucher;
use App\Livewire\Page\Account\PaymentVoucher\Form as PaymentVoucherForm;
use App\Livewire\Page\Account\PettyCash\Page as PettyCash;
use App\Livewire\Page\Account\PettyCash\Form as PettyCashForm;
use App\Livewire\Page\Shipping\Deposit\Page as Deposit;
use App\Livewire\Page\Shipping\Deposit\Form as DepositForm;


Route::group(['prefix'=> 'shipping',], function() {
    // Route::get('/payment-voucher', PaymentVoucherShipping::class)->name('shipping-payment-voucher');
    // Route::get('/payment-voucher/form', PaymentVoucherShippingForm::class)->name('shipping-payment-voucher.form');

    Route::get('/payment-voucher', PaymentVoucher::class)->name('shipping-payment-voucher');
    Route::get('/payment-voucher/form', PaymentVoucherForm::class)->name('shipping-payment-voucher.form');

    // Route::get('/petty-cash', PettyCashShipping::class)->name('shipping-petty-cash');
    // Route::get('/petty-cash/form', PettyCashShippingForm::class)->name('shipping-petty-cash.form');

    Route::get('/petty-cash', PettyCash::class)->name('shipping-petty-cash');
    Route::get('/petty-cash/form', PettyCashForm::class)->name('shipping-petty-cash.form');

    Route::get('/deposit', Deposit::class)->name('deposit');
    Route::get('/deposit/form', DepositForm::class)->name('deposit.form');
});