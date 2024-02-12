<?php

namespace App\Livewire\Page\Shipping\Deposit;

use Livewire\Component;

class Form extends Component
{
    public function render()
    {
        return view('livewire.page.shipping.deposit.form')->extends('layouts.main')->section('main-content');
    }
}
