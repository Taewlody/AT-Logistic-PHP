<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Page\Marketing\JobOrder\Page as JobOrder;
use App\Livewire\Page\Marketing\JobOrder\Form as JobOrderForm;
use App\Livewire\Page\Marketing\TrailerBooking\Page as TrailerBooking;
use App\Livewire\Page\Marketing\BillOfLading\Page as BillOfLading;

Route::group(['prefix' => '/marketing',], function() {
        Route::get('/job-order', JobOrder::class)->name('job-order');

        Route::get('/job-order/form', JobOrderForm::class)->name('job-order.form');

        Route::get('/trailer-booking', TrailerBooking::class)->name('trailer-booking');
    
        Route::get('/bill-of-lading', BillOfLading::class)->name('bill-of-lading');
    });