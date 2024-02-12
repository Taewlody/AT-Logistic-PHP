<?php

namespace App\Livewire\Page\Account\PaymentVoucher;

use Livewire\Component;

class Form extends Component
{
    public function render()
    {
        return view('livewire.page.account.payment-voucher.form')->extends('layouts.main')->section('main-content');
    }
}
