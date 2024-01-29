<?php

namespace App\Livewire\Page\Messenger\MessengerBooking;

use Livewire\Component;

class Page extends Component
{
    public function render()
    {
        return view('livewire.page.messenger.messenger-booking.page')->extends('layouts.main')->section('main-content');
    }
}
