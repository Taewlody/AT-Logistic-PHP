<?php

use Illuminate\Support\Facades\Route;

use App\Livewire\Page\Customer\AdvancePayment\Page as AdvancePayment;


Route::group(['prefix' => '/customer',], function() {
    Route::get('/advance-payment', AdvancePayment::class)->name('advance-payment');
});