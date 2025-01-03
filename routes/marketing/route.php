<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Page\Marketing\JobOrder\Page as JobOrder;
use App\Livewire\Page\Marketing\JobOrder\Form as JobOrderForm;
use App\Livewire\Page\Marketing\TrailerBooking\Page as TrailerBooking;
use App\Livewire\Page\Marketing\TrailerBooking\Form as TrailerBookingForm;
use App\Livewire\Page\Marketing\BillOfLading\Page as BillOfLading;
use App\Livewire\Page\Marketing\BillOfLading\Form as BillOfLadingForm;

Route::group(['prefix' => '/marketing',], function() {
        Route::get('/job-order', JobOrder::class)->name('job-order');

        Route::get('/job-order/form', JobOrderForm::class)->name('job-order.form');

        Route::get('/trailer-booking', TrailerBooking::class)->name('trailer-booking');

        Route::get('/trailer-booking/form', TrailerBookingForm::class)->name('trailer-booking.form');
    
        Route::get('/bill-of-lading', BillOfLading::class)->name('bill-of-lading');

        Route::get('/bill-of-lading/form', BillOfLadingForm::class)->name('bill-of-lading.form');

        Route::get('/update-all-joborder', [JobOrder::class, 'updateTotalAll'])->name('update-all-joborder');
    });