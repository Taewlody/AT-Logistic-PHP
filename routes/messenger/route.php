<?php

use Illuminate\Support\Facades\Route;

use App\Livewire\Page\Messenger\CalendarBooking\Page as CalendarBooking;
use App\Livewire\Page\Messenger\MessengerBooking\Page as MessengerBooking;

Route::group(['prefix'=> 'messenger',], function() {
    Route::get("/calendar-booking", CalendarBooking::class)->name('calendar-booking');

    Route::get("/messanger-booking", MessengerBooking::class)->name('messanger-booking');
});