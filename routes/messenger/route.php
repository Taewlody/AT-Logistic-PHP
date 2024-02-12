<?php

use Illuminate\Support\Facades\Route;

use App\Livewire\Page\Messenger\CalendarBooking\Page as CalendarBooking;
use App\Livewire\Page\Messenger\CalendarBooking\Form as CalendarBookingForm;
use App\Livewire\Page\Messenger\MessengerBooking\Page as MessengerBooking;
use App\Livewire\Page\Messenger\MessengerBooking\Form as MessengerBookingForm;

Route::group(['prefix'=> 'messenger',], function() {
    Route::get("/calendar-booking", CalendarBooking::class)->name('calendar-booking');
    Route::get("/calendar-booking/form", CalendarBookingForm::class)->name('calendar-booking.form');

    Route::get("/messanger-booking", MessengerBooking::class)->name('messanger-booking');
    Route::get("/messanger-booking/form", MessengerBookingForm::class)->name('messanger-booking.form');
});