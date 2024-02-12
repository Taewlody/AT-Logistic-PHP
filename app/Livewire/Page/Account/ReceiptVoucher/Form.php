<?php

namespace App\Livewire\Page\Account\ReceiptVoucher;

use Livewire\Component;

class Form extends Component
{
    public function render()
    {
        return view('livewire.page.account.receipt-voucher.form')->extends('layouts.main')->section('main-content');
    }
}
