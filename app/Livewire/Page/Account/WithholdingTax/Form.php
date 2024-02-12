<?php

namespace App\Livewire\Page\Account\WithholdingTax;

use Livewire\Component;

class Form extends Component
{
    public function render()
    {
        return view('livewire.page.account.withholding-tax.form')->extends('layouts.main')->section('main-content');
    }
}
