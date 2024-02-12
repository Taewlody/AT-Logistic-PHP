<?php

use Illuminate\Support\Facades\Route;

use App\Livewire\Page\Customer\AdvancePayment\Page as AdvancePayment;
use App\Livewire\Page\Customer\AdvancePayment\Form as AdvancePaymentForm;


Route::group(['prefix' => '/customer',], function() {
    Route::get('/advance-payment', AdvancePayment::class)->name('advance-payment');
    Route::get('/advance-payment/form', AdvancePaymentForm::class)->name('advance-payment.form');
});