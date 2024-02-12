<?php

namespace App\Livewire\Page\Account\Invoice;

use Livewire\Component;

class Form extends Component
{
    public function render()
    {
        return view('livewire.page.account.invoice.form')->extends('layouts.main')->section('main-content');
    }
}
