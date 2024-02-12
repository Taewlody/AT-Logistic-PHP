<?php

namespace App\Livewire\Page\Account\TaxInvoice;

use Livewire\Component;

class Form extends Component
{
    public function render()
    {
        return view('livewire.page.account.tax-invoice.form')->extends('layouts.main')->section('main-content');
    }
}
