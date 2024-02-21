<?php

namespace App\Livewire\page\Account\WithholdingTax;

use Livewire\Component;

class Page extends Component
{
    public function render()
    {
        return view('livewire.page.account.withholding-tax.page')->extends('layouts.main')->section('main-content');
    }
}
