<?php

namespace App\Livewire\Page\Account\BillingReceipt;

use App\Models\Marketing\JobOrder;
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
        return view('livewire.page.account.billing-receipt.form')->extends('layouts.main')->section('main-content');
    }
}
