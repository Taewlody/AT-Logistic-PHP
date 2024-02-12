<?php

namespace App\Livewire\Page\Account\TaxInvoice;

use Livewire\Component;
use Livewire\Attributes\Url;

class Form extends Component
{
    #[Url]
    public $action = '';
    #[Url]
    public $id = '';

    public function render()
    {
        return view('livewire.page.account.tax-invoice.form')->extends('layouts.main')->section('main-content');
    }
}
