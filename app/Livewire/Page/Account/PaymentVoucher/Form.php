<?php

namespace App\Livewire\Page\Account\PaymentVoucher;

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
        return view('livewire.page.account.payment-voucher.form')->extends('layouts.main')->section('main-content');
    }
}
