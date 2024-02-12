<?php

namespace App\Livewire\Page\Account\BillingReceipt;

use Livewire\Component;

class Form extends Component
{
    public function render()
    {
        return view('livewire.page.account.billing-receipt.form')->extends('layouts.main')->section('main-content');
    }
}
