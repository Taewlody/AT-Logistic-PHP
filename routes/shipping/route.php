<?php


use Illuminate\Support\Facades\Route;

use App\Livewire\Page\Shipping\PaymentVoucher\Page as PaymentVoucherShipping;
use App\Livewire\Page\Shipping\PettyCash\Page as PettyCashShipping;
use App\Livewire\Page\Shipping\Deposit\Page as Deposit;

Route::group(['prefix'=> 'shipping',], function() {
    Route::get('/payment-voucher', PaymentVoucherShipping::class)->name('shipping-payment-voucher');

    Route::get('/petty-cash', PettyCashShipping::class)->name('shipping-petty-cash');

    Route::get('/deposit', Deposit::class)->name('deposit');
});