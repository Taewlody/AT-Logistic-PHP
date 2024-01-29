<?php

namespace App\Livewire\Page\Messenger\CalendarBooking;

use Livewire\Component;

class Page extends Component
{
    public function render()
    {
        return view('livewire.page.messenger.calendar-booking.page')->extends('layouts.main')->section('main-content');
    }
}
