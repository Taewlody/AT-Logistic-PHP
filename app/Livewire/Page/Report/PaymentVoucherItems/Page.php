<?php

namespace App\Livewire\Page\Report\PaymentVoucherItems;

use Livewire\Component;
use Livewire\WithPagination;

use App\Models\Payment\PaymentVoucher;

class Page extends Component
{
    public function render()
    {
        return view('livewire.page.report.payment-voucher-items.page',[ 
            'data'=> PaymentVoucher::with(['items', 'supplier', 'docStatus'])
            ->paginate(20)
            ])->extends('layouts.main')->section('main-content');
    }
}
